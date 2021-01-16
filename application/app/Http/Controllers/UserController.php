<?php

namespace App\Http\Controllers;


use App\Factory\UserFactory;
use App\Http\Response\ErrorResponse;
use App\Http\Response\ResponseMessages;
use App\Http\Response\SuccessResponse;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use App\Models\User;

class UserController implements ResponseMessages
{

    /**
     * @var UserFactory
     */
    protected $userFactory;

    /**
     * UserController constructor.
     * @param UserFactory $userFactory
     */
    public function __construct(UserFactory $userFactory)
    {
        $this->userFactory = $userFactory;
    }

    public function get()
    {

    }

    public function post()
    {
        $request = $this->userFactory->build();

        try {
            $user = User::create($request);
        } catch (QueryException $e) {
            return new ErrorResponse(
                sprintf(self::USER_ALREADY_EXISTS, $request['document']),
                JsonResponse::HTTP_CONFLICT
            );
        }

        return new SuccessResponse($user->toArray(), JsonResponse::HTTP_CREATED);
    }

    public function put()
    {

    }

    public function delete()
    {

    }

}
