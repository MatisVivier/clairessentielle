<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    // Configuration du serveur SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'votre_email@gmail.com'; // Remplacez par votre email
    $mail->Password = 'votre_mot_de_passe'; // Mot de passe de l'application (à générer dans Gmail)
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Paramètres de l'email
    $mail->setFrom('votre_email@gmail.com', 'Nom de l\'expéditeur');
    $mail->addAddress('destinataire@example.com'); // Adresse du destinataire
    $mail->Subject = 'Sujet du message';
    $mail->Body = 'Contenu du message';

    // Envoi de l'email
    $mail->send();
    echo 'L\'email a été envoyé avec succès';
} catch (Exception $e) {
    echo 'Erreur lors de l\'envoi de l\'email : ', $mail->ErrorInfo;
}
