<?php

namespace App\Http\Controllers;

use App\Exceptions\BanknotesException;
use App\Factory\BankAccountFactory;
use App\Http\Resources\BankAccountResource;
use App\Http\Response\SuccessResponse;
use App\Http\Response\ErrorResponse;
use App\Helpers\Banknotes;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;


class TransactionController extends Controller
{

    /** @var BankAccountFactory */
    protected $bankAccountFactory;

    public function __construct(BankAccountFactory $bankAccountFactory)
    {
        $this->bankAccountFactory = $bankAccountFactory;
    }

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

    public function bankAccount(Request $request)
    {
        $bankAccountFactory = $this->bankAccountFactory->build();

        $bankAccount = BankAccount::create($bankAccountFactory);

        return new SuccessResponse(new BankAccountResource($bankAccount), JsonResponse::HTTP_CREATED);
    }

}
