<!-- Latest Articles Section -->
<section class="latest-articles-section">
    <div class="latest-articles-container">
        <div class="articles-layout">
            <!-- Main Content Area -->
            <div class="articles-main">
                <!-- Section Header -->
                <div class="articles-header">
                    <div class="header-content">
                        <h2 class="articles-title">{{ setting('articles_section_title', 'Latest articles') }}</h2>
                        <p class="articles-subtitle">{{ setting('articles_section_subtitle', 'Explore the most popular categories') }}</p>
                    </div>
                </div>

                <!-- Articles Grid -->
                <div class="articles-grid" id="articlesGrid">
                    <!-- All internal sections removed as requested -->
                    <div class="empty-content">
                        <p>Content sections have been removed as requested.</p>
                    </div>
                </div>

                <!-- Load More Button - Removed -->
            </div>

            <!-- Right Sidebar - Empty -->
            <div class="articles-sidebar">
                <!-- All sidebar content removed as requested -->
            </div>
        </div>
    </div>
</section>

<style>
/* Latest Articles Section Styles */
.latest-articles-section {
    background: #f8fafc;
    padding: 4rem 0;
    margin: 2rem 0;
}

.latest-articles-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
}

.articles-layout {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 2rem;
    align-items: start;
}

.articles-main {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.articles-header {
    margin-bottom: 2rem;
    text-align: center;
}

.articles-title {
    font-size: 2rem;
    font-weight: 700;
    color: #1a202c;
    margin-bottom: 0.5rem;
}

.articles-subtitle {
    font-size: 1rem;
    color: #6b7280;
    margin: 0;
}

.articles-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.empty-content {
    grid-column: 1 / -1;
    text-align: center;
    padding: 3rem;
    color: #6b7280;
    font-style: italic;
}

.articles-sidebar {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    height: fit-content;
}

/* Responsive Design */
@media (max-width: 768px) {
    .articles-layout {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .articles-main {
        padding: 1.5rem;
    }
    
    .articles-grid {
        grid-template-columns: 1fr;
    }
    
    .articles-title {
        font-size: 1.5rem;
    }
}
</style>

<script>
// Latest Articles JavaScript - Simplified
document.addEventListener('DOMContentLoaded', function() {
    // All internal sections have been removed as requested
    console.log('Latest Articles section loaded - content sections removed');
});
</script>