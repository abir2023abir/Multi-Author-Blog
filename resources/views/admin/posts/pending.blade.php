<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            Pending Posts
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                @foreach ($pendingPosts as $post)
                    <div class="border-b border-gray-200 dark:border-gray-700 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold">{{ $post->title }}</h3>
                                <p class="text-sm text-gray-500">By {{ $post->user->name }} @if($post->category) in {{ $post->category->name }} @endif</p>
                            </div>
                            <div class="flex gap-3">
                                <form method="POST" action="{{ route('admin.posts.approve', $post) }}">
                                    @csrf
                                    <button class="px-3 py-1 bg-green-600 text-white rounded">Approve</button>
                                </form>
                                <form method="POST" action="{{ route('admin.posts.reject', $post) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1 bg-red-600 text-white rounded">Reject</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="mt-4">{{ $pendingPosts->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>


