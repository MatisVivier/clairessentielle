<?php
// Inclure le fichier de connexion à la base de données
include 'connexion.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $email = htmlspecialchars(trim($_POST['email']));
    $password = $_POST['password'];

    // Préparer la requête pour récupérer les informations utilisateur
    $stmt = $conn->prepare("SELECT id, username, password_hash, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Vérification si l'utilisateur existe
    if ($stmt->num_rows > 0) {
        // L'utilisateur existe, on récupère ses informations
        $stmt->bind_result($id, $username, $password_hash, $role);
        $stmt->fetch();

        // Vérifier si le mot de passe est correct
        if (password_verify($password, $password_hash)) {
            // Si le mot de passe est correct, on enregistre les informations dans la session
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $role;

            // Rediriger l'utilisateur vers la page d'accueil
            header('Location: ../index.php');
            exit(); // On arrête l'exécution du script après la redirection
        } else {
            // Si le mot de passe est incorrect, afficher un message d'erreur
            echo "<p style='color:red;'>Mot de passe incorrect.</p>";
        }
    } else {
        // Si aucun utilisateur n'est trouvé, afficher un message d'erreur
        echo "<p style='color:red;'>Aucun compte trouvé avec cet email.</p>";
    }

    $stmt->close();
}
?>
