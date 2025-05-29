<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Http\Resources\MahasiswaResource;
use Illuminate\Support\Facades\Validator;

class MahasiswaController extends Controller
{
    // GET semua data
    public function index()
    {
        $mahasiswa = Mahasiswa::all();
        return MahasiswaResource::withStatusMessage($mahasiswa, true, 'List Data Mahasiswa');
    }

    // GET data by id
    public function show($id)
    {
        $mahasiswa = Mahasiswa::find($id);

        if (!$mahasiswa) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
                'data' => null,
            ], 404);
        }

        return MahasiswaResource::withStatusMessage($mahasiswa, true, 'Detail Mahasiswa');
    }

    // POST data baru
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'nim' => 'required|string|unique:mahasiswa,nim',
            'jurusan' => 'required|string',
            'fakultas' => 'required|string',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'data' => $validator->errors(),
            ], 400);
        }

        $data = $request->only(['nama', 'nim', 'jurusan', 'fakultas']);

        if ($request->hasFile('foto_profil')) {
            $path = $request->file('foto_profil')->store('foto_profil', 'public');
            $data['foto_profil'] = basename($path); // simpan nama file saja agar konsisten dengan model
        }

        $mahasiswa = Mahasiswa::create($data);

        return MahasiswaResource::withStatusMessage($mahasiswa, true, 'Data Mahasiswa Berhasil Ditambahkan!');
    }

    // PUT update data
    public function update(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::find($id);
        if (!$mahasiswa) {
            return response()->json([
                'success' => false,
                'message' => 'Mahasiswa tidak ditemukan',
                'data' => null,
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'nim' => 'required|string|unique:mahasiswa,nim,' . $id,
            'jurusan' => 'required|string',
            'fakultas' => 'required|string',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'data' => $validator->errors(),
            ], 400);
        }

        $data = $request->only(['nama', 'nim', 'jurusan', 'fakultas']);

        if ($request->hasFile('foto_profil')) {
            $path = $request->file('foto_profil')->store('foto_profil', 'public');
            $data['foto_profil'] = basename($path);
        }

        $mahasiswa->update($data);

        return MahasiswaResource::withStatusMessage($mahasiswa, true, 'Data Mahasiswa Berhasil Diupdate!');
    }

    // DELETE hapus data
    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::find($id);

        if (!$mahasiswa) {
            return response()->json([
                'success' => false,
                'message' => 'Mahasiswa tidak ditemukan!',
                'data' => null,
            ], 404);
        }

        $mahasiswa->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Mahasiswa Berhasil Dihapus!',
            'data' => null,
        ], 200);
    }
}
