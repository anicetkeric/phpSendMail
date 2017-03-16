# phpSendMail
Send email through PHP Mailer and Gmail SMPT.

# Overview

PHPMailer is a PHP class for PHP (www.php.net) that provides a package of functions to send email. The two primary features are sending HTML Email and e-mails with attachments. PHPMailer supports nearly all possiblities to send email: mail(), Sendmail, qmail & direct to SMTP server. You can use any feature of SMTP-based e-mail, multiple recepients via to, CC, BCC, etc. In short: PHPMailer is an efficient way to send e-mail within PHP. 
http://phpmailer.worxware.com/?pg=tutorial


# PHP example.
Download a recent version of PHPMailer [Here](https://github.com/PHPMailer/PHPMailer). Current version 5.2.

### MailSender.php class
You can use gmail smtp or your smtp server settings. change gmail variable value (True or False)
```php

<?php

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');
require_once 'PHPMailer/PHPMailerAutoload.php';
require_once 'PHPMailer/class.phpmailer.php';

class MailSender{
       private $_mailer;
       private $_result='';
       private $_state=false;
       private  $_recipient;
       private $_subject;
       private $_message;
       private $_BCC;//$this->_mailer->addBCC($this->_BCC);
       private $_gmail=true;

    public function __construct(){

    $this->_mailer = new PHPMailer;


    $this->_mailer->IsSMTP();// Set mailer to use SMTP
    $this->_mailer->SMTPAuth = true; // Set mailer to use SMTP
        if ($this->_gmail) {
            $this->_mailer->Host = 'smtp.gmail.com';  // Gmail smtp
            $this->_mailer->Port = 465; // TCP port to connect to (Defaut 25)
            $this->_mailer->SMTPSecure = true;
            $this->_mailer->SMTPSecure = "ssl";// Enable TLS encryption, `ssl` also accepted /secure transfer enabled REQUIRED for Gmail
        }else{
            $this->_mailer->Host = '<your_smtp_server>';  // Specify main and backup server //stmp entrant sortant
        }

	$this->_mailer->SMTPDebug  = 0;  	// Enable SMTP authentication
    $this->_mailer->Username = 'example@gmail.com';  // SMTP username
    $this->_mailer->Password = '<your_smtp_password>';  // SMTP password



    $this->_mailer->addReplyTo("name@example.com", "Recepient Name");
    $this->_mailer->From = 'name@example.com';
    $this->_mailer->FromName = 'INFO MAILER';


    }


    public function sendMail(){
        // Add a recipient
        $this->_mailer->addAddress($this->_recipient);
        $this->_mailer->addBCC($this->_BCC);


        $this->_mailer->isHTML(true);  // Set email format to HTML

        $this->_mailer->Subject = $this->_subject;

// HTML email body

        $body  = "<html><body>";

        $body .= "<table width='100%' bgcolor='#e0e0e0' cellpadding='0' cellspacing='0' border='0'>";

        $body .= "<tr><td>";

        $body .= "<table align='center' width='100%' border='0' cellpadding='0' cellspacing='0' style='max-width:650px; background-color:#fff; font-family:Verdana, Geneva, sans-serif;'>";

        $body .= "<thead>
						<tr height='80'>
							<th colspan='4' style='background-color:#f5f5f5; border-bottom:solid 1px #bdbdbd; font-family:Verdana, Geneva, sans-serif; color:#333; font-size:34px;'>PHP SEND MAIL</th>
						</tr>
						</thead>";

        $body .= "<tbody>
						<tr align='center' height='50' style='font-family:Verdana, Geneva, sans-serif;background-color:#00a2d1;'>
						<td colspan='4' align='center' style='background-color:#f5f5f5; border-top:dashed #00a2d1 2px; font-size:24px; '>
						</tr>

						<tr>
							<td colspan='4' style='padding:15px;'>
								<p style='font-size:20px;'>Hello ,</p>
								<p style='font-size:13px; font-family:Verdana, Geneva, sans-serif; text-justify: auto'>". $this->_message.".</p>
							</td>
						</tr>

						<tr height='80'>
							<td colspan='4' align='center' style='background-color:#f5f5f5; border-top:dashed #00a2d1 2px; font-size:24px; '>
							<p style='font-size:10px; font-family:Verdana, Geneva, sans-serif; text-align:center'>Please do not reply to this email This is an automatic email. If you answer, it can not be read. This message has been sent to .$this->_recipient.'</p>
							<label>
							Find us on :
							<a href='#' target='_blank'><img style='vertical-align:middle' src='https://cdnjs.cloudflare.com/ajax/libs/webicons/2.0.0/webicons/webicon-facebook-m.png' /></a>
							<a href='#' target='_blank'><img style='vertical-align:middle' src='https://cdnjs.cloudflare.com/ajax/libs/webicons/2.0.0/webicons/webicon-twitter-m.png' /></a>
							<a href='#' target='_blank'><img style='vertical-align:middle' src='https://cdnjs.cloudflare.com/ajax/libs/webicons/2.0.0/webicons/webicon-googleplus-m.png' /></a>
							<a href='#' target='_blank'><img style='vertical-align:middle' src='https://cdnjs.cloudflare.com/ajax/libs/webicons/2.0.0/webicons/webicon-rss-m.png' /></a>
							</label>
							</td>
						</tr>

						</tbody>";

        $body .= "</table>";

        $body .= "</td></tr>";
        $body .= "</table>";

        $body .= "</body></html>";

        // HTML email body


        $this->_mailer->AltBody = $this->_message;
        $this->_mailer->MsgHTML($body);
        if(!$this->_mailer->send()) {
            $this->_result = '<p> Mail error:' .$this->_mailer->ErrorInfo;
            $this->_state=false;
        }else{
            $this->_result = '<p> Message sent!</p>';
            $this->_state=true;
        }
    }
    public function getresult(){
        return $this->_result;
    }
    public function setrecipient($value){
        $this->_recipient=$value;
    }
    public function setsubject($value){
        $this->_subject=$value;
    }
    public function setMessage($value){
        $this->_message=$value;
    }
    public function setBBC($value){
        $this->_BCC=$value;
    }

    public function setstate($state)
    {
        $this->_state = $state;
    }

    public function getstate()
    {
        return $this->_state;
    }

}

```

### Usage
```php
<?php

require_once 'MailSender.php';

$mailSender = new MailSender();


$mailSender->setsubject("PHPMailer Test Subject via Sendmail, basic");


$mess='This is the plain text version of the email content';

$mailSender->setMessage($mess);
$mailSender->setrecipient("<email_recipient>");

$mailSender->sendMail();
echo $mailSender->getresult();

```

### Output
![capture 2](https://github.com/anicetkeric/phpSendMail/blob/master/Capture.PNG)
