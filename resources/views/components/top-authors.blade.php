<!-- Newest Authors Section -->
<section class="newest-authors-section">
    <div class="newest-authors-container">
        <!-- Section Header -->
        <div class="newest-authors-header">
            <div class="header-content">
                <h2 class="newest-authors-title">Newest authors</h2>
                <p class="newest-authors-subtitle">Say hello to future creator potentials</p>
            </div>
            <div class="navigation-arrows">
                <button class="nav-arrow nav-arrow-left" onclick="scrollAuthors('left')">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button class="nav-arrow nav-arrow-right" onclick="scrollAuthors('right')">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Authors Carousel -->
        <div class="authors-carousel-container">
            <div class="authors-carousel" id="authorsCarousel">
                <!-- Authors will be loaded here via JavaScript -->
                <div class="loading-authors">
                    <div class="loading-spinner"></div>
                    <p>Loading newest authors...</p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Newest Authors Section Styles */
.newest-authors-section {
    background: #f8f9fa;
    padding: 4rem 0;
    position: relative;
}

.newest-authors-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
}

/* Section Header */
.newest-authors-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 3rem;
    animation: fadeInUp 0.8s ease-out;
}

.header-content {
    flex: 1;
}

.newest-authors-title {
    font-size: 2.5rem;
    font-weight: 800;
    color: #1a1a2e;
    margin-bottom: 0.5rem;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
}

.newest-authors-subtitle {
    font-size: 1.25rem;
    color: #6b7280;
    font-weight: 400;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
}

/* Navigation Arrows */
.navigation-arrows {
    display: flex;
    gap: 0.5rem;
}

.nav-arrow {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: #ffffff;
    border: 1px solid #e5e7eb;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    color: #6b7280;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    z-index: 10;
    position: relative;
}

.nav-arrow:hover {
    background: #1a1a2e;
    color: #ffffff;
    border-color: #1a1a2e;
    transform: scale(1.05);
}

.nav-arrow:active {
    transform: scale(0.95);
}

/* Authors Carousel */
.authors-carousel-container {
    overflow: hidden;
    position: relative;
    width: 100%;
}

.authors-carousel-container::-webkit-scrollbar {
    display: none;
}

.authors-carousel-container {
    -ms-overflow-style: none;
    scrollbar-width: none;
}

.authors-carousel {
    display: flex;
    gap: 1.5rem;
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    animation: fadeInUp 0.8s ease-out 0.2s both;
}

/* Author Card */
.author-card {
    background: #ffffff;
    border-radius: 16px;
    overflow: hidden;
    position: relative;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    flex: 0 0 280px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.author-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

/* Author Card Background Image */
.author-card-bg {
    height: 120px;
    background-size: cover;
    background-position: center;
    position: relative;
    display: flex;
    align-items: flex-start;
    justify-content: flex-start;
    padding: 1rem;
}

/* Rank Tag */
.author-rank-tag {
    background: rgba(255, 255, 255, 0.9);
    color: #1a1a2e;
    font-size: 0.875rem;
    font-weight: 600;
    padding: 0.5rem 0.75rem;
    border-radius: 8px;
    backdrop-filter: blur(10px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

/* Author Card Content */
.author-card-content {
    padding: 1.5rem;
    text-align: center;
    position: relative;
}

/* Author Avatar */
.author-avatar {
    width: 80px;
    height: 80px;
    margin: -40px auto 1rem;
    border-radius: 50%;
    overflow: hidden;
    border: 4px solid #ffffff;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
    position: relative;
    z-index: 2;
}

.author-card:hover .author-avatar {
    transform: scale(1.05);
    box-shadow: 0 12px 32px rgba(0, 0, 0, 0.2);
}

.author-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.author-card:hover .author-avatar img {
    transform: scale(1.1);
}

/* Author Info */
.author-name {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 0.5rem;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
}

.author-title {
    font-size: 0.875rem;
    color: #6b7280;
    font-weight: 500;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
}

/* Carousel Navigation */
.carousel-scroll {
    scroll-behavior: smooth;
}

/* Loading State */
.loading-authors {
    flex: 0 0 100%;
    text-align: center;
    padding: 3rem;
    color: #6b7280;
}

.loading-spinner {
    width: 40px;
    height: 40px;
    border: 4px solid #e5e7eb;
    border-top: 4px solid #8b5cf6;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto 1rem;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .newest-authors-container {
        padding: 0 1rem;
    }

    .newest-authors-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }

    .newest-authors-title {
        font-size: 2rem;
    }

    .newest-authors-subtitle {
        font-size: 1.125rem;
    }

    .authors-carousel {
        gap: 1rem;
    }

    .author-card {
        flex: 0 0 240px;
    }

    .author-avatar {
        width: 60px;
        height: 60px;
        margin: -30px auto 1rem;
    }

    .author-name {
        font-size: 1.125rem;
    }

    .author-card-bg {
        height: 100px;
    }
}
</style>

<script>
let currentScroll = 0;
const scrollAmount = 300;

document.addEventListener('DOMContentLoaded', function() {
    loadNewestAuthors();

    // Handle window resize
    window.addEventListener('resize', function() {
        updateArrowStates();
    });

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft') {
            scrollAuthors('left');
        } else if (e.key === 'ArrowRight') {
            scrollAuthors('right');
        }
    });
});

