@extends('layouts.admin')

@section('content')
@if(session('status'))
<div class="mb-4 rounded-lg bg-green-100 dark:bg-green-900/50 p-4 text-green-700 dark:text-green-300">
{{ session('status') }}
</div>
@endif

<div class="flex flex-wrap justify-between gap-3 pb-8">
<div class="flex flex-col gap-3">
<h1 class="text-slate-800 dark:text-white text-4xl font-black leading-tight tracking-[-0.033em]">Themes</h1>
<p class="text-slate-500 dark:text-[#92adc9] text-base font-normal leading-normal">Manage and customize your site themes.</p>
</div>
<div class="flex items-center gap-4">
<span class="material-symbols-outlined text-slate-500 dark:text-white cursor-pointer">notifications</span>
<div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 bg-gray-300 dark:bg-gray-600"></div>
</div>
</div>

<!-- Dark Mode Toggle -->
<div class="mb-8">
<div class="flex items-center gap-3">
<label class="text-slate-800 dark:text-white text-sm font-medium">Dark Mode</label>
<div class="relative">
<input type="checkbox" id="darkModeToggle" class="sr-only" {{ ($settings['dark_mode'] ?? '0') == '1' ? 'checked' : '' }}>
<label for="darkModeToggle" class="flex items-center cursor-pointer">
<div class="relative">
<div class="w-12 h-6 bg-gray-300 dark:bg-gray-600 rounded-full shadow-inner transition-colors duration-200 {{ ($settings['dark_mode'] ?? '0') == '1' ? 'bg-green-500' : '' }}"></div>
<div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform duration-200 transform {{ ($settings['dark_mode'] ?? '0') == '1' ? 'translate-x-6' : '' }}"></div>
</div>
</label>
</div>
</div>
</div>

<!-- Theme Previews -->
<div class="mb-8">
<h2 class="text-slate-800 dark:text-white text-xl font-bold mb-6">Choose Your Theme</h2>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
@foreach($themes as $theme)
<div class="relative rounded-lg border border-slate-200 dark:border-[#324d67] bg-white dark:bg-[#111a22] overflow-hidden {{ $theme['active'] ? 'ring-2 ring-primary' : '' }}">
<!-- Theme Preview -->
<div class="relative h-64 bg-gray-100 dark:bg-gray-800 overflow-hidden">
@if($theme['slug'] === 'magazine')
<!-- Magazine Preview -->
<div class="absolute inset-0 bg-white">
<div class="h-12 bg-gray-100 flex items-center px-4">
<span class="font-bold text-gray-800">Varient.</span>
<div class="ml-8 flex gap-4 text-sm text-gray-600">
<span>HOME</span><span>LIFE STYLE</span><span>TRAVEL</span><span>FASHION</span>
</div>
</div>
<div class="p-4">
<div class="h-32 bg-gradient-to-r from-pink-200 to-orange-200 rounded mb-4 flex items-center justify-center">
<span class="text-gray-600 text-sm">Hero Image</span>
</div>
<div class="text-sm font-semibold text-gray-800 mb-2">Implementing These goals requires a careful examination.</div>
<div class="text-xs text-gray-600 mb-4">Life Style</div>
<div class="grid grid-cols-2 gap-2">
<div class="h-16 bg-gray-200 rounded"></div>
<div class="h-16 bg-gray-200 rounded"></div>
<div class="h-16 bg-gray-200 rounded"></div>
<div class="h-16 bg-gray-200 rounded"></div>
</div>
</div>
</div>
@elseif($theme['slug'] === 'news')
<!-- News Preview -->
<div class="absolute inset-0 bg-white">
<div class="h-12 bg-gray-100 flex items-center px-4">
<span class="font-bold text-gray-800">Varient.</span>
<div class="ml-8 flex gap-4 text-sm text-gray-600">
<span>HOME</span><span>NEWS</span><span>SPORTS</span><span>POLITICS</span>
</div>
</div>
<div class="p-4">
<div class="text-sm font-semibold text-gray-800 mb-2">Top Headlines</div>
<div class="space-y-1 mb-4">
<div class="h-2 bg-gray-200 rounded"></div>
<div class="h-2 bg-gray-200 rounded w-3/4"></div>
<div class="h-2 bg-gray-200 rounded w-1/2"></div>
</div>
<div class="text-sm font-semibold text-gray-800 mb-2">RSS News</div>
<div class="grid grid-cols-2 gap-2">
<div class="h-12 bg-gray-200 rounded"></div>
<div class="h-12 bg-gray-200 rounded"></div>
</div>
</div>
</div>
@else
<!-- Classic Preview -->
<div class="absolute inset-0 bg-gray-200">
<div class="h-12 bg-white flex items-center px-4">
<span class="font-bold text-gray-800">Varient.</span>
<div class="ml-8 flex gap-4 text-sm text-gray-600">
<span>HOME</span><span>ABOUT</span><span>CONTACT</span><span>BLOG</span>
</div>
</div>
<div class="p-4 bg-white">
<div class="h-24 bg-gradient-to-r from-blue-200 to-purple-200 rounded mb-4 flex items-center justify-center">
<span class="text-gray-600 text-sm">Featured Post</span>
</div>
<div class="text-sm font-semibold text-gray-800 mb-2">TRENDING NOW</div>
<div class="space-y-2">
<div class="h-8 bg-gray-200 rounded"></div>
<div class="h-8 bg-gray-200 rounded"></div>
<div class="h-8 bg-gray-200 rounded"></div>
</div>
</div>
</div>
@endif
</div>

