<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\BadgeCalculationService;

class UpdateBadgesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'badges:update {--user= : Update specific user by ID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update user badges and rankings based on their activities';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $badgeService = new BadgeCalculationService();
        
        if ($userId = $this->option('user')) {
            $user = \App\Models\User::find($userId);
            
            if (!$user) {
                $this->error("User with ID {$userId} not found.");
                return 1;
            }
            
            $this->info("Updating badge for user: {$user->name}");
            $badgeService->updateUserBadge($user);
            $this->info("Badge updated successfully!");
        } else {
            $this->info("Updating all user badges and rankings...");
            $badgeService->recalculateAllBadges();
            $this->info("All badges and rankings updated successfully!");
        }
        
        return 0;
    }
}