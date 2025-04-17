<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function show($encoded_data)
    {
        try {
            $decoded = json_decode(base64_decode($encoded_data), true);
            
            if (!$decoded || !isset($decoded['products'])) {
                return abort(404);
            }

            return view('wishlist.show', [
                'wishlist' => $decoded
            ]);
        } catch (\Exception $e) {
            return abort(404);
        }
    }
}