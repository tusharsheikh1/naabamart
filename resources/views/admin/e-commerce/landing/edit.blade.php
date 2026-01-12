@extends('layouts.admin.e-commerce.app')
@section('title', 'Edit Landing Page')

@section('content')
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3>Edit Landing Page</h3>
        </div>
        <form action="{{ route('admin.landing.update', $landing->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Campaign Title</label>
                            <input type="text" name="title" class="form-control" required value="{{ $landing->title }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Select Product</label>
                            <select name="product_id" class="form-control select2" required>
                                <option value="">Select a Product</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ $landing->product_id == $product->id ? 'selected' : '' }}>
                                        {{ $product->title }} ({{ $product->sku }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Hero Image</label>
                            <input type="file" name="hero_image" class="form-control">
                            @if($landing->hero_image)
                                <div class="mt-2">
                                    <label>Current Image:</label>
                                    <br>
                                    <img src="{{ asset($landing->hero_image) }}" alt="Current Hero" class="img-thumbnail" style="max-height: 100px;">
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Video URL (YouTube Embed Link)</label>
                            <input type="text" name="video_url" class="form-control" value="{{ $landing->video_url }}" placeholder="https://www.youtube.com/embed/...">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control summernote" id="summernote">{{ $landing->description }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Features (Comma separated)</label>
                            <textarea name="feature_list" class="form-control" placeholder="Premium Quality, Free Shipping, 100% Authentic">{{ $landing->feature_list }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Theme Color</label>
                            <input type="color" name="theme_color" class="form-control" value="{{ $landing->theme_color ?? '#cd171e' }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update Landing Page</button>
            </div>
        </form>
    </div>
</section>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        $('.select2').select2();
        $('#summernote').summernote();
    });
</script>
@endpush