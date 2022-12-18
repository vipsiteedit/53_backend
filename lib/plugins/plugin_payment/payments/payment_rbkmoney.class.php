<?php
class payment_rbkmoney extends basePayment
{
    
	private $shopID;
	private $apiKey;
	private $webhookKey;
    
    public function __construct($order_id = 0, $payment_id = 0)
	{
		parent::__construct($order_id, $payment_id);   
		
		if (!file_exists(SE_ROOT . '/system/logs/rbk_money_payment.upd')) {
			$sql = "ALTER TABLE bank_accounts CHANGE COLUMN value value TEXT DEFAULT NULL";
			
			$result = se_db_query($sql);
			file_put_contents(SE_ROOT . '/system/logs/rbk_money_payment.upd', date('Y-m-d H:i:s - ') . $result);
		}
		
		$this->macros = new plugin_macros(0, $this->order_id, $this->payment_id);
        
        $this->shopID = $this->macros->execute('[PAYMENT.SHOPID]');
        $this->apiKey = $this->macros->execute('[PAYMENT.APIKEY]');
        $this->webhookKey = $this->macros->execute('[PAYMENT.WEBHOOKKEY]');
		
	}
	
    public function setVars()
    {
        return array(
            'shopID' => 'Идентификатор магазина из RBKmoney', 
            'apiKey' => 'Ключ для доступа к API',
            'webhookKey' => 'Публичный ключ',
        );
    }   

    public function startform() 
    {
        return $this->macros->execute($this->startform);
    }

    public function blank($pagename) 
    {
        if ($this->status == 'Y') {
            return $this->success(); 
        }
        
        $invoice = $this->createInvoice();
        
        if ($invoice['invoice']['id'] && $invoice['invoiceAccessToken']['payload']) {
            $blank = '<form action="[MERCHANT_SUCCESS]" method="GET">
                <script src="https://checkout.rbk.money/checkout.js" class="rbkmoney-checkout"
                    data-invoice-id="' . $invoice['invoice']['id'] . '"
                    data-invoice-access-token="' . $invoice['invoiceAccessToken']['payload'] . '"       
                    data-name="Заказ № [ORDER.ID]"
                    data-email="[USER.USEREMAIL]"
                    data-label="Оплатить заказ"
                    data-description=""
                    data-pay-button-label="Оплатить">
                </script>
            </form>';
        }
        else {
            return $this->fail();
        }
        
        return $this->macros->execute($this->getPathPayment($blank, $pagename));
    }
    
	
    public function result($test = false) 
    {   
        $result = $this->checkResult();
        
        $this->log($result);

        if ($result['eventType'] == 'InvoicePaid' && $result['invoice']['status'] == 'paid') {
            $this->order_id = intval($result['invoice']['metadata']['order_id']);
            $this->macros = new plugin_macros(0, $this->order_id, $this->payment_id);
            $amount = round($this->macros->execute("[SETCURRENCY:RUB][ORDER.SUMMA]") * 100);
            if ($amount == $result['invoice']['amount']) {
                $res = $this->getPaymentLog();
                $result = $this->activate($this->order_id, false, '', $this->order_id, $result['eventID'], $this->name_payment);
            }
            else {
                $this->log('incorrect amount ' . $amount);
            }
        } else {
            $this->log('incorrect invoice');
        }
        exit;
        }

    public function success()
    {
        if (empty($this->success)) {
            $this->success = '<h4 class="contentTitle">Оплата проведена успешно</h4><br>
    Ваш заказ № [ORDER.ID] оплачен <table class="tableTable" border="0">
    <tbody class="tableBody">
    <tr><td>Номер счета:</td><td>[PAY.PAY_NUM]</td></tr>
    <tr><td>Номер платежа:</td><td>[PAY.TRANS_NUM]</td></tr>
    <tr><td>Дата и время платежа:</td><td>[PAY.TRANS_DATE]</td></tr>
    </tbody></table>';
        }
        $this->success = str_replace(array('[PAY.PAY_NUM]','[PAY.TRANS_NUM]','[PAY.TRANS_DATE]'), array($_POST['orderId'],$_POST['userEmail'], $_POST['paymentData']), $this->success);
        $this->success = $this->macros->execute($this->success);  
        return $this->success;
        
    }

    public function fail() 
    {
        return $this->macros->execute($this->fail);
    }
    
