<?php
// mail.php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';  // depending on where PHPMailer is installed

function sendMail($to, $subject, $bodyHtml, $bodyPlain = '') {
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com';                // your SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = 'you@example.com';             // SMTP username
        $mail->Password = 'your_email_password';          // SMTP password
        $mail->SMTPSecure = 'tls';                        // or 'ssl'
        $mail->Port = 587;                                // or 465 for SSL

        //Recipients
        $mail->setFrom('noreply@yourdomain.com', 'YourAppName');
        $mail->addAddress($to);

        //Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $bodyHtml;
        $mail->AltBody = $bodyPlain ?: strip_tags($bodyHtml);

        $mail->send();
        return true;
    } catch (Exception $e) {
        // handle error, maybe log
        error_log("Mail error: " . $mail->ErrorInfo);
        return false;
    }
}
