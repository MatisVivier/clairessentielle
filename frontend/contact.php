<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500&display=swap" rel="stylesheet">
    <title>Contactez-nous</title>
    <link rel="stylesheet" href="../style/contact.css">
</head>
<body>

    <div class="overlay">
        <h1>Contactez-moi</h1>

        <!-- Afficher les messages de succès ou d'erreur -->
        <?php if (isset($_SESSION['success'])): ?>
            <p class="message success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <p class="message error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php endif; ?>

        <!-- Formulaire de contact -->
        <form class="contact-form" method="POST" action="contact.php">
            <label for="name">Nom :</label>
            <input type="text" name="name" id="name" required>

            <label for="email">Email :</label>
            <input type="email" name="email" id="email" required>

            <label for="subject">Sujet :</label>
            <input type="text" name="subject" id="subject" required>

            <label for="message">Message :</label>
            <textarea name="message" id="message" rows="5" required></textarea>

            <button type="submit">Envoyer</button>
        </form>
    </div>

</body>
</html>