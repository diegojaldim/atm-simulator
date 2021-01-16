<?php


namespace App\Factory;

use Illuminate\Http\Request;
use App\Helpers\Formatters;

class UserFactory
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
        $user = [
            'name' => $this->request->input('name'),
            'birthday' => Formatters::date2db($this->request->input('birthday')),
            'document' => Formatters::onlyNumber($this->request->input('document')),
        ];

        return $user;
    }

}