@extends('layouts.admin')

@section('title', 'Create New Post')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Create New Post</h1>
                    <p class="text-gray-600">Create a new {{ ucfirst($type) }} post</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('admin.posts.add') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 flex items-center space-x-2">
                        <span class="material-symbols-outlined text-sm">arrow_back</span>
                        <span>Back to Formats</span>
                    </a>
                    <a href="{{ route('admin.posts.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center space-x-2">
                        <span class="material-symbols-outlined text-sm">list</span>
                        <span>All Posts</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Language Banner -->
    <div class="bg-blue-100 border-l-4 border-blue-500 p-4">
        <div class="flex items-center">
            <span class="material-symbols-outlined text-blue-600 mr-2">info</span>
            <span class="text-blue-800">You are editing "English" version</span>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" value="{{ $type }}">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-lg shadow p-6">
                        <!-- Name -->
                        <div class="mb-6">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                            <input type="text"
                                   id="title"
                                   name="title"
                                   value="{{ old('title') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror"
                                   placeholder="Name"
                                   required>
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Permalink -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Permalink</label>
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-500">https://stories.botble.com/</span>
                                <a href="#" class="text-blue-600 hover:text-blue-800 text-sm">Preview:</a>
                                <span class="text-sm text-gray-500 permalink-display">https://stories.botble.com/</span>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea id="excerpt"
                                      name="excerpt"
                                      rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('excerpt') border-red-500 @enderror"
                                      placeholder="Short description">{{ old('excerpt') }}</textarea>
                            @error('excerpt')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Is Featured -->
                        <div class="mb-6">
                            <label class="flex items-center space-x-3">
                                <input type="checkbox" name="is_featured" value="1" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="text-sm font-medium text-gray-700">Is featured?</span>
                            </label>
                        </div>

                        <!-- Content -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Content</label>
                            <div class="flex space-x-2 mb-3">
                                <button type="button" id="toggle-editor" class="px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded hover:bg-gray-200">
                                    Show/Hide Editor
                                </button>
                                <button type="button" id="add-media" class="px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded hover:bg-gray-200 flex items-center space-x-1">
                                    <span class="material-symbols-outlined text-sm">image</span>
                                    <span>Add media</span>
                                </button>
                                <button type="button" id="ui-blocks" class="px-3 py-1 text-sm bg-gray-100 text-gray-700 rounded hover:bg-gray-200 flex items-center space-x-1" onclick="toggleUIBlocks()">
                                    <span class="material-symbols-outlined text-sm">extension</span>
                                    <span>UI Blocks</span>
                                </button>
                                <button type="button" id="preview-content" class="px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded hover:bg-blue-200 flex items-center space-x-1">
                                    <span class="material-symbols-outlined text-sm">visibility</span>
                                    <span>Preview</span>
                                </button>
                            </div>

                            <!-- Rich Text Editor -->
                            <div id="editor-container" class="border border-gray-300 rounded-lg">
                                <div id="editor-toolbar" class="border-b border-gray-300 p-2 bg-gray-50 flex flex-wrap gap-1">
                                    <button type="button" class="editor-btn px-2 py-1 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100" data-command="bold">
                                        <span class="font-bold">B</span>
                                    </button>
                                    <button type="button" class="editor-btn px-2 py-1 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100" data-command="italic">
                                        <span class="italic">I</span>
                                    </button>
                                    <button type="button" class="editor-btn px-2 py-1 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100" data-command="underline">
                                        <span class="underline">U</span>
                                    </button>
                                    <div class="w-px h-6 bg-gray-300 mx-1"></div>
                                    <button type="button" class="editor-btn px-2 py-1 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100" data-command="insertUnorderedList">
                                        <span class="material-symbols-outlined text-sm">format_list_bulleted</span>
                                    </button>
                                    <button type="button" class="editor-btn px-2 py-1 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100" data-command="insertOrderedList">
                                        <span class="material-symbols-outlined text-sm">format_list_numbered</span>
                                    </button>
                                    <div class="w-px h-6 bg-gray-300 mx-1"></div>
                                    <button type="button" class="editor-btn px-2 py-1 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100" data-command="justifyLeft">
                                        <span class="material-symbols-outlined text-sm">format_align_left</span>
                                    </button>
                                    <button type="button" class="editor-btn px-2 py-1 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100" data-command="justifyCenter">
                                        <span class="material-symbols-outlined text-sm">format_align_center</span>
                                    </button>
                                    <button type="button" class="editor-btn px-2 py-1 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100" data-command="justifyRight">
                                        <span class="material-symbols-outlined text-sm">format_align_right</span>
                                    </button>
                                    <div class="w-px h-6 bg-gray-300 mx-1"></div>
                                    <button type="button" class="editor-btn px-2 py-1 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100" data-command="createLink">
                                        <span class="material-symbols-outlined text-sm">link</span>
                                    </button>
                                    <button type="button" class="editor-btn px-2 py-1 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100" data-command="insertImage">
                                        <span class="material-symbols-outlined text-sm">image</span>
                                    </button>
                                    <button type="button" class="editor-btn px-2 py-1 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100" data-command="insertTable">
                                        <span class="material-symbols-outlined text-sm">table_chart</span>
                                    </button>
                                </div>
                                <div id="editor-content"
                                     contenteditable="true"
                                     class="min-h-64 p-4 focus:outline-none"
                                     data-placeholder="Write your content here..."
                                     style="min-height: 300px;">{{ old('content') }}</div>
                            </div>

                            <!-- Hidden textarea for form submission -->
                            <textarea id="content"
                                      name="content"
                                      class="hidden"
                                      required>{{ old('content') }}</textarea>

                            <!-- Character count and word count -->
                            <div class="flex justify-between items-center mt-2 text-sm text-gray-500">
                                <span id="word-count">Words: 0</span>
                                <span id="char-count">Characters: 0</span>
                                <span id="reading-time">Reading time: 0 min</span>
                            </div>

                            @error('content')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- UI Blocks Panel -->
                        <div id="ui-blocks-panel" class="mb-6 hidden">
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">UI Blocks</h3>
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                                    <!-- Text Blocks -->
                                    <button type="button" class="ui-block-btn p-3 bg-white border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-colors" data-block="heading">
                                        <div class="text-center">
                                            <span class="material-symbols-outlined text-2xl text-gray-600 mb-2">title</span>
                                            <div class="text-sm font-medium text-gray-700">Heading</div>
                                        </div>
                                    </button>

                                    <button type="button" class="ui-block-btn p-3 bg-white border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-colors" data-block="paragraph">
                                        <div class="text-center">
                                            <span class="material-symbols-outlined text-2xl text-gray-600 mb-2">text_fields</span>
                                            <div class="text-sm font-medium text-gray-700">Paragraph</div>
                                        </div>
                                    </button>

                                    <button type="button" class="ui-block-btn p-3 bg-white border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-colors" data-block="quote">
                                        <div class="text-center">
                                            <span class="material-symbols-outlined text-2xl text-gray-600 mb-2">format_quote</span>
                                            <div class="text-sm font-medium text-gray-700">Quote</div>
                                        </div>
                                    </button>

                                    <button type="button" class="ui-block-btn p-3 bg-white border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-colors" data-block="code">
                                        <div class="text-center">
                                            <span class="material-symbols-outlined text-2xl text-gray-600 mb-2">code</span>
                                            <div class="text-sm font-medium text-gray-700">Code Block</div>
                                        </div>
                                    </button>

                                    <!-- Layout Blocks -->
                                    <button type="button" class="ui-block-btn p-3 bg-white border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-colors" data-block="columns">
                                        <div class="text-center">
                                            <span class="material-symbols-outlined text-2xl text-gray-600 mb-2">view_column</span>
                                            <div class="text-sm font-medium text-gray-700">Columns</div>
                                        </div>
                                    </button>

                                    <button type="button" class="ui-block-btn p-3 bg-white border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-colors" data-block="divider">
                                        <div class="text-center">
                                            <span class="material-symbols-outlined text-2xl text-gray-600 mb-2">horizontal_rule</span>
                                            <div class="text-sm font-medium text-gray-700">Divider</div>
                                        </div>
                                    </button>

                                    <button type="button" class="ui-block-btn p-3 bg-white border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-colors" data-block="spacer">
                                        <div class="text-center">
                                            <span class="material-symbols-outlined text-2xl text-gray-600 mb-2">space_bar</span>
                                            <div class="text-sm font-medium text-gray-700">Spacer</div>
                                        </div>
                                    </button>

                                    <!-- Media Blocks -->
                                    <button type="button" class="ui-block-btn p-3 bg-white border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-colors" data-block="image">
                                        <div class="text-center">
                                            <span class="material-symbols-outlined text-2xl text-gray-600 mb-2">image</span>
                                            <div class="text-sm font-medium text-gray-700">Image</div>
                                        </div>
                                    </button>

                                    <button type="button" class="ui-block-btn p-3 bg-white border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-colors" data-block="gallery">
                                        <div class="text-center">
                                            <span class="material-symbols-outlined text-2xl text-gray-600 mb-2">photo_library</span>
                                            <div class="text-sm font-medium text-gray-700">Gallery</div>
                                        </div>
                                    </button>

                                    <button type="button" class="ui-block-btn p-3 bg-white border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-colors" data-block="video">
                                        <div class="text-center">
                                            <span class="material-symbols-outlined text-2xl text-gray-600 mb-2">play_circle</span>
                                            <div class="text-sm font-medium text-gray-700">Video</div>
                                        </div>
                                    </button>

                                    <!-- Interactive Blocks -->
                                    <button type="button" class="ui-block-btn p-3 bg-white border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-colors" data-block="button">
                                        <div class="text-center">
                                            <span class="material-symbols-outlined text-2xl text-gray-600 mb-2">smart_button</span>
                                            <div class="text-sm font-medium text-gray-700">Button</div>
                                        </div>
                                    </button>

                                    <button type="button" class="ui-block-btn p-3 bg-white border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-colors" data-block="accordion">
                                        <div class="text-center">
                                            <span class="material-symbols-outlined text-2xl text-gray-600 mb-2">expand_more</span>
                                            <div class="text-sm font-medium text-gray-700">Accordion</div>
                                        </div>
                                    </button>

                                    <button type="button" class="ui-block-btn p-3 bg-white border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-colors" data-block="tabs">
                                        <div class="text-center">
                                            <span class="material-symbols-outlined text-2xl text-gray-600 mb-2">tab</span>
                                            <div class="text-sm font-medium text-gray-700">Tabs</div>
                                        </div>
                                    </button>

                                    <!-- Data Blocks -->
                                    <button type="button" class="ui-block-btn p-3 bg-white border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-colors" data-block="table">
                                        <div class="text-center">
                                            <span class="material-symbols-outlined text-2xl text-gray-600 mb-2">table_chart</span>
                                            <div class="text-sm font-medium text-gray-700">Table</div>
                                        </div>
                                    </button>

                                    <button type="button" class="ui-block-btn p-3 bg-white border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-colors" data-block="list">
                                        <div class="text-center">
                                            <span class="material-symbols-outlined text-2xl text-gray-600 mb-2">format_list_bulleted</span>
                                            <div class="text-sm font-medium text-gray-700">List</div>
                                        </div>
                                    </button>

                                    <button type="button" class="ui-block-btn p-3 bg-white border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-colors" data-block="timeline">
                                        <div class="text-center">
                                            <span class="material-symbols-outlined text-2xl text-gray-600 mb-2">timeline</span>
                                            <div class="text-sm font-medium text-gray-700">Timeline</div>
                                        </div>
                                    </button>

                                    <button type="button" class="ui-block-btn p-3 bg-white border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 transition-colors" data-block="progress">
                                        <div class="text-center">
                                            <span class="material-symbols-outlined text-2xl text-gray-600 mb-2">trending_up</span>
                                            <div class="text-sm font-medium text-gray-700">Progress</div>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>

                            <!-- Gallery Images -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Gallery images</label>
                                <div class="space-y-3">
                                    <input type="file"
                                           id="gallery-images"
                                           name="gallery_images[]"
                                           multiple
                                           accept="image/*"
                                           class="hidden"
                                           onchange="handleGalleryImages(this)">
                                    <button type="button"
                                            onclick="openImageSelector(handleGallerySelection)"
                                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center space-x-2">
                                        <span class="material-symbols-outlined text-sm">add_photo_alternate</span>
                                        <span>Select images</span>
                                    </button>
                                    <div id="gallery-preview" class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                                        <!-- Gallery images will be previewed here -->
                                    </div>
                                </div>
                            </div>

                        <!-- SEO Section -->
                        <div class="mb-6">
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-sm font-medium text-gray-700">Search Engine Optimize</label>
                                <a href="#" class="text-blue-600 hover:text-blue-800 text-sm">Edit SEO meta</a>
                            </div>
                            <p class="text-sm text-gray-500 mb-3">Setup meta title & description to make your site easy to discovered on search engines such as Google</p>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Publishing Options -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Publish -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Publish</h3>
                        <div class="space-y-4">
                            <div class="flex space-x-2">
                                <button type="submit" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center justify-center space-x-2">
                                    <span class="material-symbols-outlined text-sm">save</span>
                                    <span>Save</span>
                                </button>
                                <button type="button" class="flex-1 bg-white text-gray-700 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 flex items-center justify-center space-x-2">
                                    <span class="material-symbols-outlined text-sm">save</span>
                                    <span>Save & Exit</span>
                                </button>
                            </div>
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <select id="status"
                                        name="status"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror">
                                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Categories</h3>
                        <div class="border-t border-gray-200 mb-4"></div>

                        <!-- Search Bar -->
                        <div class="relative mb-4">
                            <input type="text"
                                   id="category-search"
                                   placeholder="Search..."
                                   class="w-full px-3 py-2 pl-10 pr-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm">search</span>
                        </div>

                        <!-- Categories List -->
                        <div class="space-y-1 max-h-64 overflow-y-auto">
                            <!-- Uncategorized (Always checked) -->
                            <label class="flex items-center space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                                <input type="checkbox"
                                       name="categories[]"
                                       value="uncategorized"
                                       checked
                                       class="w-4 h-4 text-blue-600 bg-blue-600 border-blue-600 rounded focus:ring-blue-500 focus:ring-2">
                                <span class="text-sm text-gray-700 font-medium">Uncategorized</span>
                            </label>

                            <!-- Travel -->
                            <label class="flex items-center space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                                <input type="checkbox" name="categories[]" value="travel" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                <span class="text-sm text-gray-700 font-medium">Travel</span>
                            </label>

                            <!-- Food -->
                            <label class="flex items-center space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                                <input type="checkbox" name="categories[]" value="food" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                <span class="text-sm text-gray-700 font-medium">Food</span>
                            </label>

                            <!-- Hotels -->
                            <label class="flex items-center space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                                <input type="checkbox" name="categories[]" value="hotels" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                <span class="text-sm text-gray-700 font-medium">Hotels</span>
                            </label>

                            <!-- Review -->
                            <label class="flex items-center space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                                <input type="checkbox" name="categories[]" value="review" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                <span class="text-sm text-gray-700 font-medium">Review</span>
                            </label>

                            <!-- Healthy -->
                            <label class="flex items-center space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                                <input type="checkbox" name="categories[]" value="healthy" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                <span class="text-sm text-gray-700 font-medium">Healthy</span>
                            </label>

                            <!-- Lifestyle -->
                            <label class="flex items-center space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded">
                                <input type="checkbox" name="categories[]" value="lifestyle" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                <span class="text-sm text-gray-700 font-medium">Lifestyle</span>
                            </label>
                        </div>
                    </div>

                        <!-- Image -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Image</h3>
                            <div class="space-y-3">
                                <div id="featured-image-preview" class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
                                    <span class="material-symbols-outlined text-gray-400 text-4xl">landscape</span>
                                    <p class="text-sm text-gray-500 mt-2">Featured Image</p>
                                </div>
                                <div class="space-y-2">
                                    <input type="file"
                                           id="featured-image"
                                           name="featured_image"
                                           accept="image/*"
                                           class="hidden"
                                           onchange="handleFeaturedImage(this)">
                                    <button type="button"
                                            onclick="openImageSelector(handleFeaturedImageSelection)"
                                            class="w-full px-3 py-2 text-sm bg-gray-100 text-gray-700 rounded hover:bg-gray-200 flex items-center justify-center space-x-2">
                                        <span class="material-symbols-outlined text-sm">add_photo_alternate</span>
                                        <span>Choose image</span>
                                    </button>
                                    <button type="button"
                                            onclick="openImageSelector(handleFeaturedImageSelection)"
                                            class="w-full px-3 py-2 text-sm bg-gray-100 text-gray-700 rounded hover:bg-gray-200 flex items-center justify-center space-x-2">
                                        <span class="material-symbols-outlined text-sm">link</span>
                                        <span>Add from URL</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                    <!-- Tags -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Tags</h3>
                        <input type="text"
                               name="tags"
                               placeholder="Write some tags"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <!-- Time to read -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Time to read (minute)</h3>
                        <input type="number"
                               name="reading_time"
                               placeholder="5"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <!-- Layout -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Layout</h3>
                        <select name="layout" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="inherit">Inherit</option>
                            <option value="full-width">Full Width</option>
                            <option value="sidebar">With Sidebar</option>
                        </select>
                    </div>

                    <!-- Allow comments -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <label class="flex items-center space-x-3">
                            <input type="checkbox" name="allow_comments" value="1" checked class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <span class="text-sm font-medium text-gray-700">Allow comments</span>
                        </label>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
