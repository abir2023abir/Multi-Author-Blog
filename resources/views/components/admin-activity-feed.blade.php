<!-- Real-time Activity Feed -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900">Live Activity Feed</h3>
        <div class="flex items-center space-x-2">
            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse" id="activity-indicator"></div>
            <span class="text-sm text-gray-500">Live</span>
        </div>
    </div>
    
    <div class="space-y-3 max-h-96 overflow-y-auto" id="activity-feed">
        <!-- Activity items will be populated here -->
        <div class="text-center text-gray-500 py-4" id="no-activity">
            <span class="material-symbols-outlined text-4xl text-gray-300">timeline</span>
            <p class="mt-2">No recent activity</p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const activityFeed = document.getElementById('activity-feed');
    const noActivity = document.getElementById('no-activity');
    const indicator = document.getElementById('activity-indicator');
    
    // Real-time activity updates
    if (typeof Pusher !== 'undefined') {
        const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
            cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}'
        });

        const channel = pusher.subscribe('admin-dashboard');
        
        // Listen for various activity events
        channel.bind('new-post', function(data) {
            addActivityItem('article', 'New post created', data.title, 'success');
        });
        
        channel.bind('new-comment', function(data) {
            addActivityItem('comment', 'New comment', data.post_title, 'info');
        });
        
        channel.bind('user-activity', function(data) {
            addActivityItem('person', data.action, data.details, 'warning');
        });
        
        channel.bind('stats-updated', function(data) {
            addActivityItem('refresh', 'Dashboard updated', 'Statistics refreshed', 'info');
        });
    }
    
    function addActivityItem(icon, action, details, type) {
        // Hide no activity message
        if (noActivity) {
            noActivity.style.display = 'none';
        }
        
        // Create activity item
        const activityItem = document.createElement('div');
        activityItem.className = 'flex items-start space-x-3 p-3 bg-gray-50 rounded-lg border-l-4 ' + getBorderColor(type);
        
        const now = new Date();
        const timeString = now.toLocaleTimeString();
        
        activityItem.innerHTML = `
            <span class="material-symbols-outlined text-lg ${getIconColor(type)}">${icon}</span>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900">${action}</p>
                <p class="text-sm text-gray-600 truncate">${details}</p>
                <p class="text-xs text-gray-500 mt-1">${timeString}</p>
            </div>
        `;
        
        // Add to top of feed
        activityFeed.insertBefore(activityItem, activityFeed.firstChild);
        
        // Limit to 10 items
        const items = activityFeed.querySelectorAll('.flex.items-start.space-x-3');
        if (items.length > 10) {
            items[items.length - 1].remove();
        }
        
        // Animate indicator
        indicator.classList.add('animate-pulse');
        setTimeout(() => {
            indicator.classList.remove('animate-pulse');
        }, 2000);
    }
    
    function getBorderColor(type) {
        const colors = {
            'success': 'border-green-500',
            'info': 'border-blue-500',
            'warning': 'border-yellow-500',
            'error': 'border-red-500'
        };
        return colors[type] || colors['info'];
    }
    
    function getIconColor(type) {
        const colors = {
            'success': 'text-green-600',
            'info': 'text-blue-600',
            'warning': 'text-yellow-600',
            'error': 'text-red-600'
        };
        return colors[type] || colors['info'];
    }
});
</script>
