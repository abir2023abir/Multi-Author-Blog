// Hero Section JavaScript - Single Large Image
document.addEventListener('DOMContentLoaded', function() {
    initHeroImage();
    initScrollToContent();
    initSmoothScrolling();
});

function initHeroImage() {
    const heroImage = document.querySelector('.hero-main-image');
    if (!heroImage) return;

    // Add hover effects
    heroImage.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-8px) scale(1.02)';
    });

    heroImage.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0) scale(1)';
    });

    // Add click effect
    heroImage.addEventListener('click', function() {
        this.style.transform = 'translateY(-4px) scale(1.01)';
        setTimeout(() => {
            this.style.transform = 'translateY(-8px) scale(1.02)';
        }, 150);
    });

    // Add keyboard navigation
    heroImage.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            this.click();
        }
    });

    // Make image focusable for accessibility
    heroImage.setAttribute('tabindex', '0');
}

function initScrollToContent() {
    // Smooth scroll to main content when button is clicked
    window.scrollToContent = function() {
        const mainContent = document.querySelector('.trending-topics-section') ||
                          document.querySelector('.top-authors-section') ||
                          document.querySelector('.video-section') ||
                          document.querySelector('.latest-articles-section');

        if (mainContent) {
            mainContent.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        } else {
            // Fallback: scroll down by viewport height
            window.scrollBy({
                top: window.innerHeight * 0.8,
                behavior: 'smooth'
            });
        }
    };
}

function initSmoothScrolling() {
    // Add smooth scrolling to all anchor links
    const links = document.querySelectorAll('a[href^="#"]');
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);

            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

// Add intersection observer for fade-in animations
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animate-in');
        }
    });
}, observerOptions);

// Observe hero elements for animation
document.addEventListener('DOMContentLoaded', function() {
    const heroLeft = document.querySelector('.hero-left');
    const heroRight = document.querySelector('.hero-right');
    const heroImage = document.querySelector('.hero-main-image');

    if (heroLeft) {
        heroLeft.style.animationDelay = '0.1s';
        observer.observe(heroLeft);
    }

    if (heroRight) {
        heroRight.style.animationDelay = '0.3s';
        observer.observe(heroRight);
    }

    if (heroImage) {
        heroImage.style.animationDelay = '0.5s';
        observer.observe(heroImage);
    }
});

// Add CSS for animations
const style = document.createElement('style');
style.textContent = `
    .hero-left,
    .hero-right,
    .hero-main-image {
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .hero-left.animate-in,
    .hero-right.animate-in,
    .hero-main-image.animate-in {
        opacity: 1;
        transform: translateY(0);
    }

    .hero-main-image {
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .hero-main-image:hover {
        cursor: pointer;
    }
`;
document.head.appendChild(style);

// Handle window resize
window.addEventListener('resize', function() {
    // Ensure image stays responsive
    const heroImage = document.querySelector('.hero-main-image');
    if (heroImage) {
        heroImage.style.maxWidth = '100%';
        heroImage.style.height = 'auto';
    }
});

// Image load handler
window.addEventListener('load', function() {
    const heroImage = document.querySelector('.hero-main-image');
    if (heroImage) {
        heroImage.addEventListener('load', function() {
            console.log('Hero image loaded successfully');
        });

        heroImage.addEventListener('error', function() {
            console.error('Hero image failed to load:', this.src);
            // You could add a fallback image here
        });
    }
});
