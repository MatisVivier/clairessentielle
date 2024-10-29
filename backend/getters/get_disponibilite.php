<?php
include '../connexion.php';

// Récupérer toutes les dates avec des disponibilités
$sql = "SELECT DISTINCT date FROM disponibilites WHERE disponible = TRUE";
$result = $conn->query($sql);

$events = [];

while ($row = $result->fetch_assoc()) {
    $events[] = [
        'start' => $row['date'], // Date où il y a une disponibilité
        'display' => 'background', // Afficher l'événement en tant qu'arrière-plan
        'backgroundColor' => 'green', // Colorer les cases en vert
        'borderColor' => 'green' // Bordure verte
    ];
}

// Retourner la liste des événements au format JSON
header('Content-Type: application/json');
echo json_encode($events);
?>