// Real-time auto-save functionality
let autoSaveTimeout;
let isDirty = false;

// Initialize the rich text editor
document.addEventListener('DOMContentLoaded', function() {
    initializeRichTextEditor();
    initializeAutoSave();
    initializeRealTimeFeatures();
});

function initializeRichTextEditor() {
    const editorContent = document.getElementById('editor-content');
    const contentTextarea = document.getElementById('content');
    const wordCount = document.getElementById('word-count');
    const charCount = document.getElementById('char-count');
    const readingTime = document.getElementById('reading-time');

    // Set placeholder
    if (!editorContent.textContent.trim()) {
        editorContent.textContent = editorContent.dataset.placeholder;
        editorContent.classList.add('text-gray-400');
    }

    // Handle focus
    editorContent.addEventListener('focus', function() {
        if (this.classList.contains('text-gray-400')) {
            this.textContent = '';
            this.classList.remove('text-gray-400');
        }
    });

    // Handle blur
    editorContent.addEventListener('blur', function() {
        if (!this.textContent.trim()) {
            this.textContent = this.dataset.placeholder;
            this.classList.add('text-gray-400');
        }
    });

    // Real-time content updates
    editorContent.addEventListener('input', function() {
        if (this.classList.contains('text-gray-400')) {
            this.textContent = '';
            this.classList.remove('text-gray-400');
        }

        // Update hidden textarea
        contentTextarea.value = this.innerHTML;

        // Update counts
        updateCounts();

        // Mark as dirty for auto-save
        isDirty = true;
    });

    // Toolbar button handlers
    document.querySelectorAll('.editor-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const command = this.dataset.command;
            executeCommand(command);
        });
    });

    function executeCommand(command) {
        document.execCommand(command, false, null);
        editorContent.focus();
        updateCounts();
        isDirty = true;
    }

    function updateCounts() {
        const text = editorContent.textContent || '';
        const words = text.trim().split(/\s+/).filter(word => word.length > 0).length;
        const chars = text.length;
        const readingTimeMin = Math.max(1, Math.ceil(words / 200));

        wordCount.textContent = 'Words: ' + words;
        charCount.textContent = 'Characters: ' + chars;
        readingTime.textContent = 'Reading time: ' + readingTimeMin + ' min';

        // Update reading time input
        const readingTimeInput = document.querySelector('input[name="reading_time"]');
        if (readingTimeInput) {
            readingTimeInput.value = readingTimeMin;
        }
    }
}

