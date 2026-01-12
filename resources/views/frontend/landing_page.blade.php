@extends('layouts.frontend.app')

@section('title', $page->title)

@push('css')
<style>
    .landing-wrapper { font-family: 'Hind Siliguri', sans-serif; background: #f4f6f9; padding-bottom: 50px; }
    .hero-section { background: white; padding: 20px; border-radius: 10px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
    .hero-title { font-size: 28px; font-weight: bold; color: {{ $page->theme_color }}; margin-bottom: 15px; }
    .price-tag { font-size: 32px; color: {{ $page->theme_color }}; font-weight: bold; }
    .old-price { font-size: 20px; text-decoration: line-through; color: #777; margin-left: 10px; }
    
    /* Order Form Styles */
    .order-form-card { background: white; padding: 25px; border-radius: 10px; border: 2px solid {{ $page->theme_color }}; position: sticky; top: 20px; }
    .order-header { text-align: center; background: {{ $page->theme_color }}; color: white; padding: 10px; margin: -25px -25px 20px -25px; border-radius: 8px 8px 0 0; }
    .form-control { border-radius: 5px; height: 45px; margin-bottom: 15px; }
    .order-btn { width: 100%; background: {{ $page->theme_color }}; color: white; font-size: 22px; font-weight: bold; padding: 12px; border: none; border-radius: 5px; animation: pulse 2s infinite; }
    
    @keyframes pulse {
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(0, 0, 0, 0.7); }
        70% { transform: scale(1.02); box-shadow: 0 0 0 10px rgba(0, 0, 0, 0); }
        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(0, 0, 0, 0); }
    }
    
    /* Feature List */
    .features-list li { margin-bottom: 10px; font-size: 18px; list-style: none; }
    .features-list li i { color: {{ $page->theme_color }}; margin-right: 10px; }
</style>
@endpush

@section('content')
<div class="landing-wrapper mt-4">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="hero-section">
                    <h1 class="hero-title">{{ $page->title }}</h1>
                    
                    @if($page->video_url)
                    <div class="embed-responsive embed-responsive-16by9 mb-3">
                        <iframe class="embed-responsive-item" src="{{ $page->video_url }}" allowfullscreen></iframe>
                    </div>
                    @elseif($page->hero_image)
                    <img src="{{ asset('uploads/landing/'.$page->hero_image) }}" class="img-fluid rounded mb-3" alt="{{ $page->title }}">
                    @else
                    <img src="{{ asset('uploads/product/'.$page->product->image) }}" class="img-fluid rounded mb-3" alt="{{ $page->title }}">
                    @endif

                    <div class="price-section mb-3">
                        <span class="price-tag">{{ $page->product->discount_price ?? $page->product->price }} Tk</span>
                        @if($page->product->discount_price)
                        <span class="old-price">{{ $page->product->regular_price }} Tk</span>
                        @endif
                    </div>

                    <div class="description-content">
                        {!! $page->description !!}
                    </div>

                    @if($page->feature_list)
                    <div class="mt-4">
                        <h4 style="color: {{ $page->theme_color }}">Why buy from us?</h4>
                        <ul class="features-list p-0">
                            @foreach(explode(',', $page->feature_list) as $feature)
                            <li><i class="fas fa-check-circle"></i> {{ $feature }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>

            <div class="col-md-5">
                <div class="order-form-card" id="orderForm">
                    <div class="order-header">
                        <h4 class="m-0">অর্ডার করতে ফর্মটি পূরণ করুন</h4>
                        <small>অর্ডার কনফার্ম করতে নিচের বাটন এ ক্লিক করুন</small>
                    </div>

                    <form id="landingCheckoutForm"> 
                        @csrf
                        <div class="form-group">
                            <label>আপনার নাম *</label>
                            <input type="text" name="first_name" class="form-control" required placeholder="সম্পূর্ণ নাম লিখুন">
                        </div>

                        <div class="form-group">
                            <label>মোবাইল নাম্বার *</label>
                            <input type="text" name="phone" class="form-control" required placeholder="১১ ডিজিটের মোবাইল নাম্বার">
                        </div>

                        <div class="form-group">
                            <label>সম্পূর্ণ ঠিকানা *</label>
                            <input type="text" name="address" class="form-control" required placeholder="বাসা নং, রোড নং, এলাকা">
                        </div>

                        <div class="form-group">
                            <label>ডেলিভারি এলাকা নির্বাচন করুন</label>
                            <select name="shipping_range" id="shipping_area" class="form-control" required>
                                <option value="1">ঢাকার ভিতরে ({{ setting('shipping_charge') }} Tk)</option>
                                <option value="2">ঢাকার বাইরে ({{ setting('shipping_charge_out_of_range') }} Tk)</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                            <span>Product</span>
                            <span>{{ $page->product->title }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3 font-weight-bold">
                            <span>Subtotal</span>
                            <span id="subtotal">{{ $page->product->discount_price ?? $page->product->price }}</span> Tk
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Delivery Charge</span>
                            <span id="delivery_charge">{{ setting('shipping_charge') }}</span> Tk
                        </div>
                        <div class="d-flex justify-content-between mb-4 font-weight-bold" style="font-size: 18px; color: {{ $page->theme_color }}">
                            <span>Total</span>
                            <span id="grand_total">0</span> Tk
                        </div>

                        <input type="hidden" name="payment_method" value="cod">
                        <input type="hidden" name="shipping_method" value="courier">
                        
                        <input type="hidden" name="stotal" id="hidden_stotal" value="">
                        
                        <button type="submit" class="order-btn">অর্ডার কনফার্ম করুন</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        // 1. Calculate Totals
        var price = {{ $page->product->discount_price ?? $page->product->regular_price }};
        var inside_dhaka = {{ setting('shipping_charge') ?? 60 }};
        var outside_dhaka = {{ setting('shipping_charge_out_of_range') ?? 120 }};

        function calculateTotal() {
            var shipping = $('#shipping_area').val() == '1' ? inside_dhaka : outside_dhaka;
            var total = price + shipping;
            
            $('#delivery_charge').text(shipping);
            $('#grand_total').text(total);
            $('#hidden_stotal').val(price); // Set subtotal for backend
        }

        $('#shipping_area').change(calculateTotal);
        calculateTotal(); // Run on load

        // 2. Handle Form Submission
        $('#landingCheckoutForm').on('submit', function(e) {
            e.preventDefault();
            var btn = $('.order-btn');
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');

            // Step A: Clear Cart & Add this Product
            $.ajax({
                url: "{{ route('add.cart') }}", 
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: {{ $page->product->id }},
                    qty: 1,
                    color: 'blank', // Default logic
                    // Add attributes if needed dynamically
                },
                success: function(response) {
                    // Step B: Submit Order
                    submitOrder();
                },
                error: function() {
                    alert('Could not add product to cart.');
                    btn.prop('disabled', false).html('অর্ডার কনফার্ম করুন');
                }
            });
        });

        function submitOrder() {
            var formData = $('#landingCheckoutForm').serialize();
            
            // We use the existing 'order_minimal' route which handles guest checkout
            $.ajax({
                url: "{{ route('order.store_minimal') }}",
                method: "POST",
                data: formData,
                success: function(response) {
                    // Redirect to success page or show success message
                    if(response.indexOf('<!DOCTYPE html>') !== -1) {
                         // If response is full HTML page (success view), write it or redirect
                         // Since your controller returns a View, simplest is to redirect to a thank you page
                         // Or if the controller redirects, we follow.
                         // Usually orderStore_minimal returns a View 'frontend.order_success'
                         
                         // Fix: The controller creates order and returns a View. 
                         // Best UX: Reload page with success message or parse data.
                         // But since it returns HTML, we can replace body.
                         document.open();
                         document.write(response);
                         document.close();
                    } else {
                        // If JSON response
                        window.location.href = "/";
                    }
                },
                error: function(xhr) {
                    // Handle validation errors
                    var err = JSON.parse(xhr.responseText);
                    alert(err.message || "Something went wrong!");
                    $('.order-btn').prop('disabled', false).html('অর্ডার কনফার্ম করুন');
                }
            });
        }
    });
</script>
@endpush