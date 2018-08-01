<?php

namespace Columbia\Http\Controllers;

use Columbia\Voucher;

use Illuminate\Http\Request;

use Columbia\Http\Resources\VoucherCollection;

use Columbia\Http\Requests\StoreVoucherAPI;

use Columbia\Http\Requests\AddUserAPI;

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
        $voucher = Voucher::create($request->all());
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

        $voucher->update($request->all());
    }

    public function destroy($id)
    {
        $voucher = Voucher::find($id);

        $voucher->delete();
    }

    public function add_user($id, AddUserAPI $request)
    {
        $voucher = Voucher::find($id);

        $voucher->users()->attach($request->user_id);
    }
}
