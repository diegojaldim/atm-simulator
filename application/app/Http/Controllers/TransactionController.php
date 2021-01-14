<?php

namespace App\Http\Controllers;


use Illuminate\Http\JsonResponse;
use App\Helpers\Banknotes;


class TransactionController extends Controller
{

    public function withdraw()
    {
        $banknotes = Banknotes::calculator(150);


        return new JsonResponse([
            'value' => 150,
            'banknotes' => [
                100, 50
            ]
        ]);
    }

}
