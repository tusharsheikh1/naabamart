@extends('layouts.admin.e-commerce.app')
@section('title', 'Create Landing Page')

@section('content')
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3>Create Landing Page</h3>
        </div>
        <form action="{{ route('admin.landing.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Campaign Title</label>
                            <input type="text" name="title" class="form-control" required placeholder="e.g. Special Eid Offer">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Select Product</label>
                            <select name="product_id" class="form-control select2" required>
                                <option value="">Select a Product</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->title }} ({{ $product->sku }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Hero Image</label>
                            <input type="file" name="hero_image" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Video URL (YouTube Embed Link)</label>
                            <input type="text" name="video_url" class="form-control" placeholder="https://www.youtube.com/embed/...">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control summernote" id="summernote"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Features (Comma separated)</label>
                            <textarea name="feature_list" class="form-control" placeholder="Premium Quality, Free Shipping, 100% Authentic"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Theme Color</label>
                            <input type="color" name="theme_color" class="form-control" value="#cd171e">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Create Landing Page</button>
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