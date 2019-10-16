<?php

require 'vendor/autoload.php';
// require_once 'consolejs.php';

use Mailgun\Mailgun;

$mg = Mailgun::create('key-0c4171dbc9ce49ac245077abb7035fa3', 'https://api.eu.mailgun.net/v3');
// $mg = Mailgun::create('1b8fbeced8d7f5b886f0d13a7867d2d7-bbbc8336-cc292e9e', 'https://api.eu.mailgun.net/v3/ykitest.website');

function sendVerificationEmail($userEmail, $token)
{
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
              href="http://35.228.138.194/verify_email.php?token=' . $token . '">Verify Email!</a>
            </div>
          </td>
        </tr>
      </table>
    </body>

  </html>
	';

  global $mg;
  $mg->messages()->send('ykitest.website', [
    'from'    => 'yki@ykitest.website',
    'to'      => $userEmail,
    'subject' => 'Ykiwebsite Activation Link',
    'text'    => 'Your email client does not support HTML',
    'html'    => $body
  ]);

}
?>
