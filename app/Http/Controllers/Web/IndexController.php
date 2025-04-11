<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models;
use App\Services\Product\ProductService;
use Illuminate\Http\Request;
use Response;

class IndexController extends Controller
{
    public function __construct(
        private ProductService $product_service
    ) {
    }

    public function index(Request $request)
    {
        return abort(Response::NOT_FOUND);
    }

    public function getPage(Request $request, Models\Page $page)
    {
        return view('templates.page', [
            'page' => $page,
        ]);
    }

    public function awayProxy(Request $request, string $external_link)
    {
        $link = base64_decode($external_link);

        $this->product_service->handleLinkClick($link);

        return redirect()->away($link);
    }
}
