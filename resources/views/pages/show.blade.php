Build a fully functional Site Analytics section for my admin panel dashboard.

Requirements:

Create a dashboard analytics card layout like a professional admin panel, showing:

Sessions (Total active sessions)

Visitors (Unique visitors)

Pageviews

Bounce Rate (%)

Add a line + area chart for visitors and sessions by hour (0h–23h) using Chart.js or ApexCharts.

Add a world map visualization (use jsVectorMap or react-simple-maps) to show visitor distribution by country.

Fetch real analytics data dynamically using Google Analytics API (GA4) or Matomo API.

If analytics tracking is not set up, include installation steps and code snippet for integrating Google Analytics tracking script into the main app (frontend).

Show all stats summary (Sessions, Visitors, Pageviews, Bounce Rate) in modern info boxes with icons and colors similar to:

Pink for Sessions

Green for Visitors

Blue for Pageviews

Yellow for Bounce Rate

Make the design responsive, animated, and clean, using TailwindCSS and ShadCN UI components.

Integrate everything into the existing admin dashboard page component (e.g., DashboardAnalytics.jsx or AdminDashboard.vue depending on framework).

Data should auto-refresh every 5 minutes.

Output should include:

Full working code (frontend + backend if needed)

Instructions for connecting Google Analytics or Matomo

Example mock data if real API keys aren’t available

The goal is to have a live analytics dashboard inside my admin panel that looks exactly like professional SaaS dashboards.
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
<div class="max-w-4xl mx-auto">
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
<h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">{{ $page->title }}</h1>

<div class="prose prose-lg max-w-none text-gray-700 dark:text-gray-300">
{!! nl2br(e($page->content)) !!}
</div>

@if($page->meta_description)
<div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
<p class="text-sm text-gray-500 dark:text-gray-400">{{ $page->meta_description }}</p>
</div>
@endif

<div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
<p class="text-sm text-gray-500 dark:text-gray-400">
Last updated: {{ $page->updated_at->format('F d, Y') }}
</p>
</div>
</div>
</div>
</div>
@endsection
