<?php
include 'connexion.php';
session_start();

// Activer l'affichage des erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Vérification de la connexion de l'utilisateur
if (!isset($_SESSION['user_id'])) {
    // Redirection vers la page de connexion si l'utilisateur n'est pas connecté
    $_SESSION['error'] = "Vous devez être connecté pour voir vos réservations.";
    header("Location: login.php");
    exit();
}

// Récupérer l'ID de l'utilisateur connecté
$user_id = $_SESSION['user_id'];

// Requête SQL pour récupérer toutes les réservations de l'utilisateur
$stmt = $conn->prepare("SELECT r.id as reservation_id, r.date, r.heure_debut, r.heure_fin, d.id as disponibilite_id
                        FROM reservations r
                        JOIN disponibilites d ON r.disponibilite_id = d.id
                        WHERE r.user_id = ?
                        ORDER BY r.date DESC");

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes réservations</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
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
            transform: translateY(20px);
        }

        .notification.show {
            opacity: 1;
            transform: translateY(0);
        }

        .notification.hide {
            opacity: 0;
            transform: translateY(20px);
        }

        .notification.error {
            background-color: #f44336; /* Rouge pour les erreurs */
        }
    </style>
</head>
<body>

<h1>Mes Réservations</h1>

<!-- Section de notification -->
<div id="notification" class="notification">
    <span id="notification-message"></span>
</div>

<!-- Afficher les messages de succès ou d'erreur -->
<?php if (isset($_SESSION['success']) || isset($_SESSION['error'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notification = document.getElementById('notification');
            const message = document.getElementById('notification-message');
            
            // Vérifier s'il y a un message de succès ou d'erreur
            <?php if (isset($_SESSION['success'])): ?>
                message.textContent = "<?php echo $_SESSION['success']; unset($_SESSION['success']); ?>";
                notification.classList.add('show');
            <?php elseif (isset($_SESSION['error'])): ?>
                message.textContent = "<?php echo $_SESSION['error']; unset($_SESSION['error']); ?>";
                notification.classList.add('show', 'error');
            <?php endif; ?>

            // Cacher la notification après 3 secondes
            setTimeout(function() {
                notification.classList.remove('show', 'error');
            }, 3000);
        });
    </script>
<?php endif; ?>

<?php if ($result->num_rows > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Heure de début</th>
                <th>Heure de fin</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['date']); ?></td>
                    <td><?php echo htmlspecialchars($row['heure_debut']); ?></td>
                    <td><?php echo htmlspecialchars($row['heure_fin']); ?></td>
                    <td>
                        <!-- Bouton pour annuler la réservation -->
                        <form method="POST" action="annuler_reservation.php" onsubmit="return confirm('Voulez-vous vraiment annuler cette réservation ?');">
                            <input type="hidden" name="reservation_id" value="<?php echo htmlspecialchars($row['reservation_id']); ?>">
                            <input type="hidden" name="disponibilite_id" value="<?php echo htmlspecialchars($row['disponibilite_id']); ?>">
                            <button type="submit">Annuler</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Aucune réservation trouvée.</p>
<?php endif; ?>

</body>
</html>

