<?php

namespace Columbia\Rules;

use Columbia\UserVoucher;

use Illuminate\Contracts\Validation\Rule;

class UniqueUserVoucher implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $reason;

    private $user_id;

    private $voucher_id;

    public function __construct($user_id, $voucher_id)
    {
        $this->user_id = $user_id;

        $this->voucher_id = $voucher_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user_voucher = UserVoucher::where([
            "user_id" => $this->user_id,
            "voucher_id" => $this->voucher_id
        ])->count();

        if($user_voucher==1){
            $this->reason = "El user_voucher ya existe";

            return false;
        }
        elseif($user_voucher>1){
            $this->reason = "¿?";
        }
        else{
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->reason;
    }
}
