<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use Illuminate\Support\Facades\Auth;
use App\KelolaPesanan;

class KelolaController extends Controller
{
    public function index(){
        $kelola_pesanans = KelolaPesanan::all();

        if(count($kelola_pesanans) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $kelola_pesanans
            ],200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ],404);
    }

    public function show($id){
        $kelola_pesanans = KelolaPesanan::find($id);

        if(!is_null($kelola_pesanans)){
            return response([
                'message' => 'Retrieve Data Success',
                'data' => $kelola_pesanans
            ],200);
        }

        return response([
            'message' => 'Data Not Found',
            'data' => null
        ],404);
    }

    public function detailUser()
    {
        $user = Auth::users();
        return response([
            'message' => 'Detail',
            'user' => $user
        ]);
    }

    public function store(Request $request) {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'berat' => 'numeric',
            'paket' => 'required|alpha',
            'parfum' => 'required|alpha',
            'lokasi' => 'required|alpha',
            'status' => 'alpha',
            'harga' => 'numeric',
            'email' => 'required'
        ]);
 
        if($validate->fails())
             return response(['message' => $validate->errors()],400);
 
        $kelola_pesanans = KelolaPesanan::create($storeData);
        return response([
         'message' => 'Berhasil Menambah Data',
         'data' => $kelola_pesanans,
         ],200);
    }

    public function destroy($id){
        $kelola_pesanans = KelolaPesanan::find($id);
 
        if(is_null($kelola_pesanans)){
            return response([
                'message' => 'Data Not Found',
                'data' => null
            ],404);
        }

        if($kelola_pesanans ->delete()){
            return response([
                'message' => 'Berhasil Menghapus Pesanan',
                'data' => $kelola_pesanans,
            ],200);
        }

        return response([
            'message' => 'Gagal Menghapus Pesanan',
            'data' => null,
        ],400);
    }

    public function update(Request $request, $id){
        $kelola_pesanans = KelolaPesanan::find($id);
        if(is_null($kelola_pesanans)){
            return response([
                'message' => 'Data Not Found',
                'data' => null
            ],404);
         }
 
        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'paket' => 'alpha',
            'parfum' => 'required|alpha',
            'lokasi' => 'required|alpha',
        ]);
 
        if($validate->fails())
             return response(['message' => $validate->errors()],400);
 
       
        $kelola_pesanans->paket = $updateData['paket'];
        $kelola_pesanans->parfum = $updateData['parfum'];
        $kelola_pesanans->lokasi = $updateData['lokasi'];
 
        if($kelola_pesanans->save()){
             return response([
                 'message' => 'Pesanan Berhasil di Update!',
                 'data' => $kelola_pesanans,
                 ],200);
        }
 
        return response([
         'message' => 'Gagal Mengupdate pesanan',
         'data' => null,
         ],400);
    }

    public function updateAdmin(Request $request, $id){
        $kelola_pesanans = KelolaPesanan::find($id);
        if(is_null($kelola_pesanans)){
            return response([
                'message' => 'Data Not Found',
                'data' => null
            ],404);
         }
 
        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'berat' => 'required|numeric',
            'paket' => 'alpha',
            'parfum' => 'alpha',
            'lokasi' => 'alpha',
            'status' => 'required|alpha',
            'harga' => 'required|numeric'
        ]);
 
        if($validate->fails())
             return response(['message' => $validate->errors()],400);
 
       
        $kelola_pesanans->paket = $updateData['paket'];
        $kelola_pesanans->parfum = $updateData['parfum'];
        $kelola_pesanans->lokasi = $updateData['lokasi'];
        $kelola_pesanans->berat = $updateData['berat'];
        $kelola_pesanans->status = $updateData['status'];
        $kelola_pesanans->harga = $updateData['harga'];
        
 
        if($kelola_pesanans->save()){
             return response([
                 'message' => 'Update data Success',
                 'data' => $kelola_pesanans,
                 ],200);
        }
 
        return response([
         'message' => 'Updated data Failed',
         'data' => null,
         ],400);
    }
}
