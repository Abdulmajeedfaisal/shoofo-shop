import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Banner Slider Component
document.addEventListener('alpine:init', () => {
    Alpine.data('bannerSlider', (totalSlides) => ({
        currentSlide: 0,
        totalSlides: totalSlides,
        autoplayInterval: null,
        
        init() {
            this.startAutoplay();
        },
        
        startAutoplay() {
            this.autoplayInterval = setInterval(() => {
                this.nextSlide();
            }, 5000); // Change slide every 5 seconds
        },
        
        stopAutoplay() {
            if (this.autoplayInterval) {
                clearInterval(this.autoplayInterval);
            }
        },
        
        nextSlide() {
            this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
        },
        
        prevSlide() {
            this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
        },
        
        goToSlide(index) {
            this.currentSlide = index;
            this.stopAutoplay();
            this.startAutoplay();
        }
    }));
});

Alpine.start();
