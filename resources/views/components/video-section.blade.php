<!-- Video Section -->
<section class="video-section">
    <div class="video-container">
        <!-- Section Header -->
        <div class="video-header">
            <div class="header-content">
                <h2 class="video-title">Featured Videos</h2>
                <p class="video-subtitle">Discover amazing content from our community</p>
            </div>
            <div class="navigation-arrows">
                <button class="nav-arrow nav-arrow-left" onclick="scrollVideos('left')">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button class="nav-arrow nav-arrow-right" onclick="scrollVideos('right')">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Videos Carousel -->
        <div class="videos-carousel-container">
            <div class="videos-carousel" id="videosCarousel">
                <!-- Videos will be loaded here via JavaScript -->
                <div class="loading-videos">
                    <div class="loading-spinner"></div>
                    <p>Loading featured videos...</p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Video Section Styles */
.video-section {
    background: #f8f9fa;
    padding: 4rem 0;
    position: relative;
}

.video-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
}

/* Header Styles */
.video-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 3rem;
}

.header-content {
    flex: 1;
}

.video-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 0.5rem;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
}

.video-subtitle {
    font-size: 1.125rem;
    color: #6b7280;
    font-weight: 400;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
}

/* Navigation Arrows */
.navigation-arrows {
    display: flex;
    gap: 0.75rem;
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
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    color: #1a1a2e;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(10px);
}

.nav-arrow:hover {
    background: #1a1a2e;
    color: #ffffff;
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
}

.nav-arrow:active {
    transform: scale(0.95);
}

.nav-arrow svg {
    width: 20px;
    height: 20px;
}

/* Carousel Container */
.videos-carousel-container {
    position: relative;
    overflow: hidden;
    border-radius: 16px;
}

.videos-carousel {
    display: flex;
    gap: 1.5rem;
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    animation: fadeInUp 0.8s ease-out 0.2s both;
}

/* Video Card Styles */
.video-card {
    background: #ffffff;
    border-radius: 16px;
    overflow: hidden;
    position: relative;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    flex: 0 0 320px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.video-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
}

.video-thumbnail {
    position: relative;
    width: 100%;
    height: 180px;
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    justify-content: center;
}

.video-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.video-card:hover .video-thumbnail img {
    transform: scale(1.05);
}

.video-play-button {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 60px;
    height: 60px;
    background: rgba(0, 0, 0, 0.8);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 24px;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.video-card:hover .video-play-button {
    background: rgba(0, 0, 0, 0.9);
    transform: translate(-50%, -50%) scale(1.1);
}

.video-duration {
    position: absolute;
    bottom: 8px;
    right: 8px;
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 600;
    backdrop-filter: blur(10px);
}

.video-content {
    padding: 1.5rem;
}

.video-title-card {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 0.5rem;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.video-author {
    font-size: 0.875rem;
    color: #6b7280;
    font-weight: 500;
    margin-bottom: 0.5rem;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
}

.video-stats {
    display: flex;
    align-items: center;
    gap: 1rem;
    font-size: 0.75rem;
    color: #9ca3af;
}

.video-views {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.video-likes {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

/* Loading State */
.loading-videos {
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
    .video-container {
        padding: 0 1rem;
    }

    .video-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1.5rem;
    }

    .video-title {
        font-size: 2rem;
    }

    .video-subtitle {
        font-size: 1rem;
    }

    .video-card {
        flex: 0 0 280px;
    }

    .video-thumbnail {
        height: 160px;
    }

    .video-content {
        padding: 1rem;
    }

    .video-title-card {
        font-size: 1rem;
    }
}

@media (max-width: 480px) {
    .video-section {
        padding: 2rem 0;
    }

    .video-card {
        flex: 0 0 260px;
    }

    .video-thumbnail {
        height: 140px;
    }

    .video-play-button {
        width: 50px;
        height: 50px;
        font-size: 20px;
    }
}
</style>

<script>
let currentVideoScroll = 0;
const videoCardWidth = 320 + 24; // card width + gap

document.addEventListener('DOMContentLoaded', function() {
    loadFeaturedVideos();

    // Handle window resize
    window.addEventListener('resize', function() {
        updateVideoArrowStates();
    });

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowLeft') {
            scrollVideos('left');
        } else if (e.key === 'ArrowRight') {
            scrollVideos('right');
        }
    });
});

