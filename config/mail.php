<?php
require_once __DIR__ . '/bootstrap.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendClientEmail(string $nomComplet, string $age): bool {
    $host = env_value('SMTP_HOST');
    $user = env_value('SMTP_USER');
    $pass = env_value('SMTP_PASS');
    $to = env_value('MAIL_TO');

    if (!$host || !$user || !$pass || !$to) {
        return false;
    }

    try {
        $mail = new PHPMailer(true);
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();
        $mail->Host = $host;
        $mail->SMTPAuth = true;
        $mail->Username = $user;
        $mail->Password = $pass;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = (int) env_value('SMTP_PORT', 587);

        $mail->setFrom($user, env_value('APP_NAME', 'Client Form'));
        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = 'Nouveau client reçu';
        $mail->Body = '<h2>Nouveau client reçu</h2>'
            . '<p><strong>Nom complet :</strong> ' . e($nomComplet) . '</p>'
            . '<p><strong>Âge :</strong> ' . e($age) . '</p>';
        $mail->AltBody = "Nouveau client\nNom complet : {$nomComplet}\nÂge : {$age}";
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
