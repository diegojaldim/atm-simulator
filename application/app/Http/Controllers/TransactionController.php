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
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Jobs\BankDepositJob;


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
    public function bankDeposit(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validateBankAccountRequest());

        if ($validator->fails()) {
            return new ErrorResponse([
                'message' => self::INVALID_REQUEST,
                'errors' => $validator->errors(),
            ]);
        }

        $bankAccountModel = BankAccount::getByUserAndType(
            $request->user->id,
            $request->input('type')
        );

        if (!$bankAccountModel instanceof BankAccount) {
            return new ErrorResponse(self::ACCOUNT_BANK_NOT_FOUND, JsonResponse::HTTP_NOT_FOUND);
        }

        $bankAccountModel->bank_balance += $request->input('bank_balance');

        $bankAccount = $this->dispatchNow(new BankDepositJob($bankAccountModel));

        return new SuccessResponse(new BankAccountResource($bankAccount));
    }

    /**
     * @param Request $request
     * @return ErrorResponse|SuccessResponse
     */
    public function bankAccount(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validateBankAccountRequest());

        if ($validator->fails()) {
            return new ErrorResponse([
                'message' => self::INVALID_REQUEST,
                'errors' => $validator->errors(),
            ]);
        }

        $bankAccountFactory = $this->bankAccountFactory->build();

        try {
            $bankAccount = BankAccount::create($bankAccountFactory);
        } catch (QueryException $e) {
            return new ErrorResponse(
                sprintf(self::ACCOUNT_BANK_ALREADY_EXISTS, $bankAccountFactory['type']),
                JsonResponse::HTTP_CONFLICT
            );
        }

        return new SuccessResponse(new BankAccountResource($bankAccount), JsonResponse::HTTP_CREATED);
    }

    /**
     * @return array
     */
    protected function validateBankAccountRequest()
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
