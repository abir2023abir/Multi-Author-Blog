<?php $__env->startSection('content'); ?>
<!-- Main Content -->
<div class="bg-white min-h-screen" id="mainContent">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <div class="text-content">
                    <h1 class="hero-title">
                        দূর থেকে লিখি, মনে রাখি কাছের মানুষ আর শহরকে
                    </h1>
                    <p class="hero-description">
                        💫 Let's keep sharing the stories that connect our hearts.
                    </p>
                    <a href="<?php echo e(route('posts.index')); ?>" class="cta-button">Read More</a>
                </div>

                <div class="image-gallery">
                    <img src="https://images.unsplash.com/photo-1526045612212-70caf35c14df" class="image-card img-1" alt="Camera and photos" />
                    <img src="https://images.unsplash.com/photo-1516035069371-29a1b244cc32" class="image-card img-2" alt="Vintage camera" />
                    <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c" class="image-card img-3" alt="Delicious food" />
                    <img src="https://images.unsplash.com/photo-1490750967868-88aa4486c946" class="image-card img-4" alt="Beautiful flowers" />
                    <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4" class="image-card img-5" alt="Sunset landscape" />
                </div>
            </div>
        </div>
    </section>




    <!-- Real-time Posts Section -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Latest Posts</h2>
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse" id="live-indicator"></div>
                    <span class="text-sm text-gray-600" id="live-text">Live Updates</span>
                </div>
            </div>

            <!-- Posts Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="posts-container">
            <?php $__empty_1 = true; $__currentLoopData = $latestPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 post-card" data-post-id="<?php echo e($post->id); ?>">
                    <?php if($post->featured_image): ?>
                        <div class="aspect-w-16 aspect-h-9">
                            <img src="<?php echo e(Storage::url($post->featured_image)); ?>" alt="<?php echo e($post->title); ?>" class="w-full h-48 object-cover">
                        </div>
                    <?php endif; ?>
                    <div class="p-6">
                        <div class="flex items-center space-x-2 mb-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <?php echo e($post->category->name); ?>

                            </span>
                            <span class="text-sm text-gray-500"><?php echo e($post->created_at->diffForHumans()); ?></span>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2 line-clamp-2">
                            <a href="<?php echo e(route('posts.show', $post)); ?>" class="hover:text-blue-600 transition-colors">
                                <?php echo e($post->title); ?>

                            </a>
                        </h3>
                        <p class="text-gray-600 mb-4 line-clamp-3"><?php echo e(Str::limit(strip_tags($post->content), 120)); ?></p>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-medium text-gray-700"><?php echo e(substr($post->user->name, 0, 1)); ?></span>
                                </div>
                                <span class="text-sm text-gray-600"><?php echo e($post->user->name); ?></span>
                            </div>
                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                <span class="flex items-center space-x-1">
                                    <span class="material-symbols-outlined text-sm">visibility</span>
                                    <span><?php echo e($post->view_count ?? 0); ?></span>
                                </span>
                                <span class="flex items-center space-x-1">
                                    <span class="material-symbols-outlined text-sm">schedule</span>
                                    <span><?php echo e($post->reading_time ?? '5'); ?> min read</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-full text-center py-12">
                    <div class="text-gray-500">
                        <span class="material-symbols-outlined text-6xl mb-4 block">article</span>
                        <h3 class="text-xl font-semibold mb-2">No posts yet</h3>
                        <p>Be the first to share your story!</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

            <!-- Load More Button -->
            <?php if($latestPosts->hasPages()): ?>
                <div class="text-center mt-12">
                    <button id="load-more-btn" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                        Load More Posts
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer Section -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">Multi Author Blog</h3>
                    <p class="text-gray-400">Discover amazing stories from our community of writers.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">About Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Contact</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Privacy Policy</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Categories</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Technology</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Travel</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Lifestyle</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Connect</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white">Twitter</a>
                        <a href="#" class="text-gray-400 hover:text-white">Facebook</a>
                        <a href="#" class="text-gray-400 hover:text-white">Instagram</a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2024 Multi Author Blog. All rights reserved.</p>
            </div>
        </div>
    </footer>
</div>

