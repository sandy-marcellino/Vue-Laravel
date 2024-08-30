<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Mitra;

class MitraController extends Controller
{
    public function index(){
        $mitra = Mitra::all();

        if(count($mitra) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $mitra
            ],200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ],404);
    }

    public function show($id){
        $mitra = Mitra::find($id);

        if(!is_null($mitra)){
            return response([
                'message' => 'Retrieve mitra Success',
                'data' => $mitra
            ],200);
        }

        return response([
            'message' => 'Mitra Not Found',
            'data' => null
        ],404);
    }

    public function store(Request $request) {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'pemilik' => 'required|max:60|unique:mitras',
            'email' => 'required|email:rfc,dns|unique:users',
            'telp' => 'required|numeric|regex:/(0)(8)/|digits_between:10,13',
            'alamat' => 'required',
        ]);
 
        if($validate->fails())
            return response(['message' => $validate->errors()],400);
 
        $mitra = Mitra::create($storeData);
        return response([
            'message' => 'Berhasil Menambah Mitra',
            'data' => $mitra,
        ],200);
    }

    public function update(Request $request, $id){
        $mitra = Mitra::find($id);
        if(is_null($mitra)){
         return response([
             'message' => 'Gagal Mengupdate Mitra',
             'data' => null
         ],404);
         }
 
        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'pemilik' => ['max:60', Rule::unique('mitras')->ignore($mitra)],
            'email' => 'required|email:rfc,dns|unique:users',
            'telp' => 'required|numeric|regex:/(0)(8)/|digits_between:10,13',
            'alamat' => 'required'
        ]);
 
        if($validate->fails())
            return response(['message' => $validate->errors()],400);
 
        $mitra->pemilik = $updateData['pemilik'];
        $mitra->email = $updateData['email'];
        $mitra->telp = $updateData['telp'];
        $mitra->alamat = $updateData['alamat'];
 
        if($mitra->save()){
             return response([
                 'message' => 'Berhasil Mengupdate Mitra',
                 'data' => $mitra,
                 ],200);
        }
 
        return response([
         'message' => 'Gagal Mengupdate Mitra',
         'data' => null,
         ],400);
    } 

    public function destroy($id){
        $mitra = Mitra::find($id);
 
         if(is_null($mitra)){
             return response([
                 'message' => 'Gagal Menghapus Mitra',
                 'data' => null
             ],404);
         }
 
         if($mitra->delete()){
             return response([
                 'message' => 'Berhasil Menghapus Mitra',
                 'data' => $mitra,
             ],200);
         }
 
         return response([
             'message' => 'Gagal Menghapus Mitra',
             'data' => null,
         ],400);
    }

    public function showLokasi(){
        $mitras = Mitra::all();
        $arr1 = [];
        if(!is_null($mitras))
        {
            foreach($mitras as $mitra)
            {
                array_push($arr1,$mitra->alamat);
            }
            return response([
                'message' => 'Retrieve Paket Success',
                'data' => $arr1
            ],200);
        }

        return response([
            'message' => 'Paket Not Found',
            'data' => null
        ],404);
    }
}
