<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Mauth extends Model
{

    public static function checkUser($npk)
    {
        try {
            
            $user = DB::connection('oracle')
                ->table('users')
                ->select('id', 'name', 'npk', 'role_id', 'password', 'reset_pass')
                ->where('npk', $npk)
                ->first();

            if ($user) {
                return (array) $user;
            } else {
                return null;
            }
        } catch (\Exception $p) {
            return [
                'error' => $p->getMessage()
            ];
        }
    }
}