<!-- Real-time Scripts -->
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Pusher
    const pusher = new Pusher('<?php echo e(config('broadcasting.connections.pusher.key')); ?>', {
        cluster: '<?php echo e(config('broadcasting.connections.pusher.options.cluster')); ?>',
        encrypted: false,
        wsHost: '<?php echo e(config('broadcasting.connections.pusher.options.host')); ?>',
        wsPort: <?php echo e(config('broadcasting.connections.pusher.options.port')); ?>,
        wssPort: <?php echo e(config('broadcasting.connections.pusher.options.port')); ?>,
        enabledTransports: ['ws', 'wss']
    });

    // Subscribe to posts channel for real-time updates
    const channel = pusher.subscribe('posts');

    // Handle new post events
    channel.bind('new-post', function(data) {
        console.log('New post received:', data);
        addNewPost(data.post);
        showNotification('New post published: ' + data.post.title, 'success');
    });

    // Handle post updated events
    channel.bind('post-updated', function(data) {
        console.log('Post updated:', data);
        updatePost(data.post);
        showNotification('Post updated: ' + data.post.title, 'info');
    });

    // Handle post deleted events
    channel.bind('post-deleted', function(data) {
        console.log('Post deleted:', data);
        removePost(data.post_id);
        showNotification('Post deleted', 'warning');
    });

    // Function to add new post to the page
    function addNewPost(post) {
        const postsContainer = document.getElementById('posts-container');
        const postElement = createPostElement(post);

        // Add to the beginning of the container
        postsContainer.insertBefore(postElement, postsContainer.firstChild);

        // Add animation
        postElement.style.opacity = '0';
        postElement.style.transform = 'translateY(-20px)';
        setTimeout(() => {
            postElement.style.transition = 'all 0.3s ease';
            postElement.style.opacity = '1';
            postElement.style.transform = 'translateY(0)';
        }, 100);
    }

    // Function to update existing post
    function updatePost(post) {
        const existingPost = document.querySelector(`[data-post-id="${post.id}"]`);
        if (existingPost) {
            const newPostElement = createPostElement(post);
            existingPost.parentNode.replaceChild(newPostElement, existingPost);
        }
    }

    // Function to remove post
    function removePost(postId) {
        const postElement = document.querySelector(`[data-post-id="${postId}"]`);
        if (postElement) {
            postElement.style.transition = 'all 0.3s ease';
            postElement.style.opacity = '0';
            postElement.style.transform = 'translateY(-20px)';
            setTimeout(() => {
                postElement.remove();
            }, 300);
        }
    }

    // Function to create post element
    function createPostElement(post) {
        const article = document.createElement('article');
        article.className = 'bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 post-card';
        article.setAttribute('data-post-id', post.id);

        const featuredImage = post.featured_image ?
            `<div class="aspect-w-16 aspect-h-9">
                <img src="/storage/${post.featured_image}" alt="${post.title}" class="w-full h-48 object-cover">
            </div>` : '';

        const content = post.content ? post.content.replace(/<[^>]*>/g, '') : '';
        const excerpt = content.length > 120 ? content.substring(0, 120) + '...' : content;

        article.innerHTML = `
            ${featuredImage}
            <div class="p-6">
                <div class="flex items-center space-x-2 mb-3">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        ${post.category ? post.category.name : 'Uncategorized'}
                    </span>
                    <span class="text-sm text-gray-500">${new Date(post.created_at).toLocaleDateString()}</span>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2 line-clamp-2">
                    <a href="/posts/${post.id}" class="hover:text-blue-600 transition-colors">
                        ${post.title}
                    </a>
                </h3>
                <p class="text-gray-600 mb-4 line-clamp-3">${excerpt}</p>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                            <span class="text-sm font-medium text-gray-700">${post.user ? post.user.name.charAt(0) : 'U'}</span>
                        </div>
                        <span class="text-sm text-gray-600">${post.user ? post.user.name : 'Unknown Author'}</span>
                    </div>
                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                        <span class="flex items-center space-x-1">
                            <span class="material-symbols-outlined text-sm">visibility</span>
                            <span>${post.view_count || 0}</span>
                        </span>
                        <span class="flex items-center space-x-1">
                            <span class="material-symbols-outlined text-sm">schedule</span>
                            <span>${post.reading_time || 5} min read</span>
                        </span>
                    </div>
                </div>
            </div>
        `;

        return article;
    }

    // Function to show notifications
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white ${
            type === 'success' ? 'bg-green-500' :
            type === 'warning' ? 'bg-yellow-500' :
            type === 'error' ? 'bg-red-500' : 'bg-blue-500'
        }`;
        notification.textContent = message;

        document.body.appendChild(notification);

        // Auto remove after 5 seconds
        setTimeout(() => {
            notification.style.transition = 'all 0.3s ease';
            notification.style.opacity = '0';
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 5000);
    }

    // Load more functionality
    const loadMoreBtn = document.getElementById('load-more-btn');
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            // This would typically make an AJAX request to load more posts
            // For now, we'll just show a message
            showNotification('Load more functionality coming soon!', 'info');
        });
    }

    // Connection status indicator
    function updateConnectionStatus(connected) {
        const indicator = document.getElementById('live-indicator');
        const text = document.getElementById('live-text');

        if (connected) {
            indicator.className = 'w-3 h-3 bg-green-500 rounded-full animate-pulse';
            text.textContent = 'Live Updates';
        } else {
            indicator.className = 'w-3 h-3 bg-red-500 rounded-full';
            text.textContent = 'Connection Lost';
        }
    }

    // Monitor connection status
    pusher.connection.bind('connected', () => {
        console.log('Connected to Pusher');
        updateConnectionStatus(true);
    });

    pusher.connection.bind('disconnected', () => {
        console.log('Disconnected from Pusher');
        updateConnectionStatus(false);
    });

    pusher.connection.bind('error', (error) => {
        console.error('Pusher connection error:', error);
        updateConnectionStatus(false);
    });
});
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Laravel Projects\Multi Author Blog\resources\views\home.blade.php ENDPATH**/ ?>