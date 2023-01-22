<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Wisata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function allData()
    {
        $data = Wisata::all();

        return response()->json($data);
    }

    public function detailData($id)
    {
        $data = Wisata::find($id);
        $attach = Attachment::where('wisata_id', $id)->get();

        return response()->json([
            'wisata' => $data,
            'attach' => $attach
        ]);
    }

    public function searchData($key)
    {
        $data = DB::table('wisatas')->where('nama_wisata', 'LIKE', '%' . $key . '%')->get();

        return response()->json($data);
    }
}
