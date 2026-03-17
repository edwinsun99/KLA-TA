<?php

namespace App\Http\Controllers\cs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Service;

class ProductController extends Controller
{
  public function getProductType(Request $request)
{
    $pn = $request->pn;

    $product = Product::where('pn', $pn)->first();

    return response()->json([
        'nt' => $product->nt ?? null
    ]);
}


}
