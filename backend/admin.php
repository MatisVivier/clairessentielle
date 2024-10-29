<?php
include 'connexion.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $date = $_POST['date'];
    $heure_debut = $_POST['heure_debut'];
    $heure_fin = $_POST['heure_fin'];

    // Insérer les disponibilités dans la base de données
    $stmt = $conn->prepare("INSERT INTO disponibilites (date, heure_debut, heure_fin) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $date, $heure_debut, $heure_fin);
    $stmt->execute();
    $stmt->close();
}
?>