function initializeAutoSave() {
    // Auto-save every 30 seconds
    setInterval(() => {
        if (isDirty) {
            autoSave();
        }
    }, 30000);

    // Auto-save on form changes
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('input, textarea, select');

    inputs.forEach(input => {
        input.addEventListener('change', () => {
            isDirty = true;
            autoSave();
        });
    });
}

function autoSave() {
    if (!isDirty) return;

    const formData = new FormData();
    const form = document.querySelector('form');

    // Collect form data
    const inputs = form.querySelectorAll('input, textarea, select');
    inputs.forEach(input => {
        if (input.type === 'checkbox') {
            if (input.checked) {
                formData.append(input.name, input.value);
            }
        } else if (input.type === 'file') {
            // Skip file inputs for auto-save
        } else {
            formData.append(input.name, input.value);
        }
    });

    // Add auto-save flag
    formData.append('auto_save', '1');

    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Auto-saved successfully', 'success');
            isDirty = false;
        }
    })
    .catch(error => {
        console.error('Auto-save failed:', error);
    });
}

function initializeRealTimeFeatures() {
    // Real-time title slug generation
    const titleInput = document.getElementById('title');
    const permalinkDisplay = document.querySelector('.permalink-display');

    if (titleInput && permalinkDisplay) {
        titleInput.addEventListener('input', function() {
            const slug = this.value.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');

            permalinkDisplay.textContent = 'https://stories.botble.com/' + slug;
            isDirty = true;
        });
    }

    // Real-time excerpt generation
    const excerptInput = document.querySelector('textarea[name="excerpt"]');
    const contentEditor = document.getElementById('editor-content');

    if (excerptInput && contentEditor) {
        contentEditor.addEventListener('input', function() {
            const text = this.textContent || '';
            const excerpt = text.substring(0, 200).trim();

            if (!excerptInput.value) {
                excerptInput.value = excerpt;
            }
        });
    }

    // Real-time category search
    const categorySearch = document.getElementById('category-search');
    const categoryItems = document.querySelectorAll('.category-item');

    if (categorySearch) {
        categorySearch.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();

            categoryItems.forEach(item => {
                const categoryName = item.getAttribute('data-category-name');
                const label = item.querySelector('span');

                if (categoryName.includes(searchTerm) || label.textContent.toLowerCase().includes(searchTerm)) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }
}

// Toggle editor visibility
document.getElementById('toggle-editor').addEventListener('click', function() {
    const editorContainer = document.getElementById('editor-container');
    const isHidden = editorContainer.style.display === 'none';

    editorContainer.style.display = isHidden ? 'block' : 'none';
    this.textContent = isHidden ? 'Hide Editor' : 'Show/Hide Editor';
});

// UI Blocks functionality
function toggleUIBlocks() {
    const uiBlocksPanel = document.getElementById('ui-blocks-panel');
    const isHidden = uiBlocksPanel.classList.contains('hidden');

    if (isHidden) {
        uiBlocksPanel.classList.remove('hidden');
        initializeUIBlocks();
    } else {
        uiBlocksPanel.classList.add('hidden');
    }
}

function initializeUIBlocks() {
    // Add event listeners to all UI block buttons
    document.querySelectorAll('.ui-block-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const blockType = this.dataset.block;
            insertUIBlock(blockType);
        });
    });
}

