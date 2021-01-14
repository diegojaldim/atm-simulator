<?php

namespace App\Http\Response;


use Illuminate\Http\JsonResponse;

class ErrorResponse extends JsonResponse
{

    /**
     * SuccessResponse constructor.
     * @param null $data
     * @param int $status
     * @param array $headers
     * @param int $options
     */
    public function __construct($data = null, $status = 400, array $headers = [], $options = 0)
    {
        $data = [
            'data' => $data,
            'success' => false,
        ];

        parent::__construct($data, $status, $headers, $options);
    }

}