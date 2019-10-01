<?php
require 'PHPMailerAutoload.php';

$mail = new PHPMailer;

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.mailgun.org;smtp2.example.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'postmaster@sandbox763caaa1cff3456a8f9123ba8bea1c15.mailgun.org';                 // SMTP username
$mail->Password = '398b3ce20ebcac62424da73d9941e19d-bbbc8336-c3da3adc';                           // SMTP password
$mail->SMTPSecure = 'ssl';                            // Enable encryption, 'ssl' also accepted
$mail->From = 'mortenfjordchristensen@gmail.com';
$mail->FromName = 'Ykiwebsite';


function sendVerificationEmail($userEmail, $token, $name)
{
  global $mail;

  $mail->addAddress($userEmail, $name);     // Add a recipient
  // $mail->addAddress('ellen@example.com');               // Name is optional
  // $mail->addReplyTo('info@example.com', 'Information');
  // $mail->addCC('cc@example.com');
  // $mail->addBCC('bcc@example.com');

  $mail->WordWrap = 500;                                 // Set word wrap to 50 characters
  // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
  // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
  $mail->isHTML(true);                                  // Set email format to HTML

  $mail->Subject = 'Ykiwebsite Activation Link';
  $mail->Body = '
  <!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Ykiwebsite Activation Link</title>
    </head>
    
    <body>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center">
            <div style="
            padding: 20px;
            color: #444;
            font-size: 1.3em;
            ">
              <h3 style="color: #00bfff; weight: bold;">Activation Link</h3>
              <p>Thank you for signing up on our site. Please click on the link below to verify your account:</p>
              <a style="
              padding: 15px 32px;
              text-align: center;
              margin-left: auto;
              margin-right: auto;
              text-decoration: none;
              display: inline-block;
              font-size: 16px;
              margin: 4px 2px;
              cursor: pointer;
              background-color: white; 
              color: black; 
              weight: bold;
              border: 2px solid #00bfff;
              "
              href="http://35.228.138.194/verify_email.php?token=' . $token . '">Verify Email!</a>
            </div>
          </td>
        </tr>
      </table>
    </body>

  </html>
  ';

  $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

  if (!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
  } else {
    echo 'Message has been sent';
  }
}
