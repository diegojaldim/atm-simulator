<?php


namespace App\Http\Response;


interface ResponseMessages
{

    const USER_ALREADY_EXISTS = 'Usuário com cpf %s já existe';

    const USER_NOT_FOUND = 'Usuário não encontrado';

    const INVALID_REQUEST = 'Invalid request';

    const X_API_USER_ID_NOT_FOUND = 'Header x-api-user-id não encontrado';

    const ACCOUNT_BANK_INVALID_TYPE = 'A conta deve ser %s';

    const ACCOUNT_BANK_ALREADY_EXISTS = 'O usuário já possui conta %s';


}