function insertUIBlock(blockType) {
    const editorContent = document.getElementById('editor-content');
    const contentTextarea = document.getElementById('content');

    let blockHTML = '';

    switch(blockType) {
        case 'heading':
            blockHTML = '<h2 class="text-2xl font-bold text-gray-900 mb-4" contenteditable="true">Your Heading Here</h2>';
            break;

        case 'paragraph':
            blockHTML = '<p class="mb-4 text-gray-700 leading-relaxed" contenteditable="true">Your paragraph text here. Click to edit and add your content.</p>';
            break;

        case 'quote':
            blockHTML = '<blockquote class="border-l-4 border-blue-500 pl-4 py-2 my-4 bg-blue-50 rounded-r-lg">' +
                '<p class="text-gray-700 italic" contenteditable="true">"Your quote text here. Click to edit."</p>' +
                '<cite class="text-sm text-gray-500 mt-2 block" contenteditable="true">— Author Name</cite>' +
                '</blockquote>';
            break;

        case 'code':
            blockHTML = '<div class="bg-gray-900 text-gray-100 p-4 rounded-lg my-4 font-mono text-sm overflow-x-auto">' +
                '<pre><code contenteditable="true">// Your code here\nfunction example() {\n    console.log(\'Hello World!\');\n}</code></pre>' +
                '</div>';
            break;

        case 'columns':
            blockHTML = '<div class="grid grid-cols-1 md:grid-cols-2 gap-4 my-4">' +
                '<div class="p-4 border border-gray-200 rounded-lg" contenteditable="true">' +
                '<h3 class="font-semibold mb-2">Column 1</h3>' +
                '<p>Content for first column. Click to edit.</p>' +
                '</div>' +
                '<div class="p-4 border border-gray-200 rounded-lg" contenteditable="true">' +
                '<h3 class="font-semibold mb-2">Column 2</h3>' +
                '<p>Content for second column. Click to edit.</p>' +
                '</div>' +
                '</div>';
            break;

        case 'divider':
            blockHTML = '<hr class="my-6 border-gray-300">';
            break;

        case 'spacer':
            blockHTML = '<div class="my-8" style="height: 2rem;"></div>';
            break;

        case 'image':
            blockHTML = '<div class="my-4">' +
                '<img src="https://via.placeholder.com/600x300?text=Click+to+upload+image" alt="Placeholder image" class="max-w-full h-auto rounded-lg cursor-pointer border-2 border-dashed border-gray-300 hover:border-blue-400 transition-colors" onclick="uploadImage(this)">' +
                '<p class="text-sm text-gray-500 mt-2 text-center">Click image to upload</p>' +
                '</div>';
            break;

        case 'gallery':
            blockHTML = '<div class="grid grid-cols-2 md:grid-cols-3 gap-4 my-4">' +
                '<img src="https://via.placeholder.com/200x150?text=Image+1" alt="Gallery image 1" class="w-full h-32 object-cover rounded-lg cursor-pointer" onclick="uploadImage(this)">' +
                '<img src="https://via.placeholder.com/200x150?text=Image+2" alt="Gallery image 2" class="w-full h-32 object-cover rounded-lg cursor-pointer" onclick="uploadImage(this)">' +
                '<img src="https://via.placeholder.com/200x150?text=Image+3" alt="Gallery image 3" class="w-full h-32 object-cover rounded-lg cursor-pointer" onclick="uploadImage(this)">' +
                '</div>';
            break;

        case 'video':
            blockHTML = '<div class="my-4">' +
                '<div class="bg-gray-100 border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">' +
                '<span class="material-symbols-outlined text-4xl text-gray-400 mb-2">play_circle</span>' +
                '<p class="text-gray-600 mb-2">Click to add video</p>' +
                '<button type="button" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700" onclick="addVideo(this)">Add Video</button>' +
                '</div>' +
                '</div>';
            break;

        case 'button':
            blockHTML = '<div class="my-4 text-center">' +
                '<button type="button" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors" contenteditable="true">Click Me</button>' +
                '</div>';
            break;

        case 'accordion':
            blockHTML = '<div class="my-4">' +
                '<div class="border border-gray-200 rounded-lg">' +
                '<div class="accordion-header p-4 bg-gray-50 cursor-pointer border-b border-gray-200" onclick="toggleAccordion(this)">' +
                '<h3 class="font-semibold" contenteditable="true">Accordion Item 1</h3>' +
                '<span class="material-symbols-outlined float-right">expand_more</span>' +
                '</div>' +
                '<div class="accordion-content p-4 hidden">' +
                '<p contenteditable="true">Content for accordion item 1. Click to edit.</p>' +
                '</div>' +
                '</div>' +
                '</div>';
            break;

        case 'tabs':
            blockHTML = '<div class="my-4">' +
                '<div class="border border-gray-200 rounded-lg">' +
                '<div class="flex border-b border-gray-200">' +
                '<button class="tab-btn px-4 py-2 bg-blue-600 text-white" onclick="switchTab(this, \'tab1\')">Tab 1</button>' +
                '<button class="tab-btn px-4 py-2 bg-gray-100 text-gray-700" onclick="switchTab(this, \'tab2\')">Tab 2</button>' +
                '</div>' +
                '<div id="tab1" class="tab-content p-4">' +
                '<p contenteditable="true">Content for tab 1. Click to edit.</p>' +
                '</div>' +
                '<div id="tab2" class="tab-content p-4 hidden">' +
                '<p contenteditable="true">Content for tab 2. Click to edit.</p>' +
                '</div>' +
                '</div>' +
                '</div>';
            break;

        case 'table':
            blockHTML = '<div class="my-4 overflow-x-auto">' +
                '<table class="min-w-full border border-gray-200 rounded-lg">' +
                '<thead class="bg-gray-50">' +
                '<tr>' +
                '<th class="px-4 py-2 border border-gray-200" contenteditable="true">Header 1</th>' +
                '<th class="px-4 py-2 border border-gray-200" contenteditable="true">Header 2</th>' +
                '<th class="px-4 py-2 border border-gray-200" contenteditable="true">Header 3</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody>' +
                '<tr>' +
                '<td class="px-4 py-2 border border-gray-200" contenteditable="true">Row 1, Cell 1</td>' +
                '<td class="px-4 py-2 border border-gray-200" contenteditable="true">Row 1, Cell 2</td>' +
                '<td class="px-4 py-2 border border-gray-200" contenteditable="true">Row 1, Cell 3</td>' +
                '</tr>' +
                '<tr>' +
                '<td class="px-4 py-2 border border-gray-200" contenteditable="true">Row 2, Cell 1</td>' +
                '<td class="px-4 py-2 border border-gray-200" contenteditable="true">Row 2, Cell 2</td>' +
                '<td class="px-4 py-2 border border-gray-200" contenteditable="true">Row 2, Cell 3</td>' +
                '</tr>' +
                '</tbody>' +
                '</table>' +
                '</div>';
            break;

        case 'list':
            blockHTML = '<div class="my-4">' +
                '<ul class="list-disc list-inside space-y-2">' +
                '<li contenteditable="true">List item 1</li>' +
                '<li contenteditable="true">List item 2</li>' +
                '<li contenteditable="true">List item 3</li>' +
                '</ul>' +
                '</div>';
            break;

        case 'timeline':
            blockHTML = '<div class="my-4">' +
                '<div class="timeline">' +
                '<div class="timeline-item flex items-start mb-4">' +
                '<div class="timeline-marker w-4 h-4 bg-blue-600 rounded-full mt-2 mr-4"></div>' +
                '<div class="timeline-content">' +
                '<h4 class="font-semibold" contenteditable="true">Timeline Event 1</h4>' +
                '<p class="text-gray-600" contenteditable="true">Description of timeline event 1</p>' +
                '</div>' +
                '</div>' +
                '<div class="timeline-item flex items-start mb-4">' +
                '<div class="timeline-marker w-4 h-4 bg-blue-600 rounded-full mt-2 mr-4"></div>' +
                '<div class="timeline-content">' +
                '<h4 class="font-semibold" contenteditable="true">Timeline Event 2</h4>' +
                '<p class="text-gray-600" contenteditable="true">Description of timeline event 2</p>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>';
            break;

        case 'progress':
            blockHTML = '<div class="my-4">' +
                '<div class="space-y-4">' +
                '<div>' +
                '<div class="flex justify-between mb-1">' +
                '<span class="text-sm font-medium" contenteditable="true">Progress 1</span>' +
                '<span class="text-sm text-gray-500">75%</span>' +
                '</div>' +
                '<div class="w-full bg-gray-200 rounded-full h-2">' +
                '<div class="bg-blue-600 h-2 rounded-full" style="width: 75%"></div>' +
                '</div>' +
                '</div>' +
                '<div>' +
                '<div class="flex justify-between mb-1">' +
                '<span class="text-sm font-medium" contenteditable="true">Progress 2</span>' +
                '<span class="text-sm text-gray-500">50%</span>' +
                '</div>' +
                '<div class="w-full bg-gray-200 rounded-full h-2">' +
                '<div class="bg-green-600 h-2 rounded-full" style="width: 50%"></div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>';
            break;
    }

    // Insert the block into the editor
    editorContent.insertAdjacentHTML('beforeend', blockHTML);

    // Update the hidden textarea
    contentTextarea.value = editorContent.innerHTML;

    // Mark as dirty for auto-save
    isDirty = true;

    // Show success notification
    showNotification((blockType.charAt(0).toUpperCase() + blockType.slice(1)) + ' block added successfully!', 'success');
}

