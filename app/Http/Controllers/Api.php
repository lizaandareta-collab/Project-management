<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Api extends Controller
{
    public function getMasterData()
    {
        // QUERY FIXED (sesuai permintaan)
        $query = "
           SELECT a.NPK, a.NAME
            FROM euclid.masterdata a
            WHERE a.TERMINATION IS NULL
            AND a.DIV_NAME = '4W ALLOY ENGINEERING'
            ORDER BY a.NAME
        ";

        // PAYLOAD KE API
        $payload = [
            'db'     => 'euclid',
            'table'  => 'euclid.masterdata',
            'column' => 'id',
            'param'  => 'select',
            'query'  => $query,
            'datas'  => '',
            'rowres' => 'result',
        ];

        $url = 'http://192.168.10.49/40-api/Apiaio/aiocrud';

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($url, $payload);

            return response()->json([
                'status' => true,
                'query'  => $query,
                'data'   => $response->json()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error'  => $e->getMessage()
            ]);
        }
    }
}
