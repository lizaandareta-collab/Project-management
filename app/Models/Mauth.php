<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Mauth extends Model
{
    protected $table = 'users';

    public static function checkUser($npk)
    {
        try {
            $user = DB::table('users')
                ->select('id', 'name', 'npk', 'role_id', 'password', 'reset_pass')
                ->where('npk', $npk)
                ->first();

            return $user ? (array) $user : null;

        } catch (\Exception $p) {
            return [
                'error' => $p->getMessage()
            ];
        }
    }
}