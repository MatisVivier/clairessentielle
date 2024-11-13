<?php 
include_once('backend/index.php'); 
include_once('backend/update.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'accueil</title>
    <link rel="stylesheet" href="style/index.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500&display=swap" rel="stylesheet">
    <script src="assets/main.js" defer></script>
    <script>
        var isLoggedIn = <?php echo json_encode($isLoggedIn); ?>;
    </script>
</head>
<body>

<nav>
    <!-- Liens vers les réseaux sociaux à gauche -->
    <ul class="social-links">
        <li><a href="https://facebook.com" target="_blank"><img src="image/facebook.png"></a></li>
        <li><a href="https://twitter.com" target="_blank"><img src="image/instagram.webp"></a></li>
    </ul>

    <!-- Liens de navigation à droite -->
    <ul class="nav-links">
        <li><a href="index.php">Accueil</a></li>
        <li><a href="index.php">Contact</a></li>
        <?php if (isset($_SESSION['username'])): ?>
            <li><a href="backend/mes_reservations.php">Mes réservations</a></li>
            <li><a href="backend/logout.php">Déconnexion</a></li>
        <?php else: ?>
            <li><a href="frontend/login.html">Identification</a></li>
            <!-- <li><a href="../connexion/signup.php">Inscription</a></li> -->
        <?php endif; ?>
        <li><a href="backend/reservation.php" id="prendreRDVBtn" class="bouton-nav">Prendre rendez-vous</a></li>
    </ul>

</nav>

<!-- Section avec image de fond fixe -->
<div class="hero">
    <div class="hero-text">
        <h1>Titre Principal</h1>
        <h3>Sous Titre</h3>
        <a href="backend/reservation.php" id="heroRDVBtn" class="btn-reservation">Réserver maintenant</a>
    </div>
</div> 

<!-- Conteneur de contenu principal -->
<div class="container">
    <div class="container-container">
        <div class="container-text" id="editable-section">
            <div class="text-content">
                <h1>Section Bienvenue</h1>
                <p class="welcome-text"><?php echo htmlspecialchars($welcomeText); ?></p>
            </div>
            <?php if (!empty($imageUrl)): ?>
                <div class="image-content">
                    <img src="<?php echo htmlspecialchars($imageUrl); ?>" alt="Image" style="width: <?php echo htmlspecialchars($imageWidth); ?>px; height: <?php echo htmlspecialchars($imageHeight); ?>px;">
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin'): ?>
                <!-- Affichage du bouton de modification uniquement pour les admins -->
                <button class="open-modal-btn" id="bouton-modif" data-modal="modif"><img src="image/modifier.png"></button>
            <?php endif; ?>
        </div>
        <br>
        <!-- Fenêtre modale pour modification -->
        <div class="modal" id="modif">
            <div class="modal-content">
                <span class="close" data-modal="modif">&times;</span>
                <form method="post" action="backend/update.php#editable-section">
                    <textarea name="new_content" rows="5" cols="50"><?php echo htmlspecialchars($welcomeText); ?></textarea>
                    <br>
                    <input type="text" name="new_image_url" placeholder="URL de l'image" value="<?php echo htmlspecialchars($imageUrl); ?>">
                    <br>
                    <input type="number" name="image_width" placeholder="Largeur de l'image (px)" value="<?php echo htmlspecialchars($imageWidth); ?>">
                    <input type="number" name="image_height" placeholder="Hauteur de l'image (px)" value="<?php echo htmlspecialchars($imageHeight); ?>">
                    <input type="hidden" name="class" value="welcome-text">
                    <button type="submit">Mettre à jour</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container-container-2">
        <div class="profile-image">
                <img src="image/fleurs.jpg" alt="Portrait de Marie Dupont">
            </div>
        <div class="profile-section">
            <!-- Image en dehors de la boîte -->
            
            <!-- Texte à droite de l'image, à l'intérieur de la boîte -->
            <div class="profile-text">
                <h2>À propos de moi</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor.</p>
            </div>
        </div>
    </div>

    <div class="container-container-3">
        <h2>Mes Services</h2>
        <div class="services-grid">
            <div class="service-card">
                <img src="image/fleurs.jpg" alt="Reiki Icon">
                <h3>Lorem Ipsum</h3>
                <p>Lorem ipsum dolor sit amc, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a, enim. Pellentesque congue. Ut in risus volutpat libero pharetra tempor.  </p>
            </div>

            <div class="service-card">
                <img src="image/fleurs.jpg" alt="Chakra Icon">
                <h3>Lorem Ipsum</h3>
                <p>Lorem ipsum dolor sit amet, consect ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a, enim. Pellentesque congue. Ut in risus volutpat libero pharetra tempor.  </p>
            </div>

            <div class="service-card">
                <img src="image/fleurs.jpg" alt="Magnétisme Icon">
                <h3>Lorem Ipsum</h3>
                <p>Lorem ipsum dolor sit ametng nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a, enim. Pellentesque congue. Ut in risus volutpat libero pharetra tempor.  </p>
            </div>

            <div class="service-card">
                <img src="image/fleurs.jpg" alt="Meditation Icon">
                <h3>Lorem Ipsum</h3>
                <p>Lorem ipsum et, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a, enim. Pellentesque congue. Ut in risus volutpat libero pharetra tempor.  </p>
            </div>
        </div>
    </div>

    <div class="container-container-4">
    <div class="avis-container">
        <div class="avis-item" id="avis-item">
            <!-- Les avis seront injectés ici par JavaScript -->
        </div>
        <div class="bouton-avis">
            <a href="frontend/avis.php" onclick="openFeedbackForm()">Raconter son expérience</a>
        </div>
    </div>
</div>

<!-- Inclusion du fichier JavaScript -->
<script src="assets/show_avis.js"></script>


<!-- Inclusion du fichier JavaScript -->
<script src="assets/show_avis.js"></script>


    <!-- Notification de succès -->
    <?php if ($showNotification): ?>
            <div class="notification" id="notification">
                <p>Modification effectuée avec succès!</p>
            </div>
        <?php endif; ?>

    <div id="errorNotification" class="notification">
        Vous devez vous identifié pour réserver un créneau. <a href="frontend/login.html" style="color: white; text-decoration: underline;">Se connecter</a>
    </div>

</div>

</body>

<footer class="footer">
    <div class="footer-content">
        <div class="footer-links">
            <a href="#">Accueil</a>
            <a href="#">À propos</a>
            <a href="#">Contact</a>
            <a href="#">Mentions légales</a>
        </div>
        <div class="footer-copyright">
            &copy; 2024 VotreSite. Tous droits réservés.
        </div>
    </div>
</footer>

<script>
    window.addEventListener('scroll', function() {
        const nav = document.querySelector('nav'); // Sélectionner la barre de navigation
        const container = document.querySelector('.container'); // Sélectionner le conteneur
        const containerTop = container.getBoundingClientRect().top; // Obtenir la position du conteneur

        if (containerTop <= 0) {
            nav.classList.add('nav-colored'); // Ajouter la classe quand le conteneur touche la barre de navigation
        } else {
            nav.classList.remove('nav-colored'); // Retirer la classe quand le conteneur est au-dessus
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const errorNotification = document.getElementById('errorNotification');
        const prendreRDVBtn = document.getElementById('prendreRDVBtn');
        const heroRDVBtn = document.getElementById('heroRDVBtn');

        // Fonction pour afficher la notification
        const showNotification = function() {
            errorNotification.classList.add('show');
            errorNotification.classList.remove('hide');

            // Masquer la notification après 5 secondes
            setTimeout(() => {
                errorNotification.classList.remove('show');
                errorNotification.classList.add('hide');
            }, 5000);
        };

        // Fonction pour vérifier l'état de connexion et afficher la notification
        const checkAndShowNotification = function(event) {
            if (!isLoggedIn) { // Si l'utilisateur n'est pas connecté
                event.preventDefault(); // Empêcher la redirection
                showNotification(); // Afficher la notification
            }
        };

        // Écoute des événements de clic sur les boutons
        prendreRDVBtn.addEventListener('click', checkAndShowNotification);
        heroRDVBtn.addEventListener('click', checkAndShowNotification);
    });
</script>

</html>
