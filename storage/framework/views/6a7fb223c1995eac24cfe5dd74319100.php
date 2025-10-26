<?php $__env->startSection('title', 'All Posts - Multi Author Blog'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-gray-50 min-h-screen">
    <!-- Professional Header Section -->
    <div class="relative bg-gradient-to-br from-slate-900 via-blue-900 to-indigo-900 text-white py-20 overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%239C92AC" fill-opacity="0.1"%3E%3Ccircle cx="30" cy="30" r="4"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <div class="inline-flex items-center px-4 py-2 bg-white bg-opacity-90 rounded-full text-sm font-medium mb-6 backdrop-blur-sm text-gray-800">
                    <span class="material-symbols-outlined mr-2 text-gray-700">article</span>
                    Community Stories
                </div>
                <h1 class="text-5xl font-bold mb-6 text-white">
                    Discover Amazing Stories
                </h1>
                <p class="text-xl text-gray-200 max-w-2xl mx-auto leading-relaxed">
                    Explore a curated collection of stories, insights, and experiences from our talented community of writers and creators.
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Main Content -->
            <div class="lg:w-3/4">
                <!-- Professional Filters Section -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8 mb-12">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                <span class="material-symbols-outlined text-white text-lg">tune</span>
                            </div>
                            <div>
                                <h2 class="text-xl font-semibold text-gray-800">Filter & Search</h2>
                                <p class="text-sm text-gray-600">Find exactly what you're looking for</p>
                            </div>
                        </div>
                        <div class="text-sm text-gray-500">
                            <?php echo e($posts->total()); ?> <?php echo e(Str::plural('post', $posts->total())); ?> found
                        </div>
                    </div>

                    <form method="GET" action="<?php echo e(route('posts.index')); ?>" id="filterForm" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Search -->
                            <div class="space-y-2">
                                <label for="search" class="block text-sm font-medium text-gray-800">Search Posts</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="material-symbols-outlined text-gray-400">search</span>
                                    </div>
                                    <input type="text"
                                           id="search"
                                           name="search"
                                           value="<?php echo e(request('search')); ?>"
                                           placeholder="Search by title or content..."
                                           class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white">
                                </div>
                            </div>

                            <!-- Category Filter -->
                            <div class="space-y-2">
                                <label for="category" class="block text-sm font-medium text-gray-800">Category</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="material-symbols-outlined text-gray-400">category</span>
                                    </div>
                                    <select name="category" id="category" class="w-full pl-10 pr-10 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white appearance-none cursor-pointer">
                                        <option value="">All Categories</option>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category->name); ?>" <?php echo e(request('category') == $category->name ? 'selected' : ''); ?>>
                                                <?php echo e($category->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="material-symbols-outlined text-gray-400">expand_more</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Sort -->
                            <div class="space-y-2">
                                <label for="sort" class="block text-sm font-medium text-gray-800">Sort By</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="material-symbols-outlined text-gray-400">sort</span>
                                    </div>
                                    <select name="sort" id="sort" class="w-full pl-10 pr-10 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white appearance-none cursor-pointer">
                                        <option value="latest" <?php echo e(request('sort') == 'latest' ? 'selected' : ''); ?>>Latest</option>
                                        <option value="popular" <?php echo e(request('sort') == 'popular' ? 'selected' : ''); ?>>Most Popular</option>
                                        <option value="oldest" <?php echo e(request('sort') == 'oldest' ? 'selected' : ''); ?>>Oldest</option>
                                        <option value="alphabetical" <?php echo e(request('sort') == 'alphabetical' ? 'selected' : ''); ?>>A-Z</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="material-symbols-outlined text-gray-400">expand_more</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                            <button type="submit" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-3 rounded-xl hover:from-blue-700 hover:to-purple-700 transition-all duration-200 font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center space-x-2">
                                <span class="material-symbols-outlined text-sm">filter_list</span>
                                <span>Apply Filters</span>
                            </button>
                            <a href="<?php echo e(route('posts.index')); ?>" class="text-gray-500 hover:text-gray-700 transition-colors flex items-center space-x-2">
                                <span class="material-symbols-outlined text-sm">refresh</span>
                                <span>Clear Filters</span>
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Professional Posts Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <article class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-blue-200 transform hover:-translate-y-1">
                            <?php if($post->featured_image): ?>
                                <div class="relative overflow-hidden">
                                    <img src="<?php echo e(Storage::url($post->featured_image)); ?>"
                                         alt="<?php echo e($post->title); ?>"
                                         class="w-full h-56 object-cover group-hover:scale-105 transition-transform duration-300">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                                    <div class="absolute top-4 left-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-white/90 text-gray-800 backdrop-blur-sm">
                                            <?php echo e($post->category->name ?? 'Uncategorized'); ?>

                                        </span>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="h-56 bg-gradient-to-br from-blue-50 to-purple-50 flex items-center justify-center">
                                    <div class="text-center">
                                        <span class="material-symbols-outlined text-4xl text-gray-400 mb-2">article</span>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-white/90 text-gray-800">
                                            <?php echo e($post->category->name ?? 'Uncategorized'); ?>

                                        </span>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-sm text-gray-500 flex items-center">
                                        <span class="material-symbols-outlined text-sm mr-1">schedule</span>
                                        <?php echo e($post->published_at->format('M d, Y')); ?>

                                    </span>
                                    <div class="flex items-center space-x-3 text-sm text-gray-500">
                                        <span class="flex items-center">
                                            <span class="material-symbols-outlined text-sm mr-1">visibility</span>
                                            <?php echo e($post->view_count ?? 0); ?>

                                        </span>
                                        <span class="flex items-center">
                                            <span class="material-symbols-outlined text-sm mr-1">schedule</span>
                                            <?php echo e($post->reading_time ?? '5'); ?>m
                                        </span>
                                    </div>
                                </div>

                                <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2 group-hover:text-blue-600 transition-colors">
                                    <a href="<?php echo e(route('posts.show', $post)); ?>" class="hover:no-underline">
                                        <?php echo e($post->title); ?>

                                    </a>
                                </h3>

                                <p class="text-gray-700 mb-6 line-clamp-3 leading-relaxed"><?php echo e(Str::limit(strip_tags($post->content), 120)); ?></p>

                                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold">
                                            <?php echo e(substr($post->user->name, 0, 1)); ?>

                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-800"><?php echo e($post->user->name); ?></p>
                                            <p class="text-xs text-gray-600">Author</p>
                                        </div>
                                    </div>
                                    <a href="<?php echo e(route('posts.show', $post)); ?>"
                                       class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white text-sm font-medium rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-200 shadow-md hover:shadow-lg">
                                        Read More
                                        <span class="material-symbols-outlined text-sm ml-1">arrow_forward</span>
                                    </a>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="col-span-full text-center py-12">
                            <div class="text-gray-500">
                                <span class="material-symbols-outlined text-6xl mb-4 block">article</span>
                                <h3 class="text-xl font-semibold mb-2">No posts found</h3>
                                <p>Try adjusting your search criteria or browse all posts.</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Pagination -->
                <?php if($posts->hasPages()): ?>
                    <div class="mt-12">
                        <?php echo e($posts->appends(request()->query())->links()); ?>

                    </div>
                <?php endif; ?>
            </div>

            <!-- Professional Sidebar -->
            <div class="lg:w-1/4 space-y-8">
                <!-- Recent Posts -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-blue-600 rounded-lg flex items-center justify-center">
                            <span class="material-symbols-outlined text-white text-lg">schedule</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Recent Posts</h3>
                            <p class="text-sm text-gray-600">Latest from our community</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <?php $__currentLoopData = $recentPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recentPost): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="group flex space-x-3 p-3 rounded-xl hover:bg-gray-50 transition-colors">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-blue-600 rounded-xl flex items-center justify-center text-white font-bold text-sm">
                                        <span class="material-symbols-outlined text-sm">article</span>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-semibold text-gray-800 line-clamp-2 group-hover:text-blue-600 transition-colors">
                                        <a href="<?php echo e(route('posts.show', $recentPost)); ?>" class="hover:no-underline">
                                            <?php echo e($recentPost->title); ?>

                                        </a>
                                    </h4>
                                    <div class="flex items-center space-x-2 mt-1">
                                        <span class="text-xs text-gray-500"><?php echo e($recentPost->user->name); ?></span>
                                        <span class="text-xs text-gray-400">•</span>
                                        <span class="text-xs text-gray-500"><?php echo e($recentPost->published_at->format('M d')); ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <!-- Popular Posts -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 bg-gradient-to-r from-orange-500 to-red-600 rounded-lg flex items-center justify-center">
                            <span class="material-symbols-outlined text-white text-lg">trending_up</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Trending Now</h3>
                            <p class="text-sm text-gray-600">Most popular posts</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <?php $__currentLoopData = $popularPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $popularPost): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="group flex space-x-3 p-3 rounded-xl hover:bg-gray-50 transition-colors">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold text-sm">
                                        <?php echo e($index + 1); ?>

                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-semibold text-gray-800 line-clamp-2 group-hover:text-blue-600 transition-colors">
                                        <a href="<?php echo e(route('posts.show', $popularPost)); ?>" class="hover:no-underline">
                                            <?php echo e($popularPost->title); ?>

                                        </a>
                                    </h4>
                                    <div class="flex items-center space-x-2 mt-1">
                                        <span class="text-xs text-gray-500 flex items-center">
                                            <span class="material-symbols-outlined text-xs mr-1">visibility</span>
                                            <?php echo e($popularPost->view_count ?? 0); ?>

                                        </span>
                                        <span class="text-xs text-gray-400">•</span>
                                        <span class="text-xs text-gray-500"><?php echo e($popularPost->published_at->format('M d')); ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <!-- Categories -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-teal-600 rounded-lg flex items-center justify-center">
                            <span class="material-symbols-outlined text-white text-lg">category</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Categories</h3>
                            <p class="text-sm text-gray-600">Browse by topic</p>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('posts.index', ['category' => $category->name])); ?>"
                               class="group flex items-center justify-between px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 hover:text-gray-800 rounded-xl transition-all duration-200 border border-transparent hover:border-blue-200">
                                <span class="font-medium"><?php echo e($category->name); ?></span>
                                <span class="material-symbols-outlined text-xs opacity-0 group-hover:opacity-100 transition-opacity">arrow_forward</span>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <!-- Newsletter Signup -->
                <div class="bg-gradient-to-br from-blue-600 to-purple-600 rounded-2xl shadow-xl p-6 text-white">
                    <div class="text-center">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <span class="material-symbols-outlined text-2xl">mail</span>
                        </div>
                        <h3 class="text-lg font-bold mb-2">Stay Updated</h3>
                        <p class="text-blue-100 text-sm mb-4">Get the latest stories delivered to your inbox</p>
                        <form class="space-y-3">
                            <input type="email"
                                   placeholder="Enter your email"
                                   class="w-full px-4 py-3 rounded-xl text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-white/50">
                            <button type="submit"
                                    class="w-full bg-white text-blue-600 font-semibold py-3 rounded-xl hover:bg-gray-100 transition-colors">
                                Subscribe
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Clean Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Brand Section -->
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-sm">M</span>
                        </div>
                        <h3 class="text-xl font-bold">Multi Author Blog</h3>
                    </div>
                    <p class="text-gray-300 text-sm mb-4">
                        A platform where stories come to life. Share your experiences and discover amazing content.
                    </p>
                    <div class="flex space-x-3">
                        <a href="#" class="w-8 h-8 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-blue-600 transition-colors">
                            <span class="text-xs">f</span>
                        </a>
                        <a href="#" class="w-8 h-8 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-blue-400 transition-colors">
                            <span class="text-xs">t</span>
                        </a>
                        <a href="#" class="w-8 h-8 bg-gray-800 rounded-lg flex items-center justify-center hover:bg-pink-600 transition-colors">
                            <span class="text-xs">i</span>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="<?php echo e(route('home')); ?>" class="text-gray-300 hover:text-white transition-colors text-sm">Home</a></li>
                        <li><a href="<?php echo e(route('posts.index')); ?>" class="text-gray-300 hover:text-white transition-colors text-sm">All Posts</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Categories</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Popular</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors text-sm">Contact</a></li>
                    </ul>
                </div>

                <!-- Categories -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Categories</h4>
                    <ul class="space-y-2">
                        <?php if($categories->count() > 0): ?>
                            <?php $__currentLoopData = $categories->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><a href="<?php echo e(route('posts.index', ['category' => $category->name])); ?>" class="text-gray-300 hover:text-white transition-colors text-sm"><?php echo e($category->name); ?></a></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <li class="text-gray-400 text-sm">No categories available</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

            <!-- Newsletter Section -->
            <div class="border-t border-gray-800 mt-8 pt-8">
                <div class="max-w-md mx-auto text-center">
                    <h4 class="text-lg font-semibold mb-2">Stay Updated</h4>
                    <p class="text-gray-300 text-sm mb-4">Get the latest stories delivered to your inbox</p>
                    <div class="flex gap-2">
                        <input type="email"
                               placeholder="Enter your email"
                               class="flex-1 px-3 py-2 bg-gray-800 border border-gray-700 rounded text-white placeholder-gray-400 text-sm focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 transition-colors">
                            Subscribe
                        </button>
                    </div>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="border-t border-gray-800 mt-8 pt-6">
                <div class="flex flex-col md:flex-row justify-between items-center text-sm">
                    <div class="text-gray-400 mb-2 md:mb-0">
                        © <?php echo e(date('Y')); ?> Multi Author Blog. All rights reserved.
                    </div>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">Privacy</a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">Terms</a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">Cookies</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form when filters change
    const filterForm = document.getElementById('filterForm');
    const categorySelect = document.getElementById('category');
    const sortSelect = document.getElementById('sort');
    const searchInput = document.getElementById('search');

    // Debounce search input
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            filterForm.submit();
        }, 500);
    });

    // Auto-submit on category or sort change
    categorySelect.addEventListener('change', function() {
        filterForm.submit();
    });

    sortSelect.addEventListener('change', function() {
        filterForm.submit();
    });

    // Add loading state to form submission
    filterForm.addEventListener('submit', function() {
        const submitButton = filterForm.querySelector('button[type="submit"]');
        const originalText = submitButton.innerHTML;
        submitButton.innerHTML = '<span class="material-symbols-outlined text-sm animate-spin">refresh</span><span>Loading...</span>';
        submitButton.disabled = true;

        // Re-enable button after 3 seconds as fallback
        setTimeout(() => {
            submitButton.innerHTML = originalText;
            submitButton.disabled = false;
        }, 3000);
    });

    // Add smooth scrolling to results
    const postsGrid = document.querySelector('.grid');
    if (postsGrid) {
        postsGrid.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    // Add filter indicators
    const urlParams = new URLSearchParams(window.location.search);
    const hasFilters = urlParams.has('search') || urlParams.has('category') || urlParams.has('sort');

    if (hasFilters) {
        const filterIndicator = document.createElement('div');
        filterIndicator.className = 'bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4';
        filterIndicator.innerHTML = `
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <span class="material-symbols-outlined text-blue-600 text-sm">filter_list</span>
                    <span class="text-sm text-blue-800 font-medium">Active Filters:</span>
                </div>
                <a href="<?php echo e(route('posts.index')); ?>" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    Clear All
                </a>
            </div>
            <div class="mt-2 flex flex-wrap gap-2">
                ${urlParams.get('search') ? `<span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">Search: "${urlParams.get('search')}"</span>` : ''}
                ${urlParams.get('category') ? `<span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">Category: "${urlParams.get('category')}"</span>` : ''}
                ${urlParams.get('sort') && urlParams.get('sort') !== 'latest' ? `<span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">Sort: "${urlParams.get('sort')}"</span>` : ''}
            </div>
        `;

        const filterSection = document.querySelector('.bg-white.rounded-2xl');
        if (filterSection) {
            filterSection.insertBefore(filterIndicator, filterSection.firstChild);
        }
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Laravel Projects\Multi Author Blog\resources\views/posts/index.blade.php ENDPATH**/ ?>