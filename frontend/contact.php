<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    // Configuration du serveur SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'matisvivier2004@gmail.com';
    $mail->Password = 'votre_mot_de_passe'; // Utilisez un mot de passe d'application si l'authentification 2FA est activée
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Expéditeur et destinataire
    $mail->setFrom('matisvivier2004@gmail.com', $name); // Utilisez votre email Gmail ici
    $mail->addAddress('destinataire@example.com'); // Remplacez par votre adresse email de réception

    // Contenu de l'email
    $mail->Subject = $subject;
    $mail->Body = "Nom: $name\nEmail: $email\n\nMessage:\n$message";
    $mail->AltBody = "Nom: $name\nEmail: $email\n\nMessage:\n$message"; // Version texte

    // Envoi de l'email
    $mail->send();
    $_SESSION['success'] = "Votre message a été envoyé avec succès.";
} catch (Exception $e) {
    $_SESSION['error'] = "Erreur lors de l'envoi de l'email : " . $mail->ErrorInfo;
}
