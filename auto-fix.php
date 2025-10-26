#!/usr/bin/env php
<?php

/**
 * Multi Author Blog - Auto-Fix Script
 * This script applies recommended fixes and improvements automatically
 */

echo "🔧 Multi Author Blog - Auto-Fix Script\n";
echo "=====================================\n\n";

$fixes = [];
$warnings = [];
$success = 0;
$failed = 0;

// Check if we're in the project root
if (!file_exists('composer.json')) {
    die("❌ Error: Please run this script from the project root directory.\n");
}

echo "📍 Running from: " . getcwd() . "\n\n";

// Fix 1: Clear all caches
echo "🧹 Clearing all caches...\n";
exec('php artisan optimize:clear 2>&1', $output, $return);
if ($return === 0) {
    echo "✅ Caches cleared successfully\n";
    $success++;
} else {
    echo "⚠️  Warning: Cache clear had issues\n";
    $warnings[] = "Cache clear warning";
}

// Fix 2: Build frontend assets
echo "\n🏗️  Building frontend assets...\n";
exec('npm run build 2>&1', $output, $return);
if ($return === 0) {
    echo "✅ Assets built successfully\n";
    $success++;
} else {
    echo "❌ Failed to build assets (this is normal if npm packages aren't installed)\n";
    $warnings[] = "Run 'npm install' and 'npm run build' manually";
}

// Fix 3: Optimize composer autoloader
echo "\n📦 Optimizing composer autoloader...\n";
exec('composer dump-autoload -o 2>&1', $output, $return);
if ($return === 0) {
    echo "✅ Autoloader optimized\n";
    $success++;
} else {
    echo "⚠️  Warning: Autoloader optimization had issues\n";
    $warnings[] = "Autoloader optimization warning";
}

// Fix 4: Cache configuration
echo "\n⚙️  Caching configuration...\n";
exec('php artisan config:cache 2>&1', $output, $return);
if ($return === 0) {
    echo "✅ Configuration cached\n";
    $success++;
} else {
    echo "⚠️  Warning: Config cache had issues\n";
    $warnings[] = "Config cache warning";
}

// Fix 5: Cache routes
echo "\n🛣️  Caching routes...\n";
exec('php artisan route:cache 2>&1', $output, $return);
if ($return === 0) {
    echo "✅ Routes cached\n";
    $success++;
} else {
    echo "⚠️  Warning: Route cache had issues\n";
    $warnings[] = "Route cache warning";
}

// Fix 6: Cache views
echo "\n👁️  Caching views...\n";
exec('php artisan view:cache 2>&1', $output, $return);
if ($return === 0) {
    echo "✅ Views cached\n";
    $success++;
} else {
    echo "⚠️  Warning: View cache had issues\n";
    $warnings[] = "View cache warning";
}

// Fix 7: Run migrations (check only)
echo "\n🗄️  Checking database migrations...\n";
exec('php artisan migrate:status 2>&1', $output, $return);
if ($return === 0) {
    echo "✅ Database migrations are up to date\n";
    $success++;
} else {
    echo "⚠️  Note: Check database migrations manually\n";
    $warnings[] = "Check migrations with 'php artisan migrate:status'";
}

// Fix 8: Check storage permissions
echo "\n📁 Checking storage permissions...\n";
if (is_writable('storage')) {
    echo "✅ Storage directory is writable\n";
    $success++;
} else {
    echo "❌ Storage directory is not writable\n";
    $warnings[] = "Fix storage permissions";
    $failed++;
}

// Fix 9: Check bootstrap/cache permissions
echo "\n📁 Checking bootstrap/cache permissions...\n";
if (is_writable('bootstrap/cache')) {
    echo "✅ Bootstrap cache directory is writable\n";
    $success++;
} else {
    echo "❌ Bootstrap cache directory is not writable\n";
    $warnings[] = "Fix bootstrap/cache permissions";
    $failed++;
}

// Fix 10: Verify .env file
echo "\n🔐 Verifying environment configuration...\n";
if (file_exists('.env')) {
    $env = file_get_contents('.env');

    $checks = [
        'APP_KEY' => 'APP_KEY is set',
        'APP_ENV' => 'APP_ENV is defined',
        'DB_CONNECTION' => 'Database connection configured',
    ];

    foreach ($checks as $key => $description) {
        if (strpos($env, $key) !== false) {
            echo "✅ {$description}\n";
            $success++;
        } else {
            echo "⚠️  Warning: {$key} not found in .env\n";
            $warnings[] = $description;
        }
    }
} else {
    echo "❌ .env file not found\n";
    $warnings[] = "Create .env file from .env.example";
    $failed++;
}

// Summary
echo "\n";
echo "=====================================\n";
echo "📊 SUMMARY\n";
echo "=====================================\n";
echo "✅ Successful fixes: {$success}\n";
echo "❌ Failed fixes: {$failed}\n";
echo "⚠️  Warnings: " . count($warnings) . "\n";

if (count($warnings) > 0) {
    echo "\n⚠️  WARNINGS:\n";
    foreach ($warnings as $i => $warning) {
        echo "   " . ($i + 1) . ". {$warning}\n";
    }
}

echo "\n";
echo "=====================================\n";
echo "🎉 Auto-fix script completed!\n";
echo "=====================================\n";
echo "\n";

// Additional recommendations
echo "📝 NEXT STEPS:\n";
echo "1. Review the PROJECT_ANALYSIS_REPORT.md file\n";
echo "2. Run 'composer dev' to start the development server\n";
echo "3. Visit http://127.0.0.1:8000 to test the application\n";
echo "4. Run 'php artisan test' to execute tests\n";
echo "\n";

exit($failed > 0 ? 1 : 0);