function loadFeaturedVideos() {
    fetch('/api/videos/featured?limit=8')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(videos => {
            const carousel = document.getElementById('videosCarousel');
            carousel.innerHTML = '';

            if (!videos || videos.length === 0) {
                carousel.innerHTML = '<div class="loading-videos"><p>No featured videos found.</p></div>';
                return;
            }

            videos.forEach((video, index) => {
                const videoCard = createVideoCard(video, index);
                carousel.appendChild(videoCard);
            });

            // Initialize arrow states after loading
            setTimeout(() => {
                updateVideoArrowStates();
            }, 100);
        })
        .catch(error => {
            console.error('Error loading videos:', error);
            const carousel = document.getElementById('videosCarousel');
            carousel.innerHTML = '<div class="loading-videos"><p>Error loading videos. Please try again later.</p></div>';
        });
}

function createVideoCard(video, index) {
    const card = document.createElement('div');
    card.className = 'video-card';
    card.onclick = () => openVideo(video);

    card.innerHTML = `
        <div class="video-thumbnail" style="background-image: url('${video.thumbnail_url || 'https://via.placeholder.com/320x180'}')">
            <img src="${video.thumbnail_url || 'https://via.placeholder.com/320x180'}" alt="${video.title}">
            <div class="video-play-button">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M8 5v14l11-7z"/>
                </svg>
            </div>
            ${video.duration ? `<div class="video-duration">${video.duration}</div>` : ''}
        </div>
        <div class="video-content">
            <h3 class="video-title-card">${video.title}</h3>
            <p class="video-author">${video.author_name || 'Unknown Author'}</p>
            <div class="video-stats">
                <div class="video-views">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                    </svg>
                    ${formatNumber(video.views_count || 0)} views
                </div>
                <div class="video-likes">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                    ${formatNumber(video.likes_count || 0)} likes
                </div>
            </div>
        </div>
    `;

    return card;
}

function openVideo(video) {
    // Open video in a modal or new tab
    if (video.video_url) {
        window.open(video.video_url, '_blank');
    }
}

function scrollVideos(direction) {
    const carousel = document.getElementById('videosCarousel');
    const container = carousel.parentElement;
    const visibleCards = Math.floor(container.clientWidth / videoCardWidth);
    const totalCards = carousel.children.length;
    const maxScroll = Math.max(0, (totalCards - visibleCards) * videoCardWidth);

    if (direction === 'left') {
        currentVideoScroll = Math.max(0, currentVideoScroll - videoCardWidth);
    } else {
        currentVideoScroll = Math.min(maxScroll, currentVideoScroll + videoCardWidth);
    }

    carousel.style.transform = `translateX(-${currentVideoScroll}px)`;

    // Update arrow states
    updateVideoArrowStates();
}

function updateVideoArrowStates() {
    const carousel = document.getElementById('videosCarousel');
    const container = carousel.parentElement;
    const visibleCards = Math.floor(container.clientWidth / videoCardWidth);
    const totalCards = carousel.children.length;
    const maxScroll = Math.max(0, (totalCards - visibleCards) * videoCardWidth);

    const leftArrow = document.querySelector('.nav-arrow-left');
    const rightArrow = document.querySelector('.nav-arrow-right');

    if (leftArrow) {
        leftArrow.style.opacity = currentVideoScroll <= 0 ? '0.5' : '1';
        leftArrow.style.pointerEvents = currentVideoScroll <= 0 ? 'none' : 'auto';
    }

    if (rightArrow) {
        rightArrow.style.opacity = currentVideoScroll >= maxScroll ? '0.5' : '1';
        rightArrow.style.pointerEvents = currentVideoScroll >= maxScroll ? 'none' : 'auto';
    }
}

function formatNumber(num) {
    if (num >= 1000000) {
        return (num / 1000000).toFixed(1) + 'M';
    } else if (num >= 1000) {
        return (num / 1000).toFixed(1) + 'K';
    }
    return num.toString();
}
</script>
