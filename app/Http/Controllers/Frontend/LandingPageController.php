<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\LandingPage;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function show($slug)
    {
        $page = LandingPage::with('product.images')->where('slug', $slug)->where('status', 1)->firstOrFail();
        return view('frontend.landing_page', compact('page'));
    }
}