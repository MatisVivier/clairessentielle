<?php
include '../connexion.php';

$date = $_GET['date'] ?? '';

// Préparer et exécuter la requête
$stmt = $conn->prepare("SELECT id, heure_debut, heure_fin FROM disponibilites WHERE date = ? AND disponible = TRUE");
if ($stmt === false) {
    echo json_encode(['error' => 'Erreur dans la préparation de la requête SQL']);
    exit;
}
$stmt->bind_param("s", $date);
$stmt->execute();
$result = $stmt->get_result();

// Construire la liste des créneaux horaires
$horaires = [];
while ($row = $result->fetch_assoc()) {
    $horaires[] = [
        'id' => $row['id'],
        'heure_debut' => $row['heure_debut'],
        'heure_fin' => $row['heure_fin']
    ];
}

// Retourner le JSON
header('Content-Type: application/json');
echo json_encode($horaires);
?>