// Helper functions for UI blocks
function uploadImage(imgElement) {
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = 'image/*';

    input.onchange = function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imgElement.src = e.target.result;
                imgElement.classList.remove('border-dashed', 'border-gray-300');
                imgElement.classList.add('border-solid', 'border-gray-200');
            };
            reader.readAsDataURL(file);
        }
    };

    input.click();
}

function addVideo(buttonElement) {
    const videoUrl = prompt('Enter video URL (YouTube, Vimeo, etc.):');
    if (videoUrl) {
        const videoContainer = buttonElement.parentElement;
        videoContainer.innerHTML =
            '<div class="aspect-video bg-gray-100 rounded-lg flex items-center justify-center">' +
                '<iframe src="' + videoUrl + '" class="w-full h-full rounded-lg" frameborder="0" allowfullscreen></iframe>' +
            '</div>';
    }
}

function toggleAccordion(headerElement) {
    const content = headerElement.nextElementSibling;
    const icon = headerElement.querySelector('.material-symbols-outlined');

    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        icon.style.transform = 'rotate(180deg)';
    } else {
        content.classList.add('hidden');
        icon.style.transform = 'rotate(0deg)';
    }
}

function switchTab(buttonElement, tabId) {
    // Remove active class from all tabs
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('bg-blue-600', 'text-white');
        btn.classList.add('bg-gray-100', 'text-gray-700');
    });

    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });

    // Activate clicked tab
    buttonElement.classList.remove('bg-gray-100', 'text-gray-700');
    buttonElement.classList.add('bg-blue-600', 'text-white');

    // Show corresponding content
    document.getElementById(tabId).classList.remove('hidden');
}

