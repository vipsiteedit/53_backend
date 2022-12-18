<?php

/** -------------------------------------------------------------- //
* Отправка почты с аттачем
* @param string $subject	-	тема_письма
* @param string $to_email	-	мыло@получателя
* @param string $from_email	-	мыло@отправителя
* @param string $msg		-	тело_письма(если нужно)
* @param string $contenttype	Тип письма ('text/plain' - текст, 'text/html' - html)
* @param string $filename	-	имя_файла
* @param string $filepath	-	путь_к_файлу
* @param string $mimetype	-	тип_аттача(например image/jpeg или application/octet-stream)
* @param string $mime_filename - определять тип по имени
* Пример: 
* $mailfile = new plugin_mail("тема_письма","мыло@получателя","мыло@отправителя",
* 			"тело_письма(если нужно)",'', "имя_файла","путь_к_файлу","тип_аттача(например image/jpeg)","");
* $mailfile->sendfile();
**/ 

class plugin_mail
{
    private $mail;
    
    public function __construct($subject, $to_email, $from_email, $msg,  $contenttype= '',$filename = '', $mimetype = "application/octet-stream", $mime_filename = false)
    {
        if (!$contenttype) {
            $contenttype = 'text/plain';
        }
        
        $settings = new plugin_shopsettings();
        
        $smtp_login = $settings->getValue("smtp_login");
        $smtp_password = $settings->getValue("smtp_password");
                
        if (!empty($smtp_login) && !empty($smtp_password)) {            
            require_once SE_ROOT . 'lib/PHPMailer.php';
            
            $this->mail = new PHPMailer\PHPMailer\PHPMailer(true);  

            $data = array(
                'host' => $settings->getValue("smtp_server"),
                'port' => $settings->getValue("smtp_port"),
                'login' => $settings->getValue("smtp_login"),
                'password' => $settings->getValue("smtp_password"),
                'from' => $settings->getValue("smtp_from_name"),
            );
            
            if (empty($data['from'])) {
                $data['from'] = $data['login'];
            }
            
            $this->mail->isSMTP();
            $this->mail->CharSet = "utf-8";
            $this->mail->SMTPDebug = 0;
            $this->mail->Debugoutput = 'html';
            $this->mail->Host = $data['host'];
            $this->mail->SMTPSecure = 'ssl'; 
            $this->mail->SMTPAuth = true;
            $this->mail->Port = $data['port'];
            $this->mail->Username = $data['login'];
            $this->mail->Password = $data['password'];            
            $this->mail->addAddress(trim($to_email));            
            $this->mail->setFrom($data['login'], $data['from']);
            //$this->mail->addReplyTo('noreply@'. $_SERVER['HTTP_HOST'], 'Name');
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body = $msg; 
            
            if (!empty($filename)){
                $silelist = explode(';', $filename);
                foreach($silelist as $file){
                    $file = trim($file);
                    if (empty($file)) continue;
                    $this->mail->addAttachment($file);
                }
            }
            
            $this->log('from smtp: ' . $to_email . ' data: ' . print_r($data, 1));

        } else {
            $this->log('from sendmail: ' . $to_email);
            
            $from_email = 'noreply@'. $_SERVER['HTTP_HOST'];
            $this->mail = new plugin_jmail(stripslashes($subject), $to_email, $from_email);
            $this->mail->addtext($msg, $contenttype);
            if (!empty($filename)){
                $silelist = explode(';', $filename);
                foreach($silelist as $file){
                    $file = trim($file);
                    if (empty($file)) continue;
                    $this->mail->attach($file, '', $mimetype);
                }
            }
        }

    }
    
    public function sendfile()
    {        
        try {
            $result = $this->mail->send();
            $this->log('result: ' .$result);
            return $result;
        } catch (Exception $e) {
            $this->log('error: ' . $this->mail->ErrorInfo);
            return false;
        }
    }
    
    private function log($data)
    {
        $data = date('[Y-m-d H:i:s]').' '.$data."\r\n";
        
        $dir = getcwd().'/system/logs/sendmail';
        
        if (!is_dir($dir))
            mkdir($dir);
        
        $filename = $dir . '/' . date('Y-m-d') . '.log';
        
        file_put_contents($filename, $data, FILE_APPEND);
    }
}