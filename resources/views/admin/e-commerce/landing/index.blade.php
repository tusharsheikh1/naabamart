@extends('layouts.admin.e-commerce.app')
@section('title', 'Landing Pages List')

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <style>
        .copy-btn { cursor: pointer; color: #007bff; }
        .copy-btn:hover { text-decoration: underline; }
    </style>
@endpush

@section('content')
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All Landing Pages</h3>
            <div class="card-tools">
                <a href="{{ route('admin.landing.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Create New
                </a>
            </div>
        </div>
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width: 5%">#</th>
                        <th style="width: 20%">Campaign Title</th>
                        <th style="width: 20%">Linked Product</th>
                        <th style="width: 25%">Page Link</th>
                        <th style="width: 10%">Status</th>
                        <th style="width: 20%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pages as $key => $page)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>
                            <strong>{{ $page->title }}</strong>
                            <br>
                            <small class="text-muted">Created: {{ $page->created_at->format('d M, Y') }}</small>
                        </td>
                        <td>
                            @if($page->product)
                                <a href="{{ route('product.details', $page->product->slug) }}" target="_blank">
                                    {{ Str::limit($page->product->title, 30) }}
                                </a>
                                <br>
                                <small>Price: {{ $page->product->discount_price ?? $page->product->regular_price }} Tk</small>
                            @else
                                <span class="badge badge-danger">Product Not Found</span>
                            @endif
                        </td>
                        <td>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" value="{{ route('landing.show', $page->slug) }}" readonly id="link_{{ $page->id }}">
                                <span class="input-group-append">
                                    <button type="button" class="btn btn-info btn-flat copy-btn" onclick="copyLink({{ $page->id }})">Copy</button>
                                </span>
                            </div>
                            <small>
                                <a href="{{ route('landing.show', $page->slug) }}" target="_blank">
                                    <i class="fas fa-external-link-alt"></i> Visit Page
                                </a>
                            </small>
                        </td>
                        <td>
                            <span class="badge badge-{{ $page->status ? 'success' : 'secondary' }}">
                                {{ $page->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.landing.edit', $page->id) }}" class="btn btn-info btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            <form action="{{ route('admin.landing.destroy', $page->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this landing page?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection

@push('js')
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(function () {
        $("#example1").DataTable({
            "responsive": true,
            "autoWidth": false,
            "order": [[ 0, "desc" ]]
        });
    });

    function copyLink(id) {
        var copyText = document.getElementById("link_" + id);
        copyText.select();
        copyText.setSelectionRange(0, 99999); /* For mobile devices */
        document.execCommand("copy");
        
        // Optional: Show toast or alert
        alert("Link copied: " + copyText.value);
    }
</script>
@endpush