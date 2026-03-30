/**
 * BackOffice - JavaScript admin
 */
document.addEventListener('DOMContentLoaded', function() {
    // Toggle sidebar mobile
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    const sidebar = document.querySelector('.admin-sidebar');
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('open');
        });

        // Fermer sidebar en cliquant à l'extérieur
        document.addEventListener('click', function(e) {
            if (sidebar.classList.contains('open') && 
                !sidebar.contains(e.target) && 
                !sidebarToggle.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        });
    }

    // Compteur de caractères pour meta description
    const metaDesc = document.getElementById('meta_description');
    const charCount = document.querySelector('.char-count');
    
    if (metaDesc && charCount) {
        function updateCount() {
            const count = metaDesc.value.length;
            charCount.textContent = count + '/160 caractères';
            charCount.style.color = count > 160 ? '#dc2626' : '#64748b';
        }
        metaDesc.addEventListener('input', updateCount);
        updateCount();
    }

    // Génération automatique du slug à partir du titre
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');
    
    if (titleInput && slugInput && !slugInput.value) {
        titleInput.addEventListener('input', function() {
            if (!slugInput.dataset.manual) {
                slugInput.value = generateSlug(titleInput.value);
            }
        });

        slugInput.addEventListener('input', function() {
            slugInput.dataset.manual = slugInput.value ? 'true' : '';
        });
    }

    function generateSlug(text) {
        return text
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/[\s-]+/g, '-')
            .replace(/^-+|-+$/g, '');
    }
});
