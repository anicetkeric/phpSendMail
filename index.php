<?php
/**
 * Created by PhpStorm.
 * User: ANICET ERIC KOUAME
 * Date: 08/03/2017
 * Time: 21:32
 */
require_once 'MailSender.php';

$mailSender = new MailSender();


$mailSender->setsubject("PHPMailer Test Subject via Sendmail, basic");


$mess='This is the plain text version of the email content';

$mailSender->setMessage($mess);
$mailSender->setrecipient("<email_recipient>");

$mailSender->sendMail();
echo $mailSender->getresult();