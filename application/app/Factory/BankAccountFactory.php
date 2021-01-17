<?php


namespace App\Factory;

use Illuminate\Http\Request;

class BankAccountFactory
{

    /**
     * @var Request $request
     */
    protected $request;

    /**
     * UserFactory constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return array
     */
    public function build()
    {
        $user = $this->request->user;

        $account = [
            'user_id' => $user->id,
            'type' => $this->request->input('type'),
            'bank_balance' => $this->request->input('bank_balance'),
        ];

        return $account;
    }

}