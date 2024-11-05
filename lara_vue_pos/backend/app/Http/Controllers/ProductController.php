<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    public function index()
    {
        $collection = Product::all();
        return view('page.product.show', compact('collection'));
    }

    public function stock()
    {
        $collection = Product::all();
        return view('page.product.stock', compact('collection'));
    }

    public function productlist()
    {
        $collection = Product::all();
        return response()->json($collection);
    }


    public function add()
    {
        return view('page.product.add');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'qty' => 'required',
            'sku' => 'required',
            'max_order' => 'required',
            'unit' => 'required',
            'category' => 'required',
            'promo_code' => 'required',
            'desc' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/product/'), $imageName);
            $data['image'] = 'images/product/' . $imageName;
        }

        Product::create($data);
        return redirect()->back()->with('success', 'Product added successfully');
    }

    public function edit($id)
    {
        $collection = Product::find($id);
        return view('page.product.update', compact('collection'));
    }

    public function view($id)
    {
        $collection = Product::find($id);
        return view('page.product.view', compact('collection'));
    }

    public function update(Request $request, $id)
    {
        $collection = Product::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'qty' => 'required',
            'sku' => 'required',
            'max_order' => 'required',
            'unit' => 'required',
            'category' => 'required',
            'promo_code' => 'required',
            'desc' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($collection->image && file_exists(public_path($collection->image))) {
                unlink(public_path($collection->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/product/'), $imageName);
            $data['image'] = 'images/product/' . $imageName;
        }

        $collection->update($data);

        return redirect()->back()->with('success', 'Product updated successfully');
    }


    public function destroy($id)
    {
        $collection = Product::findOrFail($id);
        $collection->delete();

        return redirect()->back()->with('success', 'Product delete successfully');
    }
}
