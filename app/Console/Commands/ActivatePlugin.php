<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Setting;

class ActivatePlugin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plugin:activate {plugin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Activate a plugin for the application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $pluginName = $this->argument('plugin');

        // Available plugins
        $availablePlugins = [
            'post-scheduler' => 'Post Scheduler - Schedule posts for future publication',
            'social-share' => 'Social Share - Enable social media sharing',
            'analytics' => 'Analytics - Track site analytics',
            'backup' => 'Backup - Automated database backups',
            'sitemap' => 'Sitemap Generator - Auto-generate XML sitemaps',
        ];

        if (!array_key_exists($pluginName, $availablePlugins)) {
            $this->error("Plugin '{$pluginName}' not found!");
            $this->info("\nAvailable plugins:");
            foreach ($availablePlugins as $key => $description) {
                $this->line("  - {$key}: {$description}");
            }
            return Command::FAILURE;
        }

        // Activate the plugin
        Setting::updateOrCreate(
            ['key' => "plugin_{$pluginName}"],
            ['value' => 'active', 'type' => 'plugin']
        );

        // Plugin-specific activation logic
        switch ($pluginName) {
            case 'post-scheduler':
                $this->activatePostScheduler();
                break;
            case 'social-share':
                $this->info('Social Share plugin activated - share buttons enabled.');
                break;
            case 'analytics':
                $this->info('Analytics plugin activated - tracking enabled.');
                break;
            case 'backup':
                $this->info('Backup plugin activated - automated backups enabled.');
                break;
            case 'sitemap':
                $this->info('Sitemap Generator activated - auto-generation enabled.');
                break;
        }

        $this->info("\n✅ Plugin '{$pluginName}' activated successfully!");
        return Command::SUCCESS;
    }

    /**
     * Activate Post Scheduler plugin
     */
    protected function activatePostScheduler()
    {
        // Add 'scheduled' status to posts if not exists
        \Illuminate\Support\Facades\Schema::table('posts', function ($table) {
            // Check if we need to add any columns for scheduling
            // (status column already supports 'scheduled')
        });

        $this->info('Post Scheduler activated:');
        $this->line('  - Posts can now be scheduled for future publication');
        $this->line('  - Set published_at date in the future when creating posts');
        $this->line('  - Run: php artisan schedule:work to process scheduled posts');
    }
}

