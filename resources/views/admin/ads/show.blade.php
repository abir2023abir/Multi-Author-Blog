@extends('layouts.admin')

@section('title', 'View Ad')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Ad Details: {{ $ad->name }}</h3>
                    <div class="btn-group">
                        <a href="{{ route('admin.ads.edit', $ad->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.ads.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Ads
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="200">Name:</th>
                                    <td>{{ $ad->name }}</td>
                                </tr>
                                <tr>
                                    <th>Position:</th>
                                    <td>
                                        <span class="badge badge-info">{{ ucfirst(str_replace('-', ' ', $ad->position)) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        @if($ad->is_active)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Responsive:</th>
                                    <td>
                                        @if($ad->is_responsive)
                                            <span class="badge badge-success">Yes</span>
                                        @else
                                            <span class="badge badge-warning">No</span>
                                        @endif
                                    </td>
                                </tr>
                                @if($ad->width || $ad->height)
                                <tr>
                                    <th>Dimensions:</th>
                                    <td>
                                        @if($ad->width && $ad->height)
                                            {{ $ad->width }}px × {{ $ad->height }}px
                                        @elseif($ad->width)
                                            Width: {{ $ad->width }}px
                                        @elseif($ad->height)
                                            Height: {{ $ad->height }}px
                                        @endif
                                    </td>
                                </tr>
                                @endif
                                @if($ad->description)
                                <tr>
                                    <th>Description:</th>
                                    <td>{{ $ad->description }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th>Created:</th>
                                    <td>{{ $ad->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Updated:</th>
                                    <td>{{ $ad->updated_at->format('M d, Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Ad Preview</h5>
                                </div>
                                <div class="card-body">
                                    @if($ad->is_active)
                                        <div class="ad-preview" style="
                                            @if($ad->width) width: {{ $ad->width }}px; @endif
                                            @if($ad->height) height: {{ $ad->height }}px; @endif
                                            border: 1px dashed #ccc;
                                            padding: 10px;
                                            text-align: center;
                                            background: #f8f9fa;
                                        ">
                                            <small class="text-muted">Ad Preview</small>
                                            <div class="mt-2">
                                                {!! $ad->code !!}
                                            </div>
                                        </div>
                                    @else
                                        <div class="alert alert-warning">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            This ad is currently inactive and will not be displayed.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
