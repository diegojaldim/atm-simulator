<?php

use App\Models\User;
use \Laravel\Lumen\Testing\DatabaseTransactions;

class TransactionsTest extends TestCase
{

     use DatabaseTransactions;

    /**
     * @const array
     */
    const REQUEST = [
        'poupanca' => [
            'type' => 'poupanca',
            'bank_balance' => 100,
        ],
        'corrente' => [
            'type' => 'corrente',
            'bank_balance' => 100,
        ],
    ];

    public function testBankAccountOpen()
    {
        $user = User::factory()->make();
        $response = $this->post('/v1/user', $user->toArray())->seeJson(['success' => true]);
        $userId = $response->response->getData()->data->id;
        $header = ['x-api-user-id' => $userId];

        $this->json('POST', '/v1/transactions/bank-account', self::REQUEST['poupanca'], $header)->seeJson(['success' => true]);
        $this->json('PATCH', '/v1/transactions/bank-deposit', self::REQUEST['poupanca'], $header)->seeJson(['success' => true]);
        $this->json('PATCH', '/v1/transactions/bank-draft', self::REQUEST['poupanca'], $header)->seeJson(['success' => true]);

        $this->json('POST', '/v1/transactions/bank-account', self::REQUEST['corrente'], $header)->seeJson(['success' => true]);
        $this->json('PATCH', '/v1/transactions/bank-deposit', self::REQUEST['corrente'], $header)->seeJson(['success' => true]);
        $this->json('PATCH', '/v1/transactions/bank-draft', self::REQUEST['corrente'], $header)->seeJson(['success' => true]);
    }

}