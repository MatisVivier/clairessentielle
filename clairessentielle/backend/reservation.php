<?php
// Démarrage de la session
session_start();

// Vérification de la connexion de l'utilisateur
$isLoggedIn = isset($_SESSION['user_id']); // Par exemple, vous pouvez avoir un champ 'user_id' dans la session
$username = $isLoggedIn ? $_SESSION['username'] : ''; // Récupération du pseudo
$email = $isLoggedIn ? $_SESSION['email'] : ''; // Récupération de l'email

// Si l'utilisateur n'est pas connecté, on redirige ou on affiche un message d'erreur
if (!$isLoggedIn) {
    $errorMessage = "Vous devez être connecté pour réserver un créneau.";
}

// Gérer la notification de succès après réservation
$reservationSuccess = isset($_SESSION['reservation_success']) && $_SESSION['reservation_success'];
unset($_SESSION['reservation_success']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réserver un créneau</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500&display=swap" rel="stylesheet">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/locales/fr.js'></script>
    <link rel="stylesheet" href="../style/reservation.css">
    <link rel="stylesheet" href="../style/index.css">
</head>
<body>

<nav>
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
            <li><a href="mes_reservations.php">Mes réservations</a></li>
            <li><a href="logout.php">Déconnexion</a></li>
        <?php else: ?>
            <li><a href="../frontend/login.html">Identification</a></li>
            <!-- <li><a href="../connexion/signup.php">Inscription</a></li> -->
        <?php endif; ?>
        <li><a href="reservation.php" id="prendreRDVBtn" class="bouton-nav">Prendre rendez-vous</a></li>
    </ul>

</nav>


<h1>Réserver un créneau</h1>

<?php if (isset($errorMessage)): ?>
    <p style="color: red; text-align: center;"><?php echo $errorMessage; ?></p>
    <p style="text-align: center;"><a href="login.php">Connectez-vous</a> pour réserver un créneau.</p>
<?php else: ?>

<!-- Conteneur pour le calendrier et les horaires -->
<div class="reservation-container">
    <!-- Calendrier à gauche -->
    <div id="calendar"></div>

    <!-- Section pour afficher les horaires disponibles -->
    <div id="horaires-disponibles">
        <h2>Horaires disponibles pour le <span id="date-selectionnee"></span></h2>
        <div id="liste-horaires">
            <!-- Les horaires seront affichés ici sous forme de boutons -->
        </div>
    </div>
</div>

<!-- Formulaire de réservation -->
<div id="reservation-form">
    <h3>Confirmer la réservation</h3>
    <form id="form-reservation" method="POST" action="reserver.php">
        <input type="hidden" name="disponibilite_id" id="disponibilite_id">
        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" style="width: 75%" value="<?php echo htmlspecialchars($username); ?>" readonly><br><br>
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly><br><br>
        <button type="submit">Réserver</button>
    </form>
</div>
<!-- Section de notification -->
<div id="notification" class="notification">
    Réservation confirmée avec succès !
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');

        // Initialisation du calendrier avec une vue plus compacte
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'fr',
            height: 'auto',
            events: {
                url: '/backend/getters/get_disponibilite.php',
                failure: function() {
                    console.error('Erreur lors du chargement des disponibilités. Vérifiez l\'URL ou la présence du fichier.');
                }
            },
            dateClick: function (info) {
                chargerHorairesDisponibles(info.dateStr);
            }
    });


        calendar.render();

        // Affichage de la notification si la réservation a été réussie
        <?php if ($reservationSuccess): ?>
        afficherNotification();
        <?php endif; ?>
    });

    // Fonction pour charger les horaires disponibles pour une date donnée
    function chargerHorairesDisponibles(date) {
        fetch('getters/get_horaires.php?date=' + date)
            .then(response => response.json())
            .then(data => {
                const listeHoraires = document.getElementById('liste-horaires');
                const dateSelectionnee = document.getElementById('date-selectionnee');
                dateSelectionnee.textContent = date;

                listeHoraires.innerHTML = ''; // Effacer les horaires précédents

                if (data.length > 0) {
                    data.forEach(horaire => {
                        // Créer des boutons pour chaque créneau horaire disponible
                        const button = document.createElement('button');
                        button.textContent = horaire.heure_debut + ' - ' + horaire.heure_fin;
                        button.classList.add('horaire-btn');
                        button.addEventListener('click', () => {
                            // Quand l'utilisateur clique sur un créneau, afficher le formulaire de réservation
                            document.getElementById('disponibilite_id').value = horaire.id;
                            document.getElementById('reservation-form').style.display = 'block';
                        });
                        listeHoraires.appendChild(button);
                    });
                } else {
                    listeHoraires.innerHTML = '<p>Aucune disponibilité pour cette date.</p>';
                    document.getElementById('reservation-form').style.display = 'none';
                }
            });
    }

    // Fonction pour afficher la notification
    function afficherNotification() {
        const notification = document.getElementById('notification');
        notification.classList.add('show');
        setTimeout(function () {
            notification.classList.remove('show');
        }, 3000); // La notification disparaît après 3 secondes
    }
</script>

<?php endif; ?>

</body>
</html>
