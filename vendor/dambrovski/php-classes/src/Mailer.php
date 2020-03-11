<?php

namespace dambrovski;

use Rain\Tpl;


class Mailer{

    const USERNAME = 'airtonbiovea@gmail.com';
    const PASSWORD = 'jucabala23';
    const NAME_FROM = 'Dambrovski Store';

    private $mail;
    public function __construct($toAddress, $toName,  $subject, $tplName, $data = array())
    {
        $tpl_dir = "/views/email/";
        $config = array(
            "tpl_dir"       => $_SERVER['DOCUMENT_ROOT']. $tpl_dir,
            "cache_dir"     => $_SERVER['DOCUMENT_ROOT']."/views-cache/",
            "debug"         => false 
           );

        Tpl::configure( $config );

        $tpl = new Tpl;
        
        foreach ($data as $key => $value) {
            $tpl->assign($key, $value);
        }
        $html = $tpl->draw($tplName, true);
        $this->mail = new \PHPMailer;

        $this->mail->isSMTP();
        $this->mail->SMTPDebug = 1;
        $this->mail->Host = 'smtp.gmail.com';
        $this->mail->Port = 587;
        $this->mail->SMTPSecure = 'tls';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = Mailer::USERNAME;
        $this->mail->Password = Mailer::PASSWORD;
        $this->mail->setFrom(Mailer::USERNAME, Mailer::NAME_FROM);
        $this->mail->addAddress($toAddress, $toName);
        $this->mail->Subject = $subject;
        $this->mail->msgHTML($html);
        $this->mail->AltBody = 'This is a plain-text message body';
    }
    
    public function sendEmail()
    {
        return $this->mail->send();
    }
}
    


?>