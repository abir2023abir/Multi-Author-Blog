<?php

namespace App\Observers;

use App\Events\DatabaseUpdated;
use App\Models\Category;
use Carbon\Carbon;

class CategoryObserver
{
    /**
     * Safely convert a timestamp to ISO string format
     */
    private function toISOString($timestamp): string
    {
        if ($timestamp instanceof Carbon) {
            return $timestamp->toISOString();
        }
        
        if (is_string($timestamp)) {
            return Carbon::parse($timestamp)->toISOString();
        }
        
        return now()->toISOString();
    }
    /**
     * Handle the Category "created" event.
     */
    public function created(Category $category): void
    {
        broadcast(new DatabaseUpdated('category', 'created', [
            'id' => $category->id,
            'name' => $category->name,
            'slug' => $category->slug,
            'created_at' => $this->toISOString($category->created_at),
        ]))->toOthers();
    }

    /**
     * Handle the Category "updated" event.
     */
    public function updated(Category $category): void
    {
        broadcast(new DatabaseUpdated('category', 'updated', [
            'id' => $category->id,
            'name' => $category->name,
            'slug' => $category->slug,
            'updated_at' => $this->toISOString($category->updated_at),
        ]))->toOthers();
    }

    /**
     * Handle the Category "deleted" event.
     */
    public function deleted(Category $category): void
    {
        broadcast(new DatabaseUpdated('category', 'deleted', [
            'id' => $category->id,
            'name' => $category->name,
        ]))->toOthers();
    }
}
