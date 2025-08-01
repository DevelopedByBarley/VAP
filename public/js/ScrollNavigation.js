/**
 * Scroll Navigation - Auto Active Navigation Links
 * Figyeli a scroll pozíciót és aktiválja a megfelelő navigation linket
 */

document.addEventListener('DOMContentLoaded', function() {
    // Navigation linkek és a hozzájuk tartozó szekciók
    const sections = [
        { id: 'about-us', navSelector: 'a[href*="#about-us"]' },
        { id: 'latest-events', navSelector: 'a[href*="#latest-events"]' },
        { id: 'gallery', navSelector: 'a[href*="#gallery"]' },
        { id: 'volunteers', navSelector: 'a[href*="#volunteers"]' },
        { id: 'sup_partners', navSelector: 'a[href*="#sup_partners"]' },
        { id: 'faq', navSelector: 'a[href*="#faq"]' },
        { id: 'footer', navSelector: 'a[href*="#footer"]' }
    ];

    // Aktív osztály neve
    const activeClass = 'active';
    
    // Navbar magasság figyelembevétele (offset)
    const navbarHeight = 150;
    
    // Throttle funkció a teljesítmény optimalizálásához
    function throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        }
    }

    // Aktív szekció meghatározása
    function getActiveSection() {
        const scrollPos = window.pageYOffset + navbarHeight;
        let activeSection = null;
        let closestDistance = Infinity;

        sections.forEach(section => {
            const element = document.getElementById(section.id);
            if (element) {
                const elementTop = element.offsetTop;
                const elementBottom = elementTop + element.offsetHeight;
                
                // Ha a scroll pozíció a szekció területén belül van vagy közeli
                if (scrollPos >= elementTop - 200 && scrollPos <= elementBottom + 100) {
                    const distance = Math.abs(scrollPos - elementTop);
                    if (distance < closestDistance) {
                        closestDistance = distance;
                        activeSection = section;
                    }
                }
            }
        });

        // Ha nincs aktív szekció, akkor keressük a legközelebbit
        if (!activeSection) {
            sections.forEach(section => {
                const element = document.getElementById(section.id);
                if (element) {
                    const elementTop = element.offsetTop;
                    const distance = Math.abs(scrollPos - elementTop);
                    if (distance < closestDistance) {
                        closestDistance = distance;
                        activeSection = section;
                    }
                }
            });
        }

        return activeSection;
    }

    // Navigation linkek frissítése
    function updateNavigationLinks() {
        const activeSection = getActiveSection();
        
        // Debug: console.log('Active section:', activeSection?.id);
        
        // Minden navigation linkről eltávolítjuk az active osztályt
        sections.forEach(section => {
            const navLink = document.querySelector(section.navSelector);
            if (navLink) {
                navLink.classList.remove(activeClass);
            }
        });

        // Az aktív szekcióhoz tartozó linkre hozzáadjuk az active osztályt
        if (activeSection) {
            const activeNavLink = document.querySelector(activeSection.navSelector);
            if (activeNavLink) {
                activeNavLink.classList.add(activeClass);
                // Debug: console.log('Added active class to:', activeSection.navSelector);
            }
        }
    }

    // Scroll esemény figyelő throttle-val
    const throttledUpdateNav = throttle(updateNavigationLinks, 100);
    window.addEventListener('scroll', throttledUpdateNav);

    // Kezdeti állapot beállítása
    updateNavigationLinks();

    // Smooth scroll funkció a navigation linkekhez
    function initSmoothScroll() {
        sections.forEach(section => {
            const navLink = document.querySelector(section.navSelector);
            if (navLink) {
                navLink.addEventListener('click', function(e) {
                    // Csak akkor alkalmazzuk a smooth scroll-t, ha ugyanazon az oldalon vagyunk
                    if (this.getAttribute('href').startsWith('#')) {
                        e.preventDefault();
                        const targetId = this.getAttribute('href').substring(1);
                        const targetElement = document.getElementById(targetId);
                        
                        if (targetElement) {
                            const targetPosition = targetElement.offsetTop - navbarHeight;
                            window.scrollTo({
                                top: targetPosition,
                                behavior: 'smooth'
                            });
                        }
                    }
                });
            }
        });
    }

    // Smooth scroll inicializálása
    initSmoothScroll();

    // Resize esemény figyelő (ha változik az oldal layout)
    window.addEventListener('resize', throttle(updateNavigationLinks, 200));
});
