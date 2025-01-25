<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KalkulatorController extends Controller
{
    public function index()
    {
        return view('kalkulator');
    }

    public function convert(Request $request)
    {
        $number = $request->input('number');
        $fromBase = (int) $request->input('from_base');

        if (!preg_match("/^[0-9A-Fa-f]+$/", $number)) {
            return response()->json([
                'error' => 'Input tidak valid untuk basis awal.',
            ], 400);
        }

        try {
            $decimalValue = base_convert($number, $fromBase, 10);

            $results = [
                'binary' => base_convert($decimalValue, 10, 2),
                'octal' => base_convert($decimalValue, 10, 8),
                'decimal' => $decimalValue,
                'hexadecimal' => strtoupper(base_convert($decimalValue, 10, 16)),
            ];
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan konversi.',
            ], 500);
        }

        return response()->json([
            'input' => $number,
            'from' => $fromBase,
            'results' => $results,
        ]);
    }
}
