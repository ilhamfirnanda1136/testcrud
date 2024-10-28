<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\{kategori};

use Validator;

class kategoriController extends Controller
{
    public function index()
    {
        return view('kategori.view');
    }

    public function table() 
    {
        $model= kategori::query();
        return \DataTables::of($model)
        ->addColumn('action',function($model){
            return view('kategori.action',[
                'model'=>$model,
            ]);
        })
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->make(true);
    }

    protected function validasi(array $data)
    {
        $messages=[
         'required'=> ':attribute Wajib Diisi Semua!!!',
       ];
        $validator = Validator::make($data, [
            'nama' => 'required',
        ],$messages);
        return $validator;
    }

    public function save(Request $request)
    {
        $validator=$this->validasi($request->all());
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 200);
        } else {
            kategori::updateOrCreate(['id' => $request->id],$request->all());
            return response()->json(['success'=>$request->all()]);
        }
    }

    public function delete($id)
    {
        $kategori=kategori::find($id);
        $kategori->delete();
        return response()->json(['success'=>true]);
    }
}
