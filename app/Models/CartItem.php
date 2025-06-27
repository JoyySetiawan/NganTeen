<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $fillable = ['cart_id', 'menu_id', 'jumlah'];

    // Relasi: cart item punya menu
    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    // Relasi: cart item punya cart
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }
}
