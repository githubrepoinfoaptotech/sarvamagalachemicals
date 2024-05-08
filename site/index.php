<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, X-Auth-Token, Authorization, Origin');
header('Access-Control-Allow-Methods: POST, PUT, GET, DELETE');
error_reporting(E_ALL);
ini_set('display_errors', 1);
$path_url = '/site/api'; 

$requestUri = $_SERVER['REQUEST_URI'];
$uriParts = explode('?', $requestUri);
$uri = $uriParts[0];
require_once 'PHPMailer-master/src/PHPMailer.php';
require_once 'PHPMailer-master/src/SMTP.php';
require_once 'PHPMailer-master/src/Exception.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
switch ($uri) {

    //analyticsController
        
    case $path_url . '/send_mail':
        sendMail();
        break;
    default:
        echo "Not found: 404";
}


  function sendMail()
   {
    $data = json_decode(file_get_contents('php://input'), true);
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'mail.infoaptotech.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'vishal@infoaptotech.com';
        $mail->Password   = 'Atlanta*90';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $mail->setFrom('info@infoapto.com', 'Infoapto');
        $mail->addAddress('vishallegend7775@gmail.com', 'Sarvamangala Chemicals');

        $mail->isHTML(true);

        $mail->Subject = "New Contact Inquiry: " . $data['subject'];
        
        // HTML content for the email
        $htmlContent = "
            <html>
            <head>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        margin: 20px;
                    }
                    .container {
                        max-width: 600px;
                        margin: 0 auto;
                    }
                    .header {
                        background-color: #f4f4f4;
                        padding: 20px;
                        text-align: center;
                    }
                    .content {
                        padding: 20px;
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h2>New Contact Inquiry</h2>
                    </div>
                    <div class='content'>
                        <p><strong>Subject:</strong> {$data['subject']}</p>
                        <p><strong>Name:</strong> {$data['name']}</p>
                        <p><strong>Email:</strong> {$data['email']}</p>
                        <p><strong>Message:</strong><br>{$data['message']}</p>
                    </div>
                </div>
            </body>
            </html>
        ";

        $mail->Body = $htmlContent;

        $mail->send();

        echo json_encode(array("status" => true, "message" => "Mail Has Been Sent"));
    } catch (Exception $e) {
        echo json_encode(array("status" => false, "message" => "Error: {$mail->ErrorInfo}"));
    }
}
?>