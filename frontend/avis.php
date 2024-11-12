<?php
session_start();
include '../backend/avis.php'; // Inclusion pour récupérer les avis depuis le back-end

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style/avis.css">
    <link rel="stylesheet" href="../style/index.css">
    <title>Laisser un avis et voir les avis</title>
    <style>
        .avis {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<nav style="background-color: #E8AABE">
    <!-- Liens vers les réseaux sociaux à gauche -->
    <ul class="social-links">
        <li><a href="https://facebook.com" target="_blank"><img src="../image/facebook.png"></a></li>
        <li><a href="https://twitter.com" target="_blank"><img src="../image/instagram.webp"></a></li>
    </ul>

    <!-- Liens de navigation à droite -->
    <ul class="nav-links">
        <li><a href="../index.php">Accueil</a></li>
        <li><a href="../index.php">Contact</a></li>
        <?php if (isset($_SESSION['username'])): ?>
            <li><a href="../backend/mes_reservations.php">Mes réservations</a></li>
            <li><a href="../backend/logout.php">Déconnexion</a></li>
        <?php else: ?>
            <li><a href="login.html">Identification</a></li>
            <!-- <li><a href="../connexion/signup.php">Inscription</a></li> -->
        <?php endif; ?>
        <li><a href="../backend/reservation.php" id="prendreRDVBtn" class="bouton-nav">Prendre rendez-vous</a></li>
    </ul>

</nav>

<h1>Laisser un commentaire</h1>

<!-- Afficher les messages de succès ou d'erreur -->
<?php if (isset($_SESSION['success'])): ?>
    <p style="color: green;"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
<?php endif; ?>
<?php if (isset($_SESSION['error'])): ?>
    <p style="color: red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php endif; ?>

<!-- Formulaire pour laisser un avis -->
<form method="POST" action="backend/avis.php">
    <h2>Donner son retour</h2>
    <label for="note">Note (1 à 5 étoiles) :</label><br>
    <select name="note" id="note" required>
        <option value="5">5 étoiles</option>
        <option value="4">4 étoiles</option>
        <option value="3">3 étoiles</option>
        <option value="2">2 étoiles</option>
        <option value="1">1 étoile</option>
    </select><br><br>

    <label for="commentaire">Votre commentaire :</label><br>
    <textarea style="width: 95%" name="commentaire" id="commentaire" rows="5" cols="50" required></textarea><br><br>

    <button type="submit">Soumettre</button>
</form>

<h2 style="margin-top: 20px">Avis des utilisateurs</h2>

<!-- Lien pour trier les avis -->
<p>Trier par :
    <a href="?order=desc">De 5 à 1 étoile</a> |
    <a href="?order=asc">De 1 à 5 étoiles</a>
</p>

<!-- Conteneur de la grille d'avis -->
<div class="avis-grid">
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="avis">
                <strong><?php echo htmlspecialchars($row['username']); ?></strong> 
                <span> - <?php echo $row['note']; ?> étoiles</span><br>
                <small><?php echo htmlspecialchars($row['date']); ?></small><br>
                <p><?php echo nl2br(htmlspecialchars($row['commentaire'])); ?></p>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Aucun avis trouvé.</p>
    <?php endif; ?>
</div>

</body>
</html>
