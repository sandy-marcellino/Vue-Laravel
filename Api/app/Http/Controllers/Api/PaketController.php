<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Paket;

class PaketController extends Controller
{
    public function index(){
        $data_paket = Paket::all();

        if(count($data_paket) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $data_paket
            ],200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ],404);
    }

    public function show(){
        $data_paket = Paket::all();
        $arr = [];
        if(!is_null($data_paket))
        {
            foreach($data_paket as $data)
            {
                array_push($arr,$data->nama_paket);
            }
            return response([
                'message' => 'Retrieve Paket Success',
                'data' => $arr
            ],200);
        }

        return response([
            'message' => 'Paket Not Found',
            'data' => null
        ],404);
    }

    public function store(Request $request) {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'nama_paket' => 'required|max:60|unique:data_paket',
            'pribadi' => 'required|alpha',
            'terpisah' => 'required|alpha',
            'detergen' => 'required|alpha',
            'setrika' => 'required|alpha',
            'ongkir' => 'required|alpha',
            'waktu' => 'required|numeric',
            'harga' => 'required|numeric',
        ]);
 
        if($validate->fails())
             return response(['message' => $validate->errors()],400);
 
        $data_paket = Paket::create($storeData);
        return response([
         'message' => 'Berhasil Menambah Paket',
         'data' => $data_paket,
         ],200);
    }

    public function destroy($id){
            $data_paket = Paket::find($id);
 
         if(is_null($data_paket)){
             return response([
                 'message' => 'Gagal Menghapus Paket',
                 'data' => null
             ],404);
         }
 
         if($data_paket->delete()){
             return response([
                 'message' => 'Berhasil Menghapus Paket',
                 'data' => $data_paket,
             ],200);
         }
 
         return response([
             'message' => 'Gagal Menghapus Paket',
             'data' => null,
         ],400);
    }

    public function update(Request $request, $id){
        $data_paket = Paket::find($id);
        if(is_null($data_paket)){
         return response([
             'message' => 'Gagal Mengupdate Paket',
             'data' => null
         ],404);
         }
 
        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'nama_paket' => ['max:60', Rule::unique('data_paket')->ignore($data_paket)],
            'pribadi' => 'alpha',
            'terpisah' => 'alpha',
            'detergen' => 'alpha',
            'setrika' => 'alpha',
            'ongkir' => 'alpha',
            'waktu' => 'numeric',
            'harga' => 'numeric'
        ]);
 
        if($validate->fails())
             return response(['message' => $validate->errors()],400);

        $data_paket->nama_paket = $updateData['nama_paket'];
        $data_paket->pribadi = $updateData['pribadi'];
        $data_paket->terpisah = $updateData['terpisah'];
        $data_paket->detergen = $updateData['detergen'];
        $data_paket->setrika = $updateData['setrika'];
        $data_paket->ongkir = $updateData['ongkir'];
        $data_paket->waktu = $updateData['waktu'];
        $data_paket->harga = $updateData['harga'];
 
        if($data_paket->save()){
             return response([
                 'message' => 'Berhasil Mengupdate Paket',
                 'data' => $data_paket,
                 ],200);
        }
 
        return response([
         'message' => 'Gagal Mengupdate Paket',
         'data' => null,
         ],400);
    }
}
