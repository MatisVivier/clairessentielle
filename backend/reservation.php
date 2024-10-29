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
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/locales/fr.js'></script>
    <style>
        /* Mise en page flex pour aligner le calendrier à gauche et les horaires à droite */
        .reservation-container {
            display: flex;
            justify-content: space-between;
        }

        /* Calendrier compact */
        #calendar {
            max-width: 600px;
            margin-right: 30px;
        }

        /* Section des horaires */
        #horaires-disponibles {
            flex-grow: 1;
            max-width: 400px;
        }

        /* Style pour les boutons d'horaires */
        .horaire-btn {
            padding: 10px 15px;
            background-color: lightgreen;
            border: none;
            margin: 5px;
            cursor: pointer;
        }

        /* Mise en forme du formulaire de réservation */
        #reservation-form {
            margin-top: 20px;
        }

        /* Notification */
        .notification {
            position: fixed;
            bottom: 20px;
            left: 20px;
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            opacity: 0;
            transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out;
            transform: translateY(20px); /* Initialement décalé vers le bas */
        }

        .notification.show {
            opacity: 1;
            transform: translateY(0); /* Animation de montée */
        }

        .notification.hide {
            opacity: 0;
            transform: translateY(20px); /* Animation de descente */
        }

        /* Centrage des titres */
        h1, h2 {
            text-align: center;
        }
    </style>
</head>
<body>

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
<div id="reservation-form" style="display: none; text-align: center;">
    <h3>Confirmer la réservation</h3>
    <form id="form-reservation" method="POST" action="reserver.php">
        <input type="hidden" name="disponibilite_id" id="disponibilite_id">
        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($username); ?>" readonly><br><br>
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
            locale: 'fr', // Pour le calendrier en français
            height: 'auto', // Rendre le calendrier plus compact
            events: 'get_disponibilite.php', // Fichier PHP qui renvoie les disponibilités sous forme d'événements
            eventBackgroundColor: 'green', // Couleur des événements disponibles
            eventTextColor: 'white', // Texte blanc sur fond vert
            eventDisplay: 'background', // Afficher la couleur des événements en arrière-plan (cases colorées)
            dateClick: function (info) {
                // Lorsque l'utilisateur clique sur une date, on charge les créneaux disponibles
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
        fetch('get_horaires.php?date=' + date)
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
