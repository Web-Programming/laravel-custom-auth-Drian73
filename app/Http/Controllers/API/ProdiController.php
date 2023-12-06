<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Prodi;

class ProdiController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //mengambil data dari tabel prodis dan menyimpannya pada variabel $prodis
        $prodis = Prodi::all();
        return $this->sendResponse($prodis, 'Data prodi.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //membuat validasi semua field wajib diisi
        $validasi = $request->validate([
            'nama' => 'required|min:5|max:20',
            'foto' => 'required|file|image|max:5000'
        ]);

        $ext = $request->foto->getClientOriginalExtension();
        $nama_file = "foto-" . time() . "." . $ext;

        //nama file baru: foto-1234343.png
        $path = $request->foto->storeAs('public', $nama_file);

        //melakukan insert data
        $prodi = new Prodi();
        $prodi->nama = $validasi['nama'];
        $prodi->foto = $nama_file;

        //jika berhasil maka simpan data dengan method $post->save()
        if ($prodi->save()) {
            $success['data'] = $prodi;
            return $this->sendResponse($success, 'Data prodi berhasil disimpan.');
        } else {
            return $this->sendError('Error.', ['error' => 'Data prodi gagal disimpan.']);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //membuat validasi semua field wajib diisi
        $validasi = $request->validate([
            'nama' => 'required|min:5|max:20',
            'foto' => 'required|file|image|max:5000'
        ]);

        //ambil ekstensi file
        $ext = $request->foto->getClientOriginalExtension();

        //rename nama file
        $nama_file = "foto-" . time() . "." . $ext;
        $path = $request->foto->storeAs('public', $nama_file);

        //cari data prodi berdasarkan id
        $prodi = Prodi::find($id);
        //isi property nama dan foto
        $prodi->nama = $validasi['nama'];
        $prodi->foto = $nama_file;

        //jika berhasil maka simpan data prodi dengan methode $prodi->save()
        if ($prodi->save()) {
            $success['data'] = $prodi;
            return $this->sendResponse($success, 'Data Prodi berhasil diperbarui.');
        } else {
            return $this->sendError('Error.', ['error' => 'Data prodi gagal diperbarui.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function delete($id) {
        $prodi = Prodi::findOrFail($id);
        //hapus data menggunakan method delete()
        if ($prodi->delete()) {
            $success['data'] = [];
            return $this->sendResponse($success, "Data Prodi dengan id $id berhasil dihapus");
        } else {
            return $this->sendError('Error', ['error' => 'Data prodi gagal dihapus']);
        }
    }
}
