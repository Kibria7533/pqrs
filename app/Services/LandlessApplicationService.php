<?php

namespace App\Services;
use App\Helpers\Classes\FileHandler;
use App\Models\LandlessUser;
use App\Models\Role;
use App\Models\UserType;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Landless\App\Models\Landless;
use Modules\Landless\App\Models\LandlessApplicationAttachment;

class LandlessApplicationService
{
    public function createLandless(array $data)
    {
        $role = Role::where('code', 'landless')->first();

        $LandlessUserData = [
            'user_type_id' => UserType::USER_TYPE_LANDLESS_USER_CODE,
            'role_id' => $role->id,
            'name' => $data['fullname'],
            'gender' => $data['gender'],
            'mobile' => $data['mobile'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),//todo
            'profile_pic' => 'users/default.png',
        ];

        try {
            DB::beginTransaction();
            if(!(LandlessUser::where('email', $data['email'])->first())){
                LandlessUser::create($LandlessUserData);
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
        }
    }

    public function validator(Request $request, $id=null): Validator
    {
        $rules = [
            'fullname' => 'required|string|max: 191',
            'password' => 'required|string|max: 191',
            'mobile' => [
                'required',
                'string',
                'max: 20',
                'regex:/(^((?:\+88|88)?(01[3-9]\d{8}))$)|(^((\x{09EE}\x{09EE})|(\+\x{09EE}\x{09EE}))?[\x{09E6}-\x{09EF}]{11})$/u',
            ],
            'email' => 'nullable|string|max:191|email',
            'gender' => 'required|int',
            'status' => 'nullable|int',
        ];

        return \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
    }

    /**
     * Generate Application Number
     **/
    private function applicationNumberGenerate(): string
    {
        $lastApplicationNumber = Landless::whereNotNull('application_number')->orderBy('application_number', 'desc')->first();

        if (!empty($lastApplicationNumber)) {
            $number = $lastApplicationNumber->application_number;
            return str_pad($number + 1, 8, "0", STR_PAD_LEFT);
        } else {
            return '00000001';
        }
    }

}
