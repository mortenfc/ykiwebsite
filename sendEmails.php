<?php
require_once './vendor/autoload.php';

// Create the Transport
$transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
// $transport = (new Swift_SmtpTransport('smtp.mailgun.org', 2525, 'ssl'))
  ->setUsername('mortenfjordchristensen@gmail.com')
  ->setPassword('Irememberthis222');

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

function sendVerificationEmail($userEmail, $token)
{
  
  global $mailer;
  $body = '
  <!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Test mail</title>
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
              href="http://localhost/multiLoginOOP/verify_email.php?token=' . $token . '">Verify Email!</a>
            </div>
          </td>
        </tr>
      </table>
    </body>

  </html>
  ';

  // Create a message
  $message = (new Swift_Message('Verify your email'))
    ->setFrom('mortenfjordchristensen@gmail.com')
    ->setTo($userEmail)
    ->setBody($body, 'text/html');

  // Send the message
  $result = $mailer->send($message);

  if ($result > 0) {
    echo "Succes!";
    return true;
  } else {
    echo "Failure...";
    return false;
  }
}
