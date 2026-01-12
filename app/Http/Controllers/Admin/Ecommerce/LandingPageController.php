<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\LandingPage;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LandingPageController extends Controller
{
    public function index()
    {
        $pages = LandingPage::with('product')->latest()->get();
        return view('admin.e-commerce.landing.index', compact('pages'));
    }

    public function create()
    {
        // Fetch active products for dropdown
        $products = Product::where('status', 1)->select('id', 'title', 'sku')->get();
        return view('admin.e-commerce.landing.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'product_id' => 'required',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->title) . '-' . uniqid(); // Ensure unique slug

        if ($request->hasFile('hero_image')) {
            $image = $request->file('hero_image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/landing'), $name);
            $data['hero_image'] = $name;
        }

        LandingPage::create($data);

        notify()->success('Landing Page Created Successfully');
        return redirect()->route('admin.landing.index');
    }

    public function edit($id)
    {
        $page = LandingPage::find($id);
        $products = Product::where('status', 1)->select('id', 'title', 'sku')->get();
        return view('admin.e-commerce.landing.edit', compact('page', 'products'));
    }

    public function update(Request $request, $id)
    {
        $page = LandingPage::find($id);
        $data = $request->all();

        if ($request->hasFile('hero_image')) {
            // Delete old image if exists
            if ($page->hero_image && file_exists(public_path('uploads/landing/' . $page->hero_image))) {
                unlink(public_path('uploads/landing/' . $page->hero_image));
            }
            $image = $request->file('hero_image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/landing'), $name);
            $data['hero_image'] = $name;
        }

        $page->update($data);

        notify()->success('Landing Page Updated Successfully');
        return redirect()->route('admin.landing.index');
    }

    public function destroy($id)
    {
        $page = LandingPage::find($id);
        if ($page->hero_image && file_exists(public_path('uploads/landing/' . $page->hero_image))) {
            unlink(public_path('uploads/landing/' . $page->hero_image));
        }
        $page->delete();
        notify()->success('Landing Page Deleted');
        return back();
    }
}