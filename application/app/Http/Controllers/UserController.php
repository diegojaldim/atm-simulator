<?php

namespace App\Http\Controllers;


use App\Factory\UserFactory;
use App\Http\Response\ErrorResponse;
use App\Http\Response\ResponseMessages;
use App\Http\Response\SuccessResponse;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\UserResource;


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

    public function get(Request $request)
    {
        if ($request->id) {
            $user = User::find($request->id);

            if (empty($user)) {
                return new ErrorResponse(self::USER_NOT_FOUND, JsonResponse::HTTP_NOT_FOUND);
            }

            return new UserResource($user);
        }

        return UserResource::collection(User::all());
    }

    public function post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'document' => 'required',
            'birthday' => 'required|date_format:d/m/Y',
        ]);

        if ($validator->fails()) {
            return new ErrorResponse([
                'message' => self::INVALID_REQUEST,
                'errors' => $validator->errors(),
            ]);
        }

        $userFactory = $this->userFactory->build();

        try {
            $user = User::create($userFactory);
        } catch (QueryException $e) {
            return new ErrorResponse(
                sprintf(self::USER_ALREADY_EXISTS, $userFactory['document']),
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