function loadNewestAuthors() {
    fetch('/authors/api/top?limit=10')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(authors => {
            const carousel = document.getElementById('authorsCarousel');
            carousel.innerHTML = '';

            if (!authors || authors.length === 0) {
                carousel.innerHTML = '<div class="loading-authors"><p>No authors found.</p></div>';
                return;
            }

            authors.forEach((author, index) => {
                // Ensure author has required structure
                if (author.user) {
                    const authorCard = createAuthorCard(author, index + 1);
                    carousel.appendChild(authorCard);
                }
            });

            // Initialize arrow states after loading
            setTimeout(() => {
                updateArrowStates();
            }, 100);
        })
        .catch(error => {
            console.error('Error loading authors:', error);
            const carousel = document.getElementById('authorsCarousel');
            carousel.innerHTML = '<div class="loading-authors"><p>Error loading authors. Please try again later.</p></div>';
        });
}

function createAuthorCard(author, rank) {
    const card = document.createElement('div');
    card.className = 'author-card';
    card.onclick = () => window.location.href = `/authors/${author.user.id}`;

    // Background images array for variety
    const backgroundImages = [
        'https://images.unsplash.com/photo-1506905925346-04b1e767967a?w=400&h=200&fit=crop',
        'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=400&h=200&fit=crop',
        'https://images.unsplash.com/photo-1506905925346-04b1e767967a?w=400&h=200&fit=crop',
        'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=400&h=200&fit=crop',
        'https://images.unsplash.com/photo-1506905925346-04b1e767967a?w=400&h=200&fit=crop'
    ];

    const bgImage = backgroundImages[(rank - 1) % backgroundImages.length];

    card.innerHTML = `
        <div class="author-card-bg" style="background-image: url('${bgImage}')">
            <div class="author-rank-tag">${rank} →</div>
        </div>
        <div class="author-card-content">
            <div class="author-avatar">
                <img src="${author.user.avatar_url || author.user.avatar || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(author.user.name)}"
                     alt="${author.user.name}">
            </div>
            <h3 class="author-name">${author.user.name || 'Unknown Author'}</h3>
            <p class="author-title">${author.user.bio ? author.user.bio.split('.')[0] : 'Content Creator'}</p>
        </div>
    `;

    return card;
}

function scrollAuthors(direction) {
    const carousel = document.getElementById('authorsCarousel');
    const container = carousel.parentElement;
    const cardWidth = 280 + 24; // card width + gap
    const visibleCards = Math.floor(container.clientWidth / cardWidth);
    const totalCards = carousel.children.length;
    const maxScroll = Math.max(0, (totalCards - visibleCards) * cardWidth);

    if (direction === 'left') {
        currentScroll = Math.max(0, currentScroll - cardWidth);
    } else {
        currentScroll = Math.min(maxScroll, currentScroll + cardWidth);
    }

    carousel.style.transform = `translateX(-${currentScroll}px)`;

    // Update arrow states
    updateArrowStates();
}

function updateArrowStates() {
    const carousel = document.getElementById('authorsCarousel');
    const container = carousel.parentElement;
    const cardWidth = 280 + 24;
    const visibleCards = Math.floor(container.clientWidth / cardWidth);
    const totalCards = carousel.children.length;
    const maxScroll = Math.max(0, (totalCards - visibleCards) * cardWidth);

    const leftArrow = document.querySelector('.nav-arrow-left');
    const rightArrow = document.querySelector('.nav-arrow-right');

    if (leftArrow) {
        leftArrow.style.opacity = currentScroll <= 0 ? '0.5' : '1';
        leftArrow.style.pointerEvents = currentScroll <= 0 ? 'none' : 'auto';
    }

    if (rightArrow) {
        rightArrow.style.opacity = currentScroll >= maxScroll ? '0.5' : '1';
        rightArrow.style.pointerEvents = currentScroll >= maxScroll ? 'none' : 'auto';
    }
}

// Touch/swipe support for mobile
let startX = 0;
let isDragging = false;
let startScroll = 0;

document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.getElementById('authorsCarousel');
    if (carousel) {
        carousel.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            startScroll = currentScroll;
            isDragging = true;
        });

        carousel.addEventListener('touchmove', (e) => {
            if (!isDragging) return;
            e.preventDefault();
        });

        carousel.addEventListener('touchend', (e) => {
            if (!isDragging) return;

            const endX = e.changedTouches[0].clientX;
            const diff = startX - endX;

            if (Math.abs(diff) > 50) {
                if (diff > 0) {
                    scrollAuthors('right');
                } else {
                    scrollAuthors('left');
                }
            }

            isDragging = false;
        });
    }
});
</script>
