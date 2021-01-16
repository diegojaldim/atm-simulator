<?php


namespace App\Http\Response;


interface ResponseMessages
{

    const USER_ALREADY_EXISTS = 'Usuário com cpf %s já existe';

    const USER_NOT_FOUND = 'Usuário não encontrado';

    const INVALID_REQUEST = 'Invalid request';

}
