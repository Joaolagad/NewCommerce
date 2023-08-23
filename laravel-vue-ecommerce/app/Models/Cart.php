<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';
    protected $fillable = [
        'user_id',
        'guest_id',
        'prod_id',
        'prod_qty',
    ];  

    public function product()
    {
        return $this->belongsTo(Product::class, 'prod_id');
    }

    public static function getCartItems()
    {
        $user = auth()->user();

        if ($user) {
            return Cart::where('user_id', $user->id)->get();
        } else {
            $guest_id = session()->getId();
            return Cart::where('guest_id', $guest_id)->get();
        }
    }
}