<!-- Theme Info -->
<div class="p-4">
<h3 class="text-slate-800 dark:text-white text-lg font-bold mb-2">{{ $theme['name'] }}</h3>
<p class="text-slate-500 dark:text-[#92adc9] text-sm mb-4">{{ $theme['description'] }}</p>
@if($theme['active'])
<span class="inline-flex items-center justify-center rounded-full bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300 px-2.5 py-0.5 text-xs font-medium">Active</span>
@else
<form method="POST" action="{{ route('admin.themes.activate') }}" class="inline">
@csrf
<input type="hidden" name="theme" value="{{ $theme['slug'] }}">
<button type="submit" class="text-xs font-medium text-primary hover:text-primary/80">Activate</button>
</form>
@endif
</div>
</div>
@endforeach
</div>
</div>

<!-- Theme Settings -->
<div class="rounded-lg border border-slate-200 dark:border-[#324d67] bg-white dark:bg-[#111a22] p-6">
<h2 class="text-slate-800 dark:text-white text-xl font-bold mb-6">Theme Settings</h2>

<form method="POST" action="{{ route('admin.themes.settings') }}">
@csrf
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
<div>
<label class="text-slate-800 dark:text-white text-sm font-medium mb-2 block">Site Color</label>
<div class="flex items-center gap-3">
<input type="color" name="site_color" value="{{ $settings['site_color'] ?? '#19bc9c' }}" class="w-12 h-8 border border-slate-300 dark:border-[#324d67] rounded cursor-pointer">
<input type="text" name="site_color_text" value="{{ $settings['site_color'] ?? '#19bc9c' }}" class="flex-1 border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white" readonly>
</div>
</div>

<div>
<label class="text-slate-800 dark:text-white text-sm font-medium mb-2 block">Top Header and Block Heads Color</label>
<div class="flex items-center gap-3">
<input type="color" name="header_color" value="{{ $settings['header_color'] ?? '#161616' }}" class="w-12 h-8 border border-slate-300 dark:border-[#324d67] rounded cursor-pointer">
<input type="text" name="header_color_text" value="{{ $settings['header_color'] ?? '#161616' }}" class="flex-1 border border-slate-300 dark:border-[#324d67] rounded px-3 py-2 bg-white dark:bg-[#111a22] text-slate-800 dark:text-white" readonly>
</div>
</div>
</div>

<div class="mt-6 pt-6 border-t border-slate-200 dark:border-[#324d67]">
<button type="submit" class="flex items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-primary text-white text-sm font-bold leading-normal tracking-[0.015em]">
<span class="truncate">Save Changes</span>
</button>
</div>
</form>
</div>

<script>
// Dark mode toggle functionality
document.getElementById('darkModeToggle').addEventListener('change', function() {
    const isDarkMode = this.checked;

    // Update the toggle visual state immediately for better UX
    const toggleBg = this.parentElement.querySelector('.w-12');
    const toggleCircle = this.parentElement.querySelector('.w-5');

    if (isDarkMode) {
        toggleBg.classList.add('bg-green-500');
        toggleBg.classList.remove('bg-gray-300', 'dark:bg-gray-600');
        toggleCircle.classList.add('translate-x-6');
    } else {
        toggleBg.classList.remove('bg-green-500');
        toggleBg.classList.add('bg-gray-300', 'dark:bg-gray-600');
        toggleCircle.classList.remove('translate-x-6');
    }

    // Send AJAX request to update setting
    fetch('{{ route("admin.themes.dark-mode") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            dark_mode: isDarkMode
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            console.log('Dark mode setting updated successfully');
            // Show success message
            showNotification('Dark mode setting updated successfully', 'success');
        } else {
            throw new Error('Server returned error');
        }
    })
    .catch(error => {
        console.error('Error updating dark mode:', error);
        // Revert the toggle if there was an error
        this.checked = !isDarkMode;
        if (isDarkMode) {
            toggleBg.classList.remove('bg-green-500');
            toggleBg.classList.add('bg-gray-300', 'dark:bg-gray-600');
            toggleCircle.classList.remove('translate-x-6');
        } else {
            toggleBg.classList.add('bg-green-500');
            toggleBg.classList.remove('bg-gray-300', 'dark:bg-gray-600');
            toggleCircle.classList.add('translate-x-6');
        }
        showNotification('Failed to update dark mode setting', 'error');
    });
});

// Color picker synchronization
document.querySelectorAll('input[type="color"]').forEach(function(colorInput) {
    const textInput = colorInput.parentElement.nextElementSibling;

    colorInput.addEventListener('input', function() {
        textInput.value = this.value;
    });

    textInput.addEventListener('input', function() {
        if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) {
            colorInput.value = this.value;
        }
    });
});

// Theme activation feedback
document.querySelectorAll('form[action*="themes/activate"]').forEach(function(form) {
    form.addEventListener('submit', function(e) {
        const button = this.querySelector('button[type="submit"]');
        const originalText = button.textContent;
        button.textContent = 'Activating...';
        button.disabled = true;

        // Re-enable button after 2 seconds
        setTimeout(function() {
            button.textContent = originalText;
            button.disabled = false;
        }, 2000);
    });
});

// Notification function
function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg ${
        type === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
    }`;
    notification.textContent = message;

    document.body.appendChild(notification);

    setTimeout(function() {
        notification.remove();
    }, 3000);
}
</script>
@endsection
