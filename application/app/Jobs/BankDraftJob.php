<?php

namespace App\Jobs;

use App\Models\BankAccount;


class BankDraftJob extends Job
{

    /**
     * @var BankAccount
     */
    protected $bankAccount;

    /**
     * BankDepositJob constructor.
     * @param BankAccount $bankAccount
     */
    public function __construct(BankAccount $bankAccount)
    {
        $this->bankAccount = $bankAccount;
    }

    /**
     * Execute the job
     *
     * @return BankAccount
     */
    public function handle()
    {
        $this->bankAccount->save();

        return $this->bankAccount;
    }

}
