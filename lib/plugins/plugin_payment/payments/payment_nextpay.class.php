<?php
require_once dirname(__FILE__)."/basePayment.class.php";
    
class payment_nextpay extends basePayment
{

    public function setVars()
    {
        return array(
            'secret' => 'Секретный ключ', 
            'product_id' => 'ID продукта в системе NextPay.ru', 
            'payment_id' => 'ID платежной системы по умолчанию',
        );
    }

    public function startform()
    {
        $this->mlog('start startform');
        
        $macros = new plugin_macros(0, $this->order_id, $this->payment_id);
        return $macros->execute($this->startform);
    }

    public function blank($pagename)
    {
        $this->mlog('start blank');
        
        $macros = new plugin_macros(0, $this->order_id, $this->payment_id);
        
        $secret = $macros->execute('[PAYMENT.SECRET]');
        $product_id = $macros->execute('[PAYMENT.PRODUCT_ID]');
        
        $url = 'http://nextpay.ru/shop/shop/index.php';
        
        $this->newPaymentLog();
        
        $amount = $macros->execute('[ORDER.SUMMA]');
        
        $data = array(
            'command' => 'xml_api_ext',
            'product_id' => $product_id,
            'volute' => $macros->execute('[PAYMENT.PAYMENT_ID]'),
            'ext_order_cost' => $amount,
            'seller_ext_order_id' => $this->order_id,
            'np_email' => $macros->execute('[USER.USEREMAIL]'),
            'np_payer' => $macros->execute('[USER.LASTNAME]') . ' ' . $macros->execute('[USER.FIRSTNAME]') . ' ' . $macros->execute('[USER.SECNAME]'),
            'phone' => $macros->execute('[USER.PHONE]'),
            'hash' => sha1($product_id . $amount . $secret),
        );
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url . '?' . http_build_query($data));
        //curl_setopt($curl, CURLOPT_POST, true);
        //curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);

        curl_close($curl);
        
        $result = $this->parseXml($response);

        if ($result) {
            if (!empty($result['url'])) {
                header('Location:' . $result['url']);
                exit;
            }
        }
        else {
            $this->mlog($response);
        }
        
        return $blank;
    }
    
    private function parseXml($xml)
    {
        $domXml = simplexml_load_string($xml);
        
        $arr = array();
        if (!empty($domXml->result)) {
            echo 'error';
            return;
        } 
        else {
            $arr = array(
                'order_id' => (string)$domXml->order_id,
                'url' => (string)$domXml->data,
            );

            return $arr;
        }
    }

    public function result()
    {
        $this->mlog('start result');
        
        $this->order_id = getRequest('seller_ext_order_id');
        
        $this->mlog(print_r($_REQUEST, 1));
        
        if (isRequest('validate')) {
            return $this->validate();
        }
        else {
            $macros = new plugin_macros(0, $this->order_id, $this->payment_id);
            $secret = $macros->execute('[PAYMENT.SECRET]');
            
            $res = $this->getPaymentLog();
            
            $hash = sha1(getRequest('test') . getRequest('product_id') . getRequest('order_id') . getRequest('currency') . getRequest('cost_general') . getRequest('cost') . getRequest('profit') . getRequest('commission') . $secret);
            
            if ($hash == getRequest('hash')) {
                $amount = $macros->execute('[ORDER.SUMMA]');
                if (getRequest('cost_general') >= $amount) {
                    if (!getRequest('test'))
                        $this->activate($this->order_id);
                    $this->mlog('return ok');
                    echo 'ok';
                }
                else {
                    $this->mlog('error amount');
                }
                
            }
            else {
                $this->mlog('error hash ' . $hash . ' - ' . getRequest('hash'));
            }
        }
    }
    
    public function validate()
    {
        $this->mlog('start validate');
        
        $macros = new plugin_macros(0, $this->order_id, $this->payment_id);
        
        if ($macros->execute('[ORDER.ID]') == $this->order_id) {
            $amount = $macros->execute('[ORDER.SUMMA]');
            if (getRequest('cost_general') >= $amount) {
                echo 'ok';
            };
        }
        else {
            echo 'invalid_order_id';
        }
    }
    
    public function success()
    {
        $this->mlog('start success');
        
        $macros = new plugin_macros(0, $this->order_id, $this->payment_id);
        return $macros->execute($this->success);
    }

    public function fail()
    {
        $this->mlog('start fail');
        
        $macros = new plugin_macros(0, $this->order_id, $this->payment_id);
        return $macros->execute($this->fail);
    }
    
    public function mlog($text)
    {
        $dir = SE_ROOT . 'system/logs/nextpay';
        
        if (!is_dir($dir))
            mkdir($dir);
        
        $filename = $dir . '/' . date('Y-m-d') . '.log';
        
        $text = date('[Y-m-d H:i:s]') . ' ' . $text . "\r\n";
        
        $file = fopen($filename, 'ab');
        fwrite($file, $text);
        fclose($file);
    }
}