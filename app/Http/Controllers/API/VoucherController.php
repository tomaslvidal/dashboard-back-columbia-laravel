<?php

namespace Columbia\Http\Controllers\API;

use Columbia\Voucher;

use Illuminate\Http\Request;

use Columbia\Http\Resources\VoucherCollection;

use Columbia\Http\Requests\StoreVoucherAPI;

use Columbia\Http\Requests\AddUserAPI;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Input;

use Columbia\Http\Controllers\Controller;

class VoucherController extends Controller
{
    public function index()
    {
        return new VoucherCollection(Voucher::all());
    }

    public function create()
    {
        //
    }

    public function store(StoreVoucherAPI $request)
    {
        $voucher = new Voucher($request->except('file_name'));

        if(null !== $request->file('file_name')){
            $storagePath = Storage::disk('local')->put('vouchers', $request->file('file_name'));

            $storageName = basename($storagePath);

            $voucher['file_name'] = $storageName;
        }

        $voucher->save();

        return response()->json([
            'success' => true,
            'id' => $voucher->id,
            'created_at' => $voucher->created_at->toDateTimeString(),
            'message' => 'operation success.',
        ]);
    }

    public function show($id)
    {
        $voucher = Voucher::where('id', $id)->get();

        return new VoucherCollection($voucher);
    }

    public function edit($id)
    {
        //
    }

    public function update($id, StoreVoucherAPI $request)
    {
        $voucher = Voucher::find($id);

        $voucher->fill($request->except('file_name'));

        if(null !== $request->file('file_name')){
            if($voucher['file_name']!=""){
                if(Storage::disk('local')->exists("vouchers/".$voucher['file_name'])){
                    Storage::disk('local')->delete("vouchers/".$voucher['file_name']);
                }
            }

            $storagePath = Storage::disk('local')->put('vouchers', $request->file('file_name'));

            $storageName = basename($storagePath);

            $voucher['file_name'] = $storageName;

            // $voucher['file_name'] = Storage::url('vouchers/'.$storageName);

            // return Storage::download('vouchers/'.$storageName);
        }

        $voucher->save(); 
    }

    public function destroy($id, Request $request)
    {
        if($request->forceDelete!="true"){
            $voucher = Voucher::find($id);
            
            $voucher->timestamps = false;

            $voucher->delete();
        }
        else{
            $voucher = Voucher::withTrashed()->find($id);

            if(!empty($voucher['file_name'])) {
                if(Storage::disk('local')->exists("vouchers/".$voucher['file_name'])){
                    Storage::disk('local')->delete("vouchers/".$voucher['file_name']);
                }
            }

            $voucher->forceDelete();
        }
    }

    public function delete_file($id)
    {
        $voucher = Voucher::withTrashed()->find($id);

        if(!empty($voucher['file_name'])) {
            if(Storage::disk('local')->exists("vouchers/".$voucher['file_name'])){
                Storage::disk('local')->delete("vouchers/".$voucher['file_name']);

                $voucher['file_name'] = '';

            }
            else{
                $voucher['file_name'] = '';
            }

            $voucher->save(); 
        }
    }

    public function add_user($id, AddUserAPI $request)
    {
        $voucher = Voucher::find($id);

        $voucher->users()->attach($request->user_id);
    }

    public function restoring($id)
    {
        $voucher = Voucher::withTrashed()->find($id);

        $voucher->timestamps = false;

        $voucher->restore();
    }
}
