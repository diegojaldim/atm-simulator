<?php


class UserTest extends TestCase
{

    public function testGet()
    {
        $this->json('GET', '/v1/user')
            ->seeJson([
                'id' => '1000',
                'name' => 'User Test',
                'birthday' => '1969-01-01',
                'document' => '62522547976',
                'success' => true,
            ]);
    }

}
