<?php
// Inclure la connexion à la base de données
include '../connexion.php';

// Récupérer les avis 5 étoiles
$query = "SELECT avis.note, avis.commentaire, avis.date, users.username
          FROM avis
          JOIN users ON avis.user_id = users.id
          WHERE avis.note = 5
          ORDER BY avis.date DESC"; // Trier par date décroissante
$result = $conn->query($query);

$avisArray = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $avisArray[] = $row;
    }
} else {
    echo json_encode(['error' => 'Aucun avis trouvé']);
    exit();
}

// Retourner les avis sous forme de JSON
header('Content-Type: application/json');
echo json_encode($avisArray);
?>
