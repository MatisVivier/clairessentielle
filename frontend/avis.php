<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

<h1>Laisser un avis et voir les avis</h1>

<!-- Afficher les messages de succès ou d'erreur -->
<?php if (isset($_SESSION['success'])): ?>
    <p style="color: green;"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
<?php endif; ?>
<?php if (isset($_SESSION['error'])): ?>
    <p style="color: red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php endif; ?>

<!-- Formulaire pour laisser un avis -->
<form method="POST" action="backend/avis.php">
    <h2>Laisser un avis</h2>
    <label for="note">Note (1 à 5 étoiles) :</label><br>
    <select name="note" id="note" required>
        <option value="5">5 étoiles</option>
        <option value="4">4 étoiles</option>
        <option value="3">3 étoiles</option>
        <option value="2">2 étoiles</option>
        <option value="1">1 étoile</option>
    </select><br><br>

    <label for="commentaire">Votre commentaire :</label><br>
    <textarea name="commentaire" id="commentaire" rows="5" cols="50" required></textarea><br><br>

    <button type="submit">Soumettre</button>
</form>

<hr>

<h2>Avis des utilisateurs</h2>

<!-- Lien pour trier les avis -->
<p>Trier par :
    <a href="?order=desc">De 5 à 1 étoile</a> |
    <a href="?order=asc">De 1 à 5 étoiles</a>
</p>

<!-- Affichage des avis -->
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

</body>
</html>