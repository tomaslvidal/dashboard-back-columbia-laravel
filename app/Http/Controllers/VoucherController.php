<?php

namespace Columbia\Http\Controllers\API;

use Columbia\Voucher;

use Illuminate\Http\Request;

use Columbia\Http\Resources\VoucherCollection;

use Columbia\Http\Requests\StoreVoucherAPI;

use Columbia\Http\Requests\AddUserAPI;

use Illuminate\Support\Facades\Storage;

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
        $voucher = new Voucher($request->except('fileName'));

        if(null !== $request->file('fileName')){
            $storagePath = Storage::disk('local')->put('vouchers', $request->file('fileName'));

            $storageName = basename($storagePath);

            $voucher['fileName'] = $storageName;
        }

        $voucher->save();
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

        $voucher->fill($request->except('fileName'));

        if(null !== $request->file('fileName')){
            if(Storage::disk('local')->exists("vouchers/".$voucher['fileName'])){
                Storage::disk('local')->delete("vouchers/".$voucher['fileName']);
            }

            $storagePath = Storage::disk('local')->put('vouchers', $request->file('fileName'));

            $storageName = basename($storagePath);

            $voucher['fileName'] = $storageName;
        }

        $voucher->save(); 
    }

    public function destroy($id)
    {
        $voucher = Voucher::find($id);

        // for ($i=1; $i <= 5; $i++){
        //     if(!empty($voucher['fileName'])) {
        //         if(Storage::disk('local')->exists("vouchers/".$voucher['fileName'])){
        //             Storage::disk('local')->delete("vouchers/".$voucher['fileName']);
        //         }
        //     }
        // }
        
        $voucher->timestamps = false;

        $voucher->delete();
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
