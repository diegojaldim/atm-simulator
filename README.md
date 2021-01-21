
# ATM Simulator API

Simulador de Caixa Eletrônico com as seguintes funcionalidades:

- CRUD de usuários;
- Realização de saques, depósitos e abertura de contas;

Para mais informações e detalhes dos endpoints, consultar o seguinte link:
[<img src="https://stoplight.io/favicons/favicon.ico" width="20">Stoplight | Documentação da API](https://djaldim.stoplight.io/docs/atm-simulator/reference/Collection.v1.yaml)

O projeto foi desenvolvido com:
- [Lumen 8.0](https://lumen.laravel.com/docs/8.x)
- [PHP 7.3](https://www.php.net/)
- [MySQL 8.0](https://www.mysql.com/)
- [Docker](https://www.docker.com/)

---

#### Requisitos:
- docker-compose >= 3.1

#### Instalação:
Clonar o repositório e subir os containers com o seguinte comando:
``` 
docker-compose up --build
``` 

Com os containers funcionando, entrar no container 'atm-simulator-php-fpm' e rodar os seguintes comandos:
``` 
cp .env.example .env 
```
Após copiar o arquivo ".env", inserir host e usuário do banco de dados


Instalação de dependências:
```
composer install 
```

Migrations:
```
php artisan migrate 
```
