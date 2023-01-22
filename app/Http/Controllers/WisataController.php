<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Wisata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class WisataController extends Controller
{
    public function login(Request $request)
    {
        $credentials = [
            'username' => $request->username,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->with('loginerror', 'Username atau password salah');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function index()
    {
        return view('index', [
            'data' => Wisata::all()
        ]);
    }

    public function tambahObjek()
    {
        return view('detail');
    }


    public function saveBaru(Request $request)
    {
        $data = Wisata::create([
            'nama_wisata' => $request->nama,
            'qr_code' => 'qrcode-' . $request->nama . '.png'
        ]);

        QrCode::format('png')->size(500)->generate('' . $data->id . '', public_path('images/qrcode-' . $request->nama . '.png'));

        return redirect('/detail?id=' . $data->id);
    }

    public function detailWisata(Request $request)
    {
        return view('detail', [
            'data' => Wisata::find($request->id),
            'attach' => Attachment::where('wisata_id', $request->id)->get()
        ]);
    }

    public function updateDeskripsi($id, Request $request)
    {
        $data = Wisata::find($id);
        $data->update(['deskripsi' => $request->value]);
    }

    public function updateLink($id, Request $request)
    {
        $data = Wisata::find($id);
        $data->update(['maps' => $request->value]);
    }

    public function updateFoto($id, Request $request)
    {
        $data = Wisata::find($id);

        $path = "./images/" . $data->foto;
        File::delete($path);

        $file = $request->foto;

        $filename = $data->nama_wisata . time() . '.' . $file->getClientOriginalExtension();

        $request->foto->move('images', $filename);

        $data->update(['foto' => $filename]);

        return redirect('/detail?id=' . $data->id);
    }

    public function updateAttach($id, Request $request)
    {
        $data = Wisata::find($id);
        $counter = 1;

        foreach ($request->attach as $key) {
            $filename = $data->nama_wisata . '-Attach-' . $counter . '-' . time() . '.' . $key->getClientOriginalExtension();
            $key->move('images', $filename);
            Attachment::create([
                'wisata_id' => $data->id,
                'attach_name' => $filename
            ]);
            $counter = $counter + 1;
        }

        return redirect('/detail?id=' . $data->id);
    }

    public function deleteAttach($id)
    {
        $data = Attachment::find($id);

        $back = $data->wisata_id;

        $path = "./images/" . $data->attach_name;
        File::delete($path);

        $data->delete();
    }

    public function hapusObjek(Request $request)
    {
        $data = Wisata::find($request->id);
        $attach = Attachment::where('wisata_id', $request->id)->get();
        $path = "./images/" . $data->foto;
        File::delete($path);
        $qr = "./images/" . $data->qr_code;
        File::delete($qr);
        foreach ($attach as $key) {
            $att = "./images/" . $key->attach_name;
            File::delete($att);
        }
        $data->delete();

        return redirect('/');
    }
}
