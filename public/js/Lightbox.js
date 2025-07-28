// SimpleLightbox inicializálás - csak egyedi lightbox elemekhez
document.addEventListener('DOMContentLoaded', function() {
    // Egyedi lightbox elem inicializálás (pl. Event.php-ban)
    if (document.querySelector('.lightbox')) {
        var singleLightbox = new SimpleLightbox('.lightbox', {
            overlay: true,
            spinner: true,
            nav: false,
            close: true,
            closeText: '×',
            animationSlide: true,
            animationSpeed: 250,
            enableKeyboard: true,
            docClose: true,
            className: 'simple-lightbox-single',
            sourceAttr: 'href'
        });

        // Esemény kezelők
        singleLightbox.on('show.simplelightbox', function() {
            document.body.style.overflow = 'hidden';
        });

        singleLightbox.on('close.simplelightbox', function() {
            document.body.style.overflow = '';
        });
    }
    
    // MEGJEGYZÉS: A galéria lightbox inicializálás a Gallery.php fájlban történik
    // hogy elkerüljük a dupla inicializálást
});
