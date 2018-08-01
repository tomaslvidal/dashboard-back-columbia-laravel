<?php

namespace Columbia\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class VoucherCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $vouchers = collect([]);

        foreach ($this->collection as $voucher){
            $users = $voucher->users()->get();

            $voucher->users = $users;

            $vouchers->push($voucher);
        }

        return $vouchers;
    }
}
