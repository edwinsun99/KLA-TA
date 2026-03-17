<?php
namespace App\Http\Controllers\cs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // WAJIB ada ini
use App\Models\Product;
use App\Models\Service;

class NewCaseController extends Controller
{
    public function index()
    {
        return view('cs.newcase'); // file: resources/views/newcase.blade.php
    }

    public function getNamaType($pn)
{
    $service = Service::where('product_number', $pn)->first();

    if ($service) {
        return response()->json(['nama_type' => $service->nama_type]);
    }
    return response()->json(['nama_type' => null]);
}

}
