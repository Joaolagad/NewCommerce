<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\File;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
class ProductController extends Controller
{
    public function searchProducts(Request $request)
    {
        $searchQuery = $request->query('search');
    
        $searchResults = Product::where('name', 'LIKE', "%{$searchQuery}%")
            ->with('category')
            ->get();
    
        foreach ($searchResults as $result) {
            $result->category_name = $result->category->name;
            $result->image_url = asset('assets/uploads/products/' . $result->image);;
        }
       
    
        return response()->json($searchResults);
    }
    

    public function getTrendingProducts()
    {
        $trendingProducts = Product::where('trending', 1)->limit(5)->get();
        foreach ($trendingProducts as $product) {
        $product->image_url = asset('assets/uploads/products/' . $product->image);
    }
        return response()->json($trendingProducts);
    }
    public function getProductDetail($id)
{
    $product = Product::with('category')->find($id);
    if (!$product) {
        return response()->json(['error' => 'Product not found'], 404);
    }
    
    $product->image_url = asset('assets/uploads/products/' . $product->image);
    return response()->json($product);
}

    
    public function getProductsCategory($categoryId)
    {
        $products = Product::with('category')
            ->where('category_id', $categoryId)
            ->get();

        foreach ($products as $product) {
            $product->image_url = asset('assets/uploads/products/'.$product->image);
        }

        return response()->json($products);
    }
    
    public function index() 
    {
        $products = Product::all();
        return view('admin.product.index', compact('products'));
    }

    public function add() 
    {
        $category = Category::all();
        return view('admin.product.add', compact('category'));
    }

    public function insert(Request $request)
    {
        $products = new Product();
        if($request->hasFile('image'))
        {    
            $path = 'assets/uploads/products/'.$products->image;
            if(File::exists($path))
            {
                File::delete($path);
            }
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('assets/uploads/products/',$filename);
            $products->image = $filename;
        }
        $products->category_id = $request->input('category_id');
        $products->name = $request->input('name');
        $products->slug = $request->input('slug');
        $products->small_description = $request->input('small_description');
        $products->description = $request->input('description');
        $products->original_price = $request->input('original_price');
        $products->selling_price = $request->input('selling_price');
        $products->tax = $request->input('tax');
        $products->quantity = $request->input('quantity');
        $products->status = $request->input('status') == TRUE ? '1':'0';
        $products->trending = $request->input('trending') == TRUE ? '1':'0';
        $products->meta_title = $request->input('meta_title');
        $products->meta_keywords = $request->input('meta_keywords');
        $products->meta_description = $request->input('meta_description');
        $products->save();
        return redirect('products')->with('status',"Product Added");
    }

    public function edit($id){
        $products = Product::find($id);
        return view('admin.product.edit', compact('products'));

    }

    public function update(Request $request, $id)
    {
        $products = Product::find($id);
        if($request->hasFile('image'))
        {    
            $path = 'assets/uploads/products/'.$products->image;
            if(File::exists($path))
            {
                File::delete($path);
            }
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('assets/uploads/products/',$filename);
            $products->image = $filename;
        }
        $products->name = $request->input('name');
        $products->slug = $request->input('slug');
        $products->small_description = $request->input('small_description');
        $products->description = $request->input('description');
        $products->original_price = $request->input('original_price');
        $products->selling_price = $request->input('selling_price');
        $products->tax = $request->input('tax');
        $products->quantity = $request->input('quantity');
        $products->status = $request->input('status') == TRUE ? '1':'0';
        $products->trending = $request->input('trending') == TRUE ? '1':'0';
        $products->meta_title = $request->input('meta_title');
        $products->meta_keywords = $request->input('meta_keywords');
        $products->meta_description = $request->input('meta_description');
        $products->update();
        return redirect('products')->with('status','Product Updated');
    }

    public function destroy($id)
    {
        $products = Product::find($id);
        $path = 'assets/uploads/products/'.$products->image;
            if(File::exists($path))
            {
                File::delete($path);
            } 
        $products->delete();
        return redirect('products')->with('status','product deleted');       
    }
    
}
