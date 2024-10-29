<?php
// Inclure le fichier de connexion à la base de données
include 'connexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Vérification des erreurs
    $errors = [];
    if (empty($username)) {
        $errors[] = "Le nom d'utilisateur est requis.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'email est invalide.";
    }

    if (strlen($password) < 8) {
        $errors[] = "Le mot de passe doit contenir au moins 8 caractères.";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }

    // S'il n'y a pas d'erreurs, procéder à l'enregistrement
    if (empty($errors)) {
        // Hachage du mot de passe
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Préparer la requête SQL pour insérer un nouvel utilisateur
        $stmt = $conn->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password_hash);

        // Exécuter la requête
        if ($stmt->execute()) {
            echo "Inscription réussie. Vous pouvez maintenant vous connecter.";
        } else {
            echo "<p style='color:red;'>Erreur lors de l'inscription : " . $stmt->error . "</p>";
        }

        $stmt->close();
    } else {
        // Afficher les erreurs
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    }
}
?>
