document.addEventListener('DOMContentLoaded', function () {
    let currentIndex = 0;
    let avisData = [];

    // Fonction pour récupérer les avis via AJAX
    function fetchAvis() {
        fetch('../backend/getters/get_avis.php')
            .then(response => response.json())
            .then(data => {
                avisData = data;
                afficherAvis(); // Afficher le premier avis
                setInterval(() => {
                    sortirAvis(); // Lancer l'animation de sortie
                }, 10000); // Change l'avis toutes les 5 secondes
            })
            .catch(error => console.error('Erreur:', error));
    }

    // Fonction pour afficher un avis avec l'animation d'entrée
    function afficherAvis() {
        if (avisData.length > 0) {
            const avisContainer = document.getElementById('avis-item');
            let avisContent = document.querySelector('.avis-content');

            // Si l'élément n'existe pas encore, le créer
            if (!avisContent) {
                avisContent = document.createElement('div');
                avisContent.className = 'avis-content';
                avisContainer.appendChild(avisContent);
            }

            // Mettre à jour le contenu de l'avis
            avisContent.innerHTML = `
                <div class="avis-titre">Retour d'expèrience</div>
                <div class="avis-name">${avisData[currentIndex].username}</div>
                <div class="avis-commentaire">"${avisData[currentIndex].commentaire}"</div>
                <div class="avis-date">Posté le ${new Date(avisData[currentIndex].date).toLocaleDateString()}</div>
            `;

            // Réinitialiser la position pour l'animation d'entrée (hors écran à droite)
            avisContent.style.transition = 'none';
            avisContent.style.transform = 'translateX(100%)'; // Positionné hors de l'écran à droite
            avisContent.style.opacity = '0'; // Rendre invisible

            // Forcer le reflow avant d'appliquer l'animation
            requestAnimationFrame(() => {
                avisContent.style.transition = 'transform 1s ease, opacity 1s ease';
                avisContent.style.transform = 'translateX(0)'; // Glisser vers le centre
                avisContent.style.opacity = '1'; // Rendre visible
            });

            // Incrémenter l'index pour le prochain avis
            currentIndex = (currentIndex + 1) % avisData.length;
        }
    }

    // Fonction pour appliquer l'animation de sortie
    function sortirAvis() {
        const avisContent = document.querySelector('.avis-content');
        if (avisContent) {
            // Animation de sortie (glisser vers la gauche)
            avisContent.style.transition = 'transform 0.5s ease, opacity 0.5s ease';
            avisContent.style.transform = 'translateX(-20%)'; // Glisser vers la gauche
            avisContent.style.opacity = '0'; // Rendre invisible

            // Attendre la fin de l'animation de sortie (1 seconde), puis afficher le prochain avis
            setTimeout(() => {
                afficherAvis(); // Afficher le nouvel avis avec animation d'entrée depuis la droite
            }, 1000); // Délai égal à la durée de l'animation de sortie (1s)
        }
    }

    // Appeler la fonction pour récupérer les avis au chargement de la page
    fetchAvis();
});