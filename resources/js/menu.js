
document.addEventListener('DOMContentLoaded', function() {
    const burgerMenu = document.querySelector('.burgerMenu');
    const nav = document.getElementById('menu');
    
    if (burgerMenu && nav) {
        burgerMenu.addEventListener('click', function(e) {
            e.stopPropagation();
            nav.classList.toggle('active');
            console.log('Menú toggled:', nav.classList.contains('active'));
        });
        document.addEventListener('click', function(e) {
            if (nav.classList.contains('active') && 
                !nav.contains(e.target) && 
                !burgerMenu.contains(e.target)) {
                nav.classList.remove('active');
            }
        });
        console.log('✅ Event listener agregado correctamente');
    } else {
        console.error('❌ Elementos no encontrados');
        console.log('burgerMenu:', burgerMenu);
        console.log('nav:', nav);
    }
});