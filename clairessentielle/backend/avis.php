<?php
include 'connexion.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Vous devez être connecté pour laisser un avis.";
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Activer l'affichage des erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Gestion de l'envoi du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $note = $_POST['note'];
    $commentaire = $_POST['commentaire'];

    // Vérifier que les données sont bien envoyées
    if (empty($note) || empty($commentaire)) {
        $_SESSION['error'] = "Tous les champs sont obligatoires.";
        header("Location: ../avis.php");
        exit();
    } else {
        // Insérer l'avis dans la base de données
        $stmt = $conn->prepare("INSERT INTO avis (user_id, note, commentaire) VALUES (?, ?, ?)");
        if (!$stmt) {
            die("Erreur de préparation de la requête : " . $conn->error);
        }
        
        $stmt->bind_param("iis", $user_id, $note, $commentaire);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Votre avis a été enregistré avec succès.";
        } else {
            $_SESSION['error'] = "Erreur lors de l'enregistrement de l'avis : " . $stmt->error;
        }

        header("Location: ../avis.php");
        exit();
    }
}

// Sécuriser la valeur de $order pour éviter les injections SQL
$order = 'DESC'; // Par défaut, tri de 5 à 1 étoile
if (isset($_GET['order']) && in_array($_GET['order'], ['asc', 'desc'])) {
    $order = strtoupper($_GET['order']); // ASC ou DESC, sécurisé avec strtoupper
}

// Requête pour récupérer les avis triés par note
$stmt = $conn->prepare("SELECT a.note, a.commentaire, a.date, u.username 
                        FROM avis a
                        JOIN users u ON a.user_id = u.id
                        ORDER BY a.note $order");

if (!$stmt) {
    die("Erreur de préparation de la requête : " . $conn->error);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result === false) {
    die("Erreur lors de l'exécution de la requête : " . $stmt->error);
}
