// resources/js/app.js

import "./bootstrap";
import Alpine from "alpinejs";

// Membuat Alpine.js tersedia secara global
window.Alpine = Alpine;

// Memulai Alpine.js untuk mengaktifkan interaktivitas (seperti pada header)
Alpine.start();

// Modern scroll animations using Intersection Observer
document.addEventListener('DOMContentLoaded', function() {
    // Replace deprecated scroll events with Intersection Observer
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in');
            }
        });
    }, observerOptions);
    
    // Observe elements that need scroll animations
    document.querySelectorAll('.animate-on-scroll, .feature-card, .testimonial-card').forEach(el => {
        observer.observe(el);
    });
});
