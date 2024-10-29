<?php
include 'connexion.php';

$date = $_GET['date'];

// Récupérer les créneaux horaires disponibles pour cette date
$stmt = $conn->prepare("SELECT id, heure_debut, heure_fin FROM disponibilites WHERE date = ? AND disponible = TRUE");
$stmt->bind_param("s", $date);
$stmt->execute();
$result = $stmt->get_result();

$horaires = [];

while ($row = $result->fetch_assoc()) {
    $horaires[] = [
        'id' => $row['id'], // On garde l'ID pour la réservation
        'heure_debut' => $row['heure_debut'],
        'heure_fin' => $row['heure_fin']
    ];
}

// Retourner la liste des créneaux horaires disponibles au format JSON
header('Content-Type: application/json');
echo json_encode($horaires);
?>
