<?php
include 'connexion.php';
session_start();

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Si l'utilisateur n'est pas connecté, le rediriger ou afficher un message d'erreur
    $_SESSION['error'] = "Vous devez être connecté pour réserver.";
    header("Location: login.php");
    exit();
}

// Si l'utilisateur est connecté, récupération des informations du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $disponibilite_id = $_POST['disponibilite_id'];
    $user_id = $_SESSION['user_id']; // Utiliser l'ID de l'utilisateur connecté
    
    // Récupérer la disponibilité sélectionnée
    $stmt = $conn->prepare("SELECT date, heure_debut, heure_fin FROM disponibilites WHERE id = ? AND disponible = TRUE");
    $stmt->bind_param("i", $disponibilite_id);
    $stmt->execute();
    $stmt->bind_result($date, $heure_debut, $heure_fin);
    
    if ($stmt->fetch()) {
        // Insérer la réservation dans la base de données
        $stmt->close();
        $stmt = $conn->prepare("INSERT INTO reservations (date, heure_debut, heure_fin, disponibilite_id, user_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssii", $date, $heure_debut, $heure_fin, $disponibilite_id, $user_id);
        $stmt->execute();
        
        // Mettre à jour la disponibilité
        $stmt = $conn->prepare("UPDATE disponibilites SET disponible = FALSE WHERE id = ?");
        $stmt->bind_param("i", $disponibilite_id);
        $stmt->execute();
        
        $_SESSION['reservation_success'] = "Votre réservation a été confirmée !";
        header("Location: reservation.php");
        exit();
    } else {
        $_SESSION['reservation_error'] = "Le créneau sélectionné n'est plus disponible.";
        header("Location: reservation.php");
        exit();
    }
}

?>
