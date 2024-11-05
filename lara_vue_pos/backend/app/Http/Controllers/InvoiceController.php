<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;


class InvoiceController extends Controller
{
    public function index()
    {
        $collection = Invoice::all();
        return view('page.invoice.show', compact('collection'));
    }

    public function sale()
    {
        $collection = Invoice::all();
        return view('page.invoice.sale', compact('collection'));
    }

    public function store(Request $request)
    {
        $invoice = Invoice::create([
            'name' => $request->customername,
            'phone' => $request->phone,
            'status' => $request->status,
            'amount' => $request->amount,
            'sales_by' => $request->sales_by,
            'desc' => json_encode($request->desc)
        ]);

        foreach ($request->desc as $item) {
            $product = Product::find($item['id']);
            if ($product) {
                $product->qty -= $item['quantity'];
                $product->save();
            }
        }

        return response()->json(['success' => true, 'message' => 'Invoice created successfully'], 200);
    }

    public function view($id)
    {
        $collection = Invoice::find($id);
        return view('page.invoice.view', compact('collection'));
    }
}
