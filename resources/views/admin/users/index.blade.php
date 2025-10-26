@extends('layouts.admin')

@section('title', 'Users Management')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Users Management</h1>
            <p class="text-gray-600 mt-1">Manage system users and their roles</p>
        </div>
        <div class="flex items-center space-x-3">
            <button onclick="refreshUsers()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center space-x-2">
                <span class="material-symbols-outlined text-sm">refresh</span>
                <span>Refresh</span>
            </button>
            <a href="{{ route('admin.users.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 flex items-center space-x-2">
                <span class="material-symbols-outlined text-sm">add</span>
                <span>Add User</span>
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Users</p>
                    <p class="text-2xl font-bold text-gray-900" id="total-users">{{ $users->total() }}</p>
                </div>
                <span class="material-symbols-outlined text-3xl text-blue-600">group</span>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Active Users</p>
                    <p class="text-2xl font-bold text-green-600" id="active-users">{{ $users->where('status', 'active')->count() }}</p>
                </div>
                <span class="material-symbols-outlined text-3xl text-green-600">check_circle</span>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Admin Users</p>
                    <p class="text-2xl font-bold text-purple-600" id="admin-users">{{ $users->filter(function($user) { return $user->hasRole('admin'); })->count() }}</p>
                </div>
                <span class="material-symbols-outlined text-3xl text-purple-600">admin_panel_settings</span>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">New Today</p>
                    <p class="text-2xl font-bold text-orange-600" id="new-today">{{ $users->where('created_at', '>=', today())->count() }}</p>
                </div>
                <span class="material-symbols-outlined text-3xl text-orange-600">trending_up</span>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">All Users</h3>
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <input type="text" id="search-users" placeholder="Search users..." class="w-64 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <span class="material-symbols-outlined absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">search</span>
                    </div>
                    <select id="filter-role" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Roles</option>
                        <option value="admin">Admin</option>
                        <option value="writer">Writer</option>
                        <option value="user">User</option>
                    </select>
                    <select id="filter-status" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <input type="checkbox" id="select-all" class="rounded border-gray-300">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posts</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody id="users-table-body" class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50" data-user-id="{{ $user->id }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" class="user-checkbox rounded border-gray-300" value="{{ $user->id }}">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" alt="{{ $user->name }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-wrap gap-1">
                                @foreach($user->roles as $role)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $role->name === 'admin' ? 'bg-purple-100 text-purple-800' : ($role->name === 'writer' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                    {{ ucfirst($role->name) }}
                                </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($user->status ?? 'inactive') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $user->posts_count ?? 0 }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.users.show', $user) }}" class="text-blue-600 hover:text-blue-900">
                                    <span class="material-symbols-outlined text-sm">visibility</span>
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-900">
                                    <span class="material-symbols-outlined text-sm">edit</span>
                                </a>
                                <button onclick="toggleUserStatus({{ $user->id }})" class="text-yellow-600 hover:text-yellow-900">
                                    <span class="material-symbols-outlined text-sm">{{ $user->status === 'active' ? 'pause' : 'play_arrow' }}</span>
                                </button>
                                @if($user->id !== Auth::id())
                                <button onclick="deleteUser({{ $user->id }})" class="text-red-600 hover:text-red-900">
                                    <span class="material-symbols-outlined text-sm">delete</span>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <span class="material-symbols-outlined text-4xl text-gray-300 mb-2">group</span>
                                <p class="text-lg font-medium">No users found</p>
                                <p class="text-sm">Get started by creating your first user.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
class UsersManager {
    constructor() {
        this.pusher = null;
        this.channels = {};
        this.init();
    }

    init() {
        this.setupPusher();
        this.setupEventListeners();
        this.startRealTimeUpdates();
    }

    setupPusher() {
        if (typeof Pusher !== 'undefined') {
            this.pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
                cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
                encrypted: false
            });

            this.channels.admin = this.pusher.subscribe('admin-dashboard');
            this.channels.users = this.pusher.subscribe('users');
            this.channels.userActivity = this.pusher.subscribe('user-activity');

            this.bindEvents();
        }
    }

    bindEvents() {
        // User events
        this.channels.users.bind('user.created', (data) => {
            this.addUserToTable(data.user);
            this.updateStats();
            this.showNotification(`New user created: ${data.user.name}`, 'success');
        });

        this.channels.users.bind('user.updated', (data) => {
            this.updateUserInTable(data.user);
            this.updateStats();
            this.showNotification(`User updated: ${data.user.name}`, 'info');
        });

        this.channels.users.bind('user.deleted', (data) => {
            this.removeUserFromTable(data.user_id);
            this.updateStats();
            this.showNotification(`User deleted: ${data.user_name}`, 'warning');
        });

        // User activity events
        this.channels.userActivity.bind('user.activity', (data) => {
            this.showNotification(`User activity: ${data.action}`, 'info');
        });
    }

    setupEventListeners() {
        // Search functionality
        document.getElementById('search-users').addEventListener('input', (e) => {
            this.filterUsers();
        });

        // Filter functionality
        document.getElementById('filter-role').addEventListener('change', (e) => {
            this.filterUsers();
        });

        document.getElementById('filter-status').addEventListener('change', (e) => {
            this.filterUsers();
        });

        // Select all functionality
        document.getElementById('select-all').addEventListener('change', (e) => {
            const checkboxes = document.querySelectorAll('.user-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = e.target.checked;
            });
        });
    }

    startRealTimeUpdates() {
        // Update stats every 30 seconds
        setInterval(() => this.updateStats(), 30000);
    }

    async updateStats() {
        try {
            const response = await fetch('/admin/users/stats');
            const data = await response.json();

            this.updateElement('total-users', data.total_users || 0);
            this.updateElement('active-users', data.active_users || 0);
            this.updateElement('admin-users', data.admin_users || 0);
            this.updateElement('new-today', data.new_users_today || 0);
        } catch (error) {
            console.error('Error updating user stats:', error);
        }
    }

    filterUsers() {
        const searchTerm = document.getElementById('search-users').value.toLowerCase();
        const roleFilter = document.getElementById('filter-role').value;
        const statusFilter = document.getElementById('filter-status').value;

        const rows = document.querySelectorAll('#users-table-body tr');

        rows.forEach(row => {
            const name = row.querySelector('td:nth-child(2) .text-sm.font-medium')?.textContent.toLowerCase() || '';
            const email = row.querySelector('td:nth-child(2) .text-sm.text-gray-500')?.textContent.toLowerCase() || '';
            const roles = row.querySelector('td:nth-child(3)')?.textContent.toLowerCase() || '';
            const status = row.querySelector('td:nth-child(4)')?.textContent.toLowerCase() || '';

            const matchesSearch = name.includes(searchTerm) || email.includes(searchTerm);
            const matchesRole = !roleFilter || roles.includes(roleFilter);
            const matchesStatus = !statusFilter || status.includes(statusFilter);

            row.style.display = (matchesSearch && matchesRole && matchesStatus) ? '' : 'none';
        });
    }

    addUserToTable(user) {
        const tbody = document.getElementById('users-table-body');
        const row = document.createElement('tr');
        row.className = 'hover:bg-gray-50';
        row.setAttribute('data-user-id', user.id);
        row.innerHTML = this.createUserRowHTML(user);
        tbody.insertBefore(row, tbody.firstChild);
    }

    updateUserInTable(user) {
        const row = document.querySelector(`tr[data-user-id="${user.id}"]`);
        if (row) {
            row.innerHTML = this.createUserRowHTML(user);
        }
    }

    removeUserFromTable(userId) {
        const row = document.querySelector(`tr[data-user-id="${userId}"]`);
        if (row) {
            row.remove();
        }
    }

    createUserRowHTML(user) {
        return `
            <td class="px-6 py-4 whitespace-nowrap">
                <input type="checkbox" class="user-checkbox rounded border-gray-300" value="${user.id}">
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10">
                        <img class="h-10 w-10 rounded-full" src="https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}&background=random" alt="${user.name}">
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">${user.name}</div>
                        <div class="text-sm text-gray-500">${user.email}</div>
                    </div>
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex flex-wrap gap-1">
                    ${user.roles ? user.roles.map(role => `
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${role.name === 'admin' ? 'bg-purple-100 text-purple-800' : (role.name === 'writer' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800')}">
                            ${role.name.charAt(0).toUpperCase() + role.name.slice(1)}
                        </span>
                    `).join('') : ''}
                </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${user.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                    ${user.status ? user.status.charAt(0).toUpperCase() + user.status.slice(1) : 'Inactive'}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                ${user.posts_count || 0}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                ${new Date(user.created_at).toLocaleDateString()}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <div class="flex items-center space-x-2">
                    <a href="/admin/users/${user.id}" class="text-blue-600 hover:text-blue-900">
                        <span class="material-symbols-outlined text-sm">visibility</span>
                    </a>
                    <a href="/admin/users/${user.id}/edit" class="text-indigo-600 hover:text-indigo-900">
                        <span class="material-symbols-outlined text-sm">edit</span>
                    </a>
                    <button onclick="toggleUserStatus(${user.id})" class="text-yellow-600 hover:text-yellow-900">
                        <span class="material-symbols-outlined text-sm">${user.status === 'active' ? 'pause' : 'play_arrow'}</span>
                    </button>
                    <button onclick="deleteUser(${user.id})" class="text-red-600 hover:text-red-900">
                        <span class="material-symbols-outlined text-sm">delete</span>
                    </button>
                </div>
            </td>
        `;
    }

    updateElement(id, value) {
        const element = document.getElementById(id);
        if (element) {
            element.textContent = value;
        }
    }

    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${this.getNotificationClass(type)}`;
        notification.innerHTML = `
            <div class="flex items-center space-x-2">
                <span class="material-symbols-outlined">${this.getNotificationIcon(type)}</span>
                <span>${message}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-gray-500 hover:text-gray-700">
                    <span class="material-symbols-outlined text-sm">close</span>
                </button>
            </div>
        `;

        document.body.appendChild(notification);

        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 5000);
    }

    getNotificationClass(type) {
        const classes = {
            'success': 'bg-green-100 text-green-800 border border-green-200',
            'info': 'bg-blue-100 text-blue-800 border border-blue-200',
            'warning': 'bg-yellow-100 text-yellow-800 border border-yellow-200',
            'error': 'bg-red-100 text-red-800 border border-red-200'
        };
        return classes[type] || classes['info'];
    }

    getNotificationIcon(type) {
        const icons = {
            'success': 'check_circle',
            'info': 'info',
            'warning': 'warning',
            'error': 'error'
        };
        return icons[type] || icons['info'];
    }
}

// Initialize users manager when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.usersManager = new UsersManager();
});

// Global functions
async function refreshUsers() {
    location.reload();
}

async function toggleUserStatus(userId) {
    try {
        const response = await fetch(`/admin/users/${userId}/toggle-status`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        });

        const result = await response.json();
        if (result.status === 'success') {
            window.usersManager.showNotification(result.message, 'success');
            // Update the status in the table
            const row = document.querySelector(`tr[data-user-id="${userId}"]`);
            if (row) {
                const statusCell = row.querySelector('td:nth-child(4) span');
                if (statusCell) {
                    statusCell.textContent = result.new_status.charAt(0).toUpperCase() + result.new_status.slice(1);
                    statusCell.className = `inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${result.new_status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}`;
                }
            }
        }
    } catch (error) {
        console.error('Error toggling user status:', error);
        window.usersManager.showNotification('Error updating user status', 'error');
    }
}

async function deleteUser(userId) {
    if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
        try {
            const response = await fetch(`/admin/users/${userId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            });

            if (response.ok) {
                window.usersManager.showNotification('User deleted successfully', 'success');
                window.usersManager.removeUserFromTable(userId);
            }
        } catch (error) {
            console.error('Error deleting user:', error);
            window.usersManager.showNotification('Error deleting user', 'error');
        }
    }
}
</script>
@endsection
