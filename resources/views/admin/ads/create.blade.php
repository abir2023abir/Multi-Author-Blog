@extends('layouts.admin')

@section('title', 'Create Ad')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Create New Ad</h3>
                    <a href="{{ route('admin.ads.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Ads
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.ads.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Ad Name <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           id="name"
                                           name="name"
                                           value="{{ old('name') }}"
                                           placeholder="Enter ad name"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="position">Position <span class="text-danger">*</span></label>
                                    <select class="form-control @error('position') is-invalid @enderror"
                                            id="position"
                                            name="position"
                                            required>
                                        <option value="">Select Position</option>
                                        <option value="header" {{ old('position') == 'header' ? 'selected' : '' }}>Header</option>
                                        <option value="sidebar" {{ old('position') == 'sidebar' ? 'selected' : '' }}>Sidebar</option>
                                        <option value="footer" {{ old('position') == 'footer' ? 'selected' : '' }}>Footer</option>
                                        <option value="content-top" {{ old('position') == 'content-top' ? 'selected' : '' }}>Content Top</option>
                                        <option value="content-bottom" {{ old('position') == 'content-bottom' ? 'selected' : '' }}>Content Bottom</option>
                                        <option value="between-posts" {{ old('position') == 'between-posts' ? 'selected' : '' }}>Between Posts</option>
                                    </select>
                                    @error('position')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="code">Ad Code <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('code') is-invalid @enderror"
                                      id="code"
                                      name="code"
                                      rows="8"
                                      placeholder="Enter ad code (HTML, JavaScript, etc.)"
                                      required>{{ old('code') }}</textarea>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                You can paste HTML, JavaScript, or any other ad code here.
                            </small>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="width">Width (px)</label>
                                    <input type="number"
                                           class="form-control @error('width') is-invalid @enderror"
                                           id="width"
                                           name="width"
                                           value="{{ old('width') }}"
                                           placeholder="e.g., 300">
                                    @error('width')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="height">Height (px)</label>
                                    <input type="number"
                                           class="form-control @error('height') is-invalid @enderror"
                                           id="height"
                                           name="height"
                                           value="{{ old('height') }}"
                                           placeholder="e.g., 250">
                                    @error('height')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description"
                                      name="description"
                                      rows="3"
                                      placeholder="Enter ad description (optional)">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="checkbox"
                                       id="is_active"
                                       name="is_active"
                                       value="1"
                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active
                                </label>
                            </div>
                            <small class="form-text text-muted">
                                Uncheck to disable this ad temporarily.
                            </small>
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="checkbox"
                                       id="is_responsive"
                                       name="is_responsive"
                                       value="1"
                                       {{ old('is_responsive', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_responsive">
                                    Responsive
                                </label>
                            </div>
                            <small class="form-text text-muted">
                                Check if this ad should be responsive on mobile devices.
                            </small>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Ad
                            </button>
                            <a href="{{ route('admin.ads.index') }}" class="btn btn-secondary ml-2">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-resize textarea
    const textarea = document.getElementById('code');
    if (textarea) {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
    }
});
</script>
@endsection
