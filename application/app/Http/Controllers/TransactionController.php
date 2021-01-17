<?php

namespace App\Http\Controllers;

use App\Exceptions\BanknotesException;
use App\Factory\BankAccountFactory;
use App\Http\Resources\BankAccountResource;
use App\Http\Response\ResponseMessages;
use App\Http\Response\SuccessResponse;
use App\Http\Response\ErrorResponse;
use App\Helpers\Banknotes;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;


class TransactionController extends Controller implements ResponseMessages
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

    /**
     * @param Request $request
     * @return ErrorResponse|SuccessResponse
     */
    public function bankAccount(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validateBankAccountInsert());

        if ($validator->fails()) {
            return new ErrorResponse([
                'message' => self::INVALID_REQUEST,
                'errors' => $validator->errors(),
            ]);
        }

        $bankAccountFactory = $this->bankAccountFactory->build();

        $bankAccount = BankAccount::create($bankAccountFactory);

        return new SuccessResponse(new BankAccountResource($bankAccount), JsonResponse::HTTP_CREATED);
    }

    /**
     * @return array
     */
    protected function validateBankAccountInsert()
    {
        return [
            'type' => [
                'required',
                'max:255',
                function ($attribute, $value, $fail) {
                    if (!in_array($value, BankAccountFactory::ACCOUNT_TYPE)) {
                        $fail(
                            sprintf(
                                self::ACCOUNT_BANK_INVALID_TYPE,
                                implode(' | ', BankAccountFactory::ACCOUNT_TYPE)
                            )
                        );
                    }
                }
            ],
            'bank_balance' => 'required|numeric',
        ];
    }

}
