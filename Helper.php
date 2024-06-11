<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

const PATH_ROOT = __DIR__ . '/';
if (!function_exists('asset')) {
    function asset($path)
    {
        return $_ENV['BASE_URL'] . $path;
    }
}

if (!function_exists('url')) {
    function url($uri = null)
    {
        return $_ENV['BASE_URL'] . $uri;
    }
}

if (!function_exists('redirect')) {
    function redirect($uri)
    {
        return header('Location: ' . $_ENV['BASE_URL'] . $uri);
    }
}

function sendMail($to, $subject, $content)
{
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'huyndph45505@fpt.edu.vn';                     //SMTP username
        $mail->Password   = 'yasterexwqrmmduz';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('huyndph45505@fpt.edu.vn', 'Mailer');
        $mail->addAddress($to);     //Add a recipient

        // Bảo mật email chứng chỉ ssl
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        //Content
        $mail->CharSet = "UTF-8";
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $content;
        $sendMail =  $mail->send();
        if ($sendMail) {
            return $sendMail;
        }
        echo 'Gửi email thành công';
    } catch (Exception $e) {
        echo "Gửi email thất bại. Mailer Error: {$mail->ErrorInfo}";
    }
}

if (!function_exists('is_logged')) {
    function is_logged()
    {
        return isset($_SESSION['user']);
    }
}

if (!function_exists('is_admin')) {
    function is_admin()
    {
        return is_logged() && $_SESSION['user']['type'] == 'admin';
    }
}

if (!function_exists('avoid_login')) {
    function avoid_login()
    {

        if (is_logged()) {
            if ($_SESSION['user']['type'] == 'admin') {
                redirect('admin');
                exit();
            }
            header('Location: ' . url('Xuong-oop/admin'));
            exit();
        }
    }
}
