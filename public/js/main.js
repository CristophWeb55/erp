// Main JS for ERP Genesis

document.addEventListener('DOMContentLoaded', () => {
    console.log('ERP Genesis Loaded');

    // Subtle parallax effect for background orbs
    document.addEventListener('mousemove', (e) => {
        const x = e.clientX / window.innerWidth;
        const y = e.clientY / window.innerHeight;
        
        const orbs = document.querySelectorAll('.orb');
        orbs.forEach((orb, index) => {
            const speed = (index + 1) * 20;
            orb.style.transform = `translate(${x * speed}px, ${y * speed}px)`;
        });
    });
});
