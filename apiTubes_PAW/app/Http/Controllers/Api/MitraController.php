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
            'message' => 'Add Mitra Success',
            'data' => $mitra,
        ],200);
    }

    public function update(Request $request, $id){
        $mitra = Mitra::find($id);
        if(is_null($mitra)){
         return response([
             'message' => 'Mitra Not Found',
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
                 'message' => 'Update Mitra Success',
                 'data' => $mitra,
                 ],200);
        }
 
        return response([
         'message' => 'Updated mitra Failed',
         'data' => null,
         ],400);
    } 

    public function destroy($id){
        $mitra = Mitra::find($id);
 
         if(is_null($mitra)){
             return response([
                 'message' => 'Mitra Not Found',
                 'data' => null
             ],404);
         }
 
         if($mitra->delete()){
             return response([
                 'message' => 'Delete Mitra Success',
                 'data' => $mitra,
             ],200);
         }
 
         return response([
             'message' => 'Delete Mitra Failed',
             'data' => null,
         ],400);
    }
}
