<?php

namespace App\Http\Controllers;


use App\Exceptions\BanknotesException;
use App\Http\Response\SuccessResponse;
use App\Http\Response\ErrorResponse;
use App\Helpers\Banknotes;


class TransactionController extends Controller
{

    public function withdraw()
    {
        $value = 20;

        try {
            $banknotes = Banknotes::calculator($value);

            return new SuccessResponse([
                'value' => $value,
                'banknotes' => $banknotes,
            ]);

        } catch (BanknotesException $e) {
            return new ErrorResponse([
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);
        } catch (\Exception $e) {
            return new ErrorResponse($e->getMessage());
        }

    }

}