// Add media functionality
document.getElementById('add-media').addEventListener('click', function() {
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = 'image/*';
    input.multiple = true;

    input.onchange = function(e) {
        Array.from(e.target.files).forEach(file => {
            insertImageIntoEditor(file);
        });
    };

    input.click();
});

function insertImageIntoEditor(file) {
    const reader = new FileReader();
    reader.onload = function(e) {
        const img = document.createElement('img');
        img.src = e.target.result;
        img.className = 'max-w-full h-auto rounded-lg my-2';
        img.style.maxHeight = '300px';

        const editorContent = document.getElementById('editor-content');
        editorContent.appendChild(img);

        // Update content
        document.getElementById('content').value = editorContent.innerHTML;
        isDirty = true;
    };
    reader.readAsDataURL(file);
}

// Preview functionality
const previewBtn = document.getElementById('preview-content');
if (previewBtn) {
    previewBtn.addEventListener('click', function() {
        const content = document.getElementById('editor-content').innerHTML;
        const title = document.getElementById('title').value;

        const previewWindow = window.open('', '_blank', 'width=800,height=600');
        if (previewWindow) {
            previewWindow.document.open();
            previewWindow.document.write('<!DOCTYPE html>');
            previewWindow.document.write('<html>');
            previewWindow.document.write('<head>');
            previewWindow.document.write('<title>Preview: ' + title + '<\/title>');
            previewWindow.document.write('<style>');
            previewWindow.document.write('body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }');
            previewWindow.document.write('h1 { color: #333; border-bottom: 2px solid #eee; padding-bottom: 10px; }');
            previewWindow.document.write('img { max-width: 100%; height: auto; }');
            previewWindow.document.write('<\/style>');
            previewWindow.document.write('<\/head>');
            previewWindow.document.write('<body>');
            previewWindow.document.write('<h1>' + title + '<\/h1>');
            previewWindow.document.write('<div>' + content + '<\/div>');
            previewWindow.document.write('<\/body>');
            previewWindow.document.write('<\/html>');
            previewWindow.document.close();
        }
    });
}

// Show notification
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 right-4 px-4 py-2 rounded-lg text-white z-50 ' +
        (type === 'success' ? 'bg-green-500' :
        type === 'error' ? 'bg-red-500' : 'bg-blue-500');
    notification.textContent = message;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.remove();
    }, 3000);
}

function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('image-preview').classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Category search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('category-search');
    const categoryItems = document.querySelectorAll('.category-item');

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();

        categoryItems.forEach(function(item) {
            const categoryName = item.getAttribute('data-category-name');
            const label = item.querySelector('span');

            if (categoryName.includes(searchTerm) || label.textContent.toLowerCase().includes(searchTerm)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    });
});


// Image handling functions
function handleFeaturedImage(input) {
    if (window.adminImageHandler) {
        window.adminImageHandler.handleFeaturedImage(input);
    }
}

function handleGalleryImages(input) {
    if (window.adminImageHandler) {
        window.adminImageHandler.handleGalleryImages(input);
    }
}

function removeFeaturedImage() {
    if (window.adminImageHandler) {
        window.adminImageHandler.removeFeaturedImage();
    }
}

function removeGalleryImage(button) {
    if (window.adminImageHandler) {
        window.adminImageHandler.removeGalleryImage(button);
    }
}

function handleFeaturedImageSelection(images) {
    if (window.adminImageHandler) {
        window.adminImageHandler.handleFeaturedImageSelection(images);
    }
}

function handleGallerySelection(images) {
    if (window.adminImageHandler) {
        window.adminImageHandler.handleGallerySelection(images);
    }
}

function openImageUrlModal() {
    if (window.adminImageHandler) {
        window.adminImageHandler.openImageUrlModal();
    }
}
</script>
@endsection
