<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Product  $model
     * @return \Illuminate\View\View
     */
    public function index(Product $model)
    {
        $products = $model->paginate(15);
        return view('products.index',compact('products'));    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * 
     * @param  \Illuminate\Http\ProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
       $validatedData = $request->validate([
            'reference' => 'required|min:3',
            'name' => 'required|min:3',
        ]);
        Product::create($validatedData);
        return redirect('/products')->with('message',__('Product successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validatedData = $request->validate([
            'reference' => 'required|min:3',
            'name' => 'required|min:3',
        ]);
        Product::whereId($id)->update($validatedData);
        return redirect('/products')->with('message',__('Product successfully updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $dependences =$this->verifyDependences($id);
        if(!$dependences){
            $product = Product::findOrFail($id);
            $product->delete();
            return redirect('/products')->with('message',__('Product successfully deleted.'));
        }else {
            return redirect('/products')->with('error',__("Product can't be deleted. Remove dependencies"));
        }
    }
}
