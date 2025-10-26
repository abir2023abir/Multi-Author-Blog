<!-- Navigation Bar -->
<nav class="bg-white shadow-sm border-b border-gray-200" style="background-color: white !important;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Left Side - Logo -->
            <div class="flex items-center">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="flex items-center space-x-1">
                        <div class="w-6 h-6 bg-blue-600 rounded-sm flex items-center justify-center">
                            <div class="w-3 h-3 bg-white rounded-sm"></div>
                        </div>
                        <div class="w-6 h-6 bg-blue-600 rounded-sm flex items-center justify-center">
                            <div class="w-3 h-3 bg-white rounded-sm"></div>
                        </div>
                    </div>
                    <a href="{{ route('home') }}" class="text-xl font-bold text-black" style="color: black !important;">Multi Author Blog Web</a>
                </div>
            </div>

            <!-- Center - Navigation Links -->
            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ route('home') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('home') ? 'bg-blue-100 text-blue-600' : 'hover:bg-gray-50' }} font-medium text-sm flex items-center space-x-1" style="color: {{ request()->routeIs('home') ? '#2563eb' : 'black' }} !important;">
                    <span class="material-symbols-outlined text-sm">home</span>
                    <span>Home</span>
                </a>
                <a href="#" class="px-3 py-2 rounded-lg text-black hover:bg-gray-50 font-medium text-sm" style="color: black !important;">Travel</a>
                <a href="#" class="px-3 py-2 rounded-lg text-black hover:bg-gray-50 font-medium text-sm" style="color: black !important;">Destination</a>
                <a href="#" class="px-3 py-2 rounded-lg text-black hover:bg-gray-50 font-medium text-sm" style="color: black !important;">Hotels</a>
                <a href="#" class="px-3 py-2 rounded-lg text-black hover:bg-gray-50 font-medium text-sm" style="color: black !important;">Lifestyle</a>
                <a href="#" class="px-3 py-2 rounded-lg text-black hover:bg-gray-50 font-medium text-sm" style="color: black !important;">Blog</a>
                <a href="#" class="px-3 py-2 rounded-lg text-black hover:bg-gray-50 font-medium text-sm" style="color: black !important;">Galleries</a>
                <a href="#" class="px-3 py-2 rounded-lg text-black hover:bg-gray-50 font-medium text-sm" style="color: black !important;">Contact</a>
            </div>

            <!-- Right Side - Auth Buttons -->
            <div class="flex items-center space-x-4">
                @auth
                    <!-- Authenticated User Menu -->
                    <div class="flex items-center space-x-4">
                        <a href="{{
                            auth()->user()->hasRole('admin') ? route('admin.dashboard') :
                            (auth()->user()->hasRole('writer') ? route('writer.dashboard') : route('user.dashboard'))
                        }}" class="px-4 py-2 text-black hover:bg-gray-50 rounded-lg font-medium text-sm" style="color: black !important;">
                            Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white hover:bg-red-700 rounded-lg font-medium text-sm">
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    <!-- Guest User Menu -->
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 text-white font-bold rounded-lg text-sm hover:bg-blue-700 transition-colors" style="background-color: #2563eb !important; color: white !important; font-weight: bold !important;">Login</a>
                    </div>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button type="button" class="text-black hover:text-gray-600 focus:outline-none focus:text-gray-600" style="color: black !important;" onclick="toggleMobileMenu()">
                    <span class="material-symbols-outlined">menu</span>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="mobile-menu" class="md:hidden hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white border-t border-gray-200">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium text-black hover:bg-gray-50 flex items-center space-x-2" style="color: black !important;">
                    <span class="material-symbols-outlined text-sm">home</span>
                    <span>Home</span>
                </a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-black hover:bg-gray-50" style="color: black !important;">Travel</a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-black hover:bg-gray-50" style="color: black !important;">Destination</a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-black hover:bg-gray-50" style="color: black !important;">Hotels</a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-black hover:bg-gray-50" style="color: black !important;">Lifestyle</a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-black hover:bg-gray-50" style="color: black !important;">Blog</a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-black hover:bg-gray-50" style="color: black !important;">Galleries</a>
                <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-black hover:bg-gray-50" style="color: black !important;">Contact</a>

                <div class="border-t border-gray-200 pt-4 mt-4">
                    @auth
                        <a href="{{
                            auth()->user()->hasRole('admin') ? route('admin.dashboard') :
                            (auth()->user()->hasRole('writer') ? route('writer.dashboard') : route('user.dashboard'))
                        }}" class="block px-3 py-2 rounded-md text-base font-medium text-black hover:bg-gray-50" style="color: black !important;">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-red-600 hover:bg-gray-50">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-bold bg-blue-600 text-white hover:bg-blue-700 transition-colors" style="background-color: #2563eb !important; color: white !important; font-weight: bold !important;">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
function toggleMobileMenu() {
    const mobileMenu = document.getElementById('mobile-menu');
    if (mobileMenu.classList.contains('hidden')) {
        mobileMenu.classList.remove('hidden');
    } else {
        mobileMenu.classList.add('hidden');
    }
}
</script>
