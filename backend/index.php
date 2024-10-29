<?php
// Inclure le fichier de connexion à la base de données
include 'connexion.php';
session_start();

// Fonction pour récupérer le contenu depuis la base de données par classe
function getContentByClass($class, $conn) {
    $stmt = $conn->prepare("SELECT contenu, image_url, image_width, image_height FROM contenu WHERE class = ?");
    $stmt->bind_param("s", $class);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return ["contenu" => "Contenu non disponible.", "image_url" => "", "image_width" => "auto", "image_height" => "auto"];
}

// Exemple : On récupère le contenu et l'image pour une classe "welcome-text"
$data = getContentByClass('welcome-text', $conn);
$welcomeText = $data['contenu'];
$imageUrl = $data['image_url'];
$imageWidth = $data['image_width'];
$imageHeight = $data['image_height'];

// Vérifier si la variable de session pour le succès de la mise à jour est définie
$showNotification = isset($_SESSION['update_success']) && $_SESSION['update_success'];
$isLoggedIn = isset($_SESSION['user_id']);

// Réinitialiser la variable de session après l'affichage de la notification
if ($showNotification) {
    unset($_SESSION['update_success']);
}
?>