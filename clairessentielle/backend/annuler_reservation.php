<?php
include 'connexion.php';
session_start();

// Activer l'affichage des erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Vérification de la connexion de l'utilisateur
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Vous devez être connecté pour annuler une réservation.";
    header("Location: login.php");
    exit();
}

// Vérifier que la requête POST contient les informations nécessaires
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $reservation_id = $_POST['reservation_id'];
    $disponibilite_id = $_POST['disponibilite_id'];
    $user_id = $_SESSION['user_id'];

    // Vérifier que l'utilisateur a bien fait cette réservation
    $stmt = $conn->prepare("SELECT id FROM reservations WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $reservation_id, $user_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Supprimer la réservation
        $stmt->close();
        $stmt = $conn->prepare("DELETE FROM reservations WHERE id = ?");
        $stmt->bind_param("i", $reservation_id);
        if ($stmt->execute()) {
            // Mettre à jour la disponibilité (disponible = TRUE)
            $stmt->close();
            $stmt = $conn->prepare("UPDATE disponibilites SET disponible = TRUE WHERE id = ?");
            $stmt->bind_param("i", $disponibilite_id);
            if ($stmt->execute()) {
                $_SESSION['success'] = "Réservation annulée avec succès.";
            } else {
                $_SESSION['error'] = "Erreur lors de la mise à jour de la disponibilité.";
            }
        } else {
            $_SESSION['error'] = "Erreur lors de la suppression de la réservation.";
        }
    } else {
        $_SESSION['error'] = "Cette réservation ne vous appartient pas.";
    }

    // Rediriger vers la page des réservations avec le message approprié
    header("Location: mes_reservations.php");
    exit();
}
?>
