document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.dashboard-card');
    cards.forEach(card => {
        card.addEventListener('click', function(e) {
            e.preventDefault();
            const href = this.getAttribute('href');
            setTimeout(() => {
                window.location.href = href;
            }, 300);
        });
    });
});