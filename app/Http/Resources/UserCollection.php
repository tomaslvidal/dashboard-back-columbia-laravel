<?php

namespace Columbia\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $users = collect([]);

        foreach ($this->collection as $user){
            $vouchers = $user->vouchers()->get();

            // foreach ($vouchers as $key => $voucher){
            //     $created_at = $vouchers[$key]['pivot']['created_at'];

            //     $vouchers[$key]['pivot_created_at'] = $created_at;

            //     unset($vouchers[$key]['pivot']);
            // }

            $user->vouchers = $vouchers;

            $users->push($user);
        }

        return $users;
    }
}