    private function prepare_headers($apiKey)
	{
		$headers = array();
		$headers[] = 'X-Request-ID: ' . uniqid();
		$headers[] = 'Authorization: Bearer ' . $apiKey;
		$headers[] = 'Cache-Control: no-cache';
		$headers[] = 'Content-type: application/json; charset=utf-8';
		$headers[] = 'Accept: application/json';
		return $headers;
	}
	
	private function request($url, $data, $method = 'POST')
    {
		$curl = curl_init();
		curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => $this->prepare_headers($this->apiKey),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
            return array("error"=>"cURL Error #:" . $err);
		} else {
            return json_decode($response, true);
		}
	}
    
    private function createInvoice()
	{
		$data = array(
            'shopID' => $this->shopID,
            'dueDate' => gmdate("Y-m-d\TH:i:s\Z", time() + (3600 * 3)),
            'amount' => round($this->macros->execute("[SETCURRENCY:RUB][ORDER.SUMMA]") * 100),
            'currency' => 'RUB',
            'product' => 'Заказ № ' . $this->macros->execute("[ORDER.ID]"),
            //'description' => 'Заказ № ' . $this->order_id,
            'cart' => array(),
            'metadata' => array(
                'order_id' => $this->order_id,
            ),
        );
        
        $amount = (float)$this->macros->execute('[ORDER.SUMMA]');
        $discount = (float)$this->macros->execute('[SHOP_ORDER_DISCOUNT]');
        
        $k = $amount / ($amount + $discount);
        
        $t = new seTable('shop_tovarorder');
        $t->select('nameitem, price, discount, count');
        $t->where('id_order=?', $this->order_id);
        $list = $t->getList();
        
        foreach ($list as $val) {
            $data['cart'][] = array(
                'product' => $val['nameitem'],
                'quantity' => (int)$val['count'],
                'price' => round(($val['price'] - $val['discount']) * $k, 2)*100,
                'taxMode'=>array('rate'=>'0%', 'type'=>'InvoiceLineTaxVAT')
            );
        }
        
        if ($delivery_name = $this->macros->execute("[ORDER.DELIVERY_NAME]")) {
            $price_delivery = $this->macros->execute("[ORDER_DELIVERY]");
            
            $receipt['items'][] = array(
                'product' => 'Доставка заказа ' . $delivery_name,
                'quantity' => 1,
                'price' => round($price_delivery * $k, 2)*100,
                'tax' => 1,
            );
        }
        
        return $this->request("https://api.rbk.money/v1/processing/invoices", $data);
	}
    
    private function get_signature_from_header($contentSignature) 
	{
        $signature = preg_replace("/alg=(\S+);\sdigest=/", '', $contentSignature);

        if (empty($signature)) {
			echo 'Signature is missing';
			exit;
        }

        return $signature;
    }

    private function urlsafe_base64decode($string) 
    {
        return base64_decode(strtr($string, '-_,', '+/='));
    }

    private function verify_signature($data, $signature, $publicKey) 
    {
        if (empty($data) || empty($signature) || empty($publicKey)) {
            return FALSE;
        }

        $publicKeyId = openssl_get_publickey($publicKey);
        if (empty($publicKeyId)) {
            return FALSE;
        }
        $verify = openssl_verify($data, $signature, $publicKeyId, 7);

        return ($verify == 1);
    }

    private function checkResult()
    {
        // Достаем сигнатуру из заголовка и декодируем
        $signatureFromHeader = $this->get_signature_from_header($_SERVER['HTTP_CONTENT_SIGNATURE']);
        // Декодируем данные
        $decodedSignature = $this->urlsafe_base64decode($signatureFromHeader);
        // Данные, которые пришли в теле сообщения
        $content = file_get_contents('php://input');

        if(!$this->verify_signature($content, $decodedSignature, $this->webhookKey)) {
            http_response_code(400);
            return json_encode(array('message' => 'Webhook notification signature mismatch'));
        }
        return json_decode($content, TRUE);
    }
    
    private function log($text) 
    {
		$log_dir = SE_ROOT . 'system/logs/rbkMoney/';
        
		if (!is_dir($log_dir))
			mkdir($log_dir);
            
		$log_file = $log_dir . date('Y-m-d') . '.log';
        
        if (is_array($text)) {
            $text = print_r($text, true);
        }
        
		$text = date('[Y-m-d H:i:s]') . ' ' . $text . "\r\n";
		$file = fopen($log_file, 'ab');
		fwrite($file, $text);
		fclose($file);	
	}   
}