<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, user-scalable=yes, viewport-fit=cover">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <!-- Mobile Web App Meta Tags -->
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Multi Author Blog">
    <meta name="application-name" content="Multi Author Blog">
    <meta name="theme-color" content="#1a1a2e">
    <meta name="msapplication-TileColor" content="#1a1a2e">
    <meta name="msapplication-config" content="/browserconfig.xml">

    <title><?php echo e($title ?? 'Multi Author Blog'); ?></title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css']); ?>

    <!-- Responsive Design CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('css/responsive.css')); ?>">

    <!-- Hero Section CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('css/hero.css')); ?>">

    <!-- Trending Topics CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('css/trending-topics.css')); ?>">

    <!-- Footer CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('css/footer.css')); ?>">

    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        /* Text clamping utilities */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* ===== COMPREHENSIVE RESPONSIVE UTILITIES ===== */

        /* Mobile-first base styles */
        * {
            -webkit-tap-highlight-color: transparent;
        }

        /* Smooth scrolling for all devices */
        html {
            scroll-behavior: smooth;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        /* Body responsive optimizations */
        body {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
            overflow-x: hidden;
        }

        /* Touch-friendly button sizes */
        @media (hover: none) and (pointer: coarse) {
            button, .btn, a[role="button"] {
                min-height: 44px;
                min-width: 44px;
            }
        }

        /* Responsive typography scaling */
        @media (max-width: 767px) {
            html {
                font-size: 14px;
            }
        }

        @media (min-width: 768px) and (max-width: 1023px) {
            html {
                font-size: 15px;
            }
        }

        @media (min-width: 1024px) {
            html {
                font-size: 16px;
            }
        }

        /* Container responsive padding */
        .container, .max-w-7xl {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        @media (min-width: 640px) {
            .container, .max-w-7xl {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }
        }

        @media (min-width: 1024px) {
            .container, .max-w-7xl {
                padding-left: 2rem;
                padding-right: 2rem;
            }
        }

        /* Footer responsive adjustments */
        footer {
            font-size: 0.875rem;
        }

        @media (max-width: 767px) {
            footer {
                padding: 1.5rem 0;
                font-size: 0.8rem;
            }
        }

        /* Image optimization for different devices */
        img {
            max-width: 100%;
            height: auto;
            image-rendering: -webkit-optimize-contrast;
        }

        /* iOS Safari viewport height fix */
        @supports (-webkit-touch-callout: none) {
            .min-h-screen {
                min-height: -webkit-fill-available;
            }
        }

        /* Android Chrome optimizations */
        @media screen and (-webkit-min-device-pixel-ratio: 2) {
            img {
                image-rendering: -webkit-optimize-contrast;
            }
        }

        /* High DPI display optimizations */
        @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
            img {
                image-rendering: -webkit-optimize-contrast;
            }
        }

        /* Landscape orientation adjustments */
        @media (max-height: 500px) and (orientation: landscape) {
            .min-h-screen {
                min-height: 100vh;
            }
        }

        /* Reduced motion preferences */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
                scroll-behavior: auto !important;
            }
        }

        /* Force light mode - override any dark theme */
        html, body {
            background-color: white !important;
            color: black !important;
        }

        .bg-gray-50, .bg-white {
            background-color: white !important;
        }

        .text-gray-900, .text-black {
            color: black !important;
        }

        .text-gray-700 {
            color: #374151 !important;
        }

        .text-gray-600 {
            color: #4b5563 !important;
        }

        /* Override any dark mode classes */
        .dark\:bg-gray-800 {
            background-color: white !important;
        }

        .dark\:text-white {
            color: black !important;
        }

        .dark\:text-gray-300 {
            color: #374151 !important;
        }

        .dark\:text-gray-400 {
            color: #6b7280 !important;
        }

        .dark\:border-gray-600 {
            border-color: #e5e7eb !important;
        }

        /* Print styles */
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                font-size: 12pt;
                line-height: 1.4;
            }
        }
    </style>
</head>
<body class="bg-white">
    <!-- Navigation Bar -->
    <?php if (isset($component)) { $__componentOriginalf75d29720390c8e1fa3307604849a543 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf75d29720390c8e1fa3307604849a543 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.navigation','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('navigation'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf75d29720390c8e1fa3307604849a543)): ?>
<?php $attributes = $__attributesOriginalf75d29720390c8e1fa3307604849a543; ?>
<?php unset($__attributesOriginalf75d29720390c8e1fa3307604849a543); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf75d29720390c8e1fa3307604849a543)): ?>
<?php $component = $__componentOriginalf75d29720390c8e1fa3307604849a543; ?>
<?php unset($__componentOriginalf75d29720390c8e1fa3307604849a543); ?>
<?php endif; ?>

    <!-- Main Content -->
    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 responsive-footer">
        <div class="max-w-7xl mx-auto px-responsive">
            <div class="text-center">
                <p class="text-responsive-sm">&copy; <?php echo e(date('Y')); ?> Multi Author Blog. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/app.js']); ?>

    <!-- Alpine.js for dropdown functionality -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Hero Section JavaScript -->
    <script src="<?php echo e(asset('js/hero.js')); ?>"></script>
</body>
</html>
<?php /**PATH E:\Laravel Projects\Multi Author Blog\resources\views/layouts/app.blade.php ENDPATH**/ ?>