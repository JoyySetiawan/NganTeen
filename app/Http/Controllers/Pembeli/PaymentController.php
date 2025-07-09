<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:pembeli']);
    }

    /**
     * Show QRIS payment page for a given store.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null $store  Store (warung) name slug, e.g. "jajang"
     */
    public function show(Request $request, $store = null)
    {
        // Attempt to find seller by warung / store name
        $seller = null;
        if ($store) {
            if (is_numeric($store)) {
                $seller = User::find($store);
            } else {
                // try match slug from name
                $seller = User::get()->firstWhere(function ($user) use ($store) {
                    return \Illuminate\Support\Str::slug($user->name) === $store;
                });
            }
        }

        return view('pembeli.payment', [
            'store'  => $store,
            'seller' => $seller,
            'qrisUrl' => $seller && $seller->qris_image ? Storage::url($seller->qris_image) : null,
        ]);
    }
}
