<?php

namespace App\Http\Response;

use Illuminate\Http\JsonResponse;

class SuccessResponse extends JsonResponse
{

    /**
     * SuccessResponse constructor.
     * @param null $data
     * @param int $status
     * @param array $headers
     * @param int $options
     */
    public function __construct($data = null, $status = 200, array $headers = [], $options = 0)
    {
        $data = [
            'data' => $data,
            'success' => true,
        ];

        parent::__construct($data, $status, $headers, $options);
    }

}