/**
 * FrontOffice - JavaScript principal
 * Style Le Monde
 */
document.addEventListener('DOMContentLoaded', function() {
    // Toggle menu mobile
    var navToggle = document.querySelector('.nav-toggle');
    var navLinks = document.querySelector('.nav-links');
    
    if (navToggle && navLinks) {
        navToggle.addEventListener('click', function() {
            navLinks.classList.toggle('active');
            var expanded = navToggle.getAttribute('aria-expanded') === 'true';
            navToggle.setAttribute('aria-expanded', !expanded);
        });

        // Fermer le menu quand on clique sur un lien
        navLinks.querySelectorAll('a').forEach(function(link) {
            link.addEventListener('click', function() {
                navLinks.classList.remove('active');
                navToggle.setAttribute('aria-expanded', 'false');
            });
        });
    }

    // Marquer le lien actif dans la navigation (supporte aussi ?type=...)
    var currentPath = window.location.pathname;
    var currentSearch = window.location.search;
    document.querySelectorAll('.nav-links a').forEach(function(link) {
        try {
            var linkUrl = new URL(link.getAttribute('href'), window.location.origin);
            if (linkUrl.pathname === currentPath && linkUrl.search === currentSearch) {
                link.classList.add('active');
            }
        } catch (e) {
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('active');
            }
        }
    });

    // Header scroll : ajouter une ombre au scroll
    var header = document.querySelector('.site-header');
    if (header) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 10) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        }, { passive: true });
    }
});
