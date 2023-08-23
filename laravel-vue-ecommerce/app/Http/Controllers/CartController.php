<?php
namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Arr;
class CartController extends Controller
{
    public function getInitialCartCount(Request $request)
{
    $user_id = $request->input('user_id');
    $guest_id = $user_id ? null : session()->getId();

    $cartCount = $user_id
        ? Cart::where('user_id', $user_id)->sum('prod_qty')
        : Cart::where('guest_id', $guest_id)->sum('prod_qty');

    return response()->json(['cartCount' => $cartCount]);
}

   
    public function checkout(Request $request)
    {
        try {
            Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));
    
            $cartItems = $this->getCartItems();
    
            foreach ($cartItems as $item) {
                $item->product->image_url = url('http://localhost:5173/assets/uploads/products/' . $item->product->image);
            
                $product = $item->product;
            
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $product->name,
                            'images' => [$product->image_url],
                        ],
                        'unit_amount' => intval($product->selling_price * 100),
                    ],
                    'quantity' => $item->prod_qty,
                ];
            }
            
    
            if (empty($lineItems)) {
                return response()->json(['error' => 'No items in the cart'], 400);
            }
    
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => 'https://example.com/success?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => 'https://example.com/cancel',
            ]);
    
            return response()->json(['url' => $session->url]);
        } catch (\Exception $e) {
            \Log::error('Checkout Error: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred during checkout'], 500);
        }
    }
    
    public function addToCart(Request $request)
    {
        $user_id = $request->input('user_id');
        $guest_id = $user_id ? null : session()->getId();
        $product_id = $request->input('product_id');
        $quantity = $request->input('quantity');

        $product = Product::find($product_id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
    
        $cartItem = new Cart([
            'user_id' => $user_id,
            'guest_id' => $guest_id,
            'prod_id' => $product->id,
            'prod_qty' => $quantity,
        ]);
        $cartItem->save();
    
        $cartItem->load('product');
        
        $cartCount = $user_id
            ? Cart::where('user_id', $user_id)->sum('prod_qty')
            : Cart::where('guest_id', $guest_id)->sum('prod_qty');
        
        return response()->json([
            'message' => 'Item Added to Cart',
            'cartItem' => $cartItem,
            'cartCount' => $cartCount,
            'user_id' => $user_id,    
            'guest_id' => $guest_id,
        ]);
    }
    

public function getCartItems()
{
    $user = Auth::user();  
    $guest_id = $user ? null : session()->getId();

    if ($user) {
        $user_id = $user->id;
        $cartItems = Cart::where('user_id', $user_id)->with('product')->get();
    } else {
        $guest_id = session()->getId();
        $cartItems = Cart::where('guest_id', $guest_id)->with('product')->get();
    }

    $cartItems->load('product');
    foreach ($cartItems as $item) {
        $item->product->image_url = asset('assets/uploads/products/' . $item->product->image);
    }
       
    return $cartItems;
}


}