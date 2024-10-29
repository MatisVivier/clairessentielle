<?php
include 'connexion.php';
//session_start();

// Vérifie si la requête est de type POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupère les données envoyées par le formulaire
    $newContent = $_POST['new_content'];
    $newImageUrl = $_POST['new_image_url'];
    $imageWidth = $_POST['image_width'];
    $imageHeight = $_POST['image_height'];
    $class = $_POST['class'];

    // Prépare la requête SQL pour mettre à jour le contenu et l'URL de l'image
    $stmt = $conn->prepare("UPDATE contenu SET contenu = ?, image_url = ?, image_width = ?, image_height = ? WHERE class = ?");
    $stmt->bind_param("sssss", $newContent, $newImageUrl, $imageWidth, $imageHeight, $class);

    $_SESSION['update_success'] = true;

    // Exécute la requête
    if ($stmt->execute()) {
        // Redirige vers la page d'accueil après la mise à jour
        header('Location: ../index.php?success=true');
        exit();
    } else {
        echo "Erreur lors de la mise à jour.";
    }
}
?>
