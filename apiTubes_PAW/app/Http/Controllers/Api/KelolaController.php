<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
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

    public function store(Request $request) {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'berat' => 'numeric',
            'paket' => 'alpha',
            'parfum' => 'alpha',
            'lokasi' => 'alpha',
            'status' => 'alpha',
            'harga' => 'numeric'
        ]);
 
        if($validate->fails())
             return response(['message' => $validate->errors()],400);
 
        $kelola_pesanans = KelolaPesanan::create($storeData);
        return response([
         'message' => 'Add Data Success',
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
                'message' => 'Delete Data Success',
                'data' => $kelola_pesanans,
            ],200);
        }

        return response([
            'message' => 'Delete Data Failed',
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
            'berat' => 'numeric',
            'paket' => 'alpha',
            'parfum' => 'alpha',
            'lokasi' => 'alpha',
            'status' => 'alpha',
            'harga' => 'numeric'
        ]);
 
        if($validate->fails())
             return response(['message' => $validate->errors()],400);
 
        $kelola_pesanans->berat = $updateData['berat'];
        $kelola_pesanans->paket = $updateData['paket'];
        $kelola_pesanans->parfum = $updateData['parfum'];
        $kelola_pesanans->lokasi = $updateData['lokasi'];
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
