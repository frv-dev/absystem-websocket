# ABSYSTEM

## Tools:

- Docker & docker-compose
- Messagepack
- Laravel
- ZeroMQ
- PHP

## Proposta:

Desenvoler um sistema A & B que se comuniquem com socket do tipo bidirecional.

A ideia é criar uma aplicação A, sistema principal, que tem o registro de produtos de uma loja e realiza a compra e venda deles, e o sistema B, que conecta com o sistema de pagamento.

O sistema A usará InertiaJS.

O sistema B usará PHP puro com Swoole.

## INSTALL:

- Entre no projeto `store`;
- Execute `make build`;
- Execute `make install` ou `pwd=$PWD make install`;
- Execute `make start`.

No arquivo `.env` coloque os seguintes dados para o banco de dados:

```env
DB_CONNECTION=pgsql
DB_HOST=postgres
DB_DATABASE=store
DB_USERNAME=felps
DB_PASSWORD=postgres
DB_SCHEMA=public
```

- Entre no projeto `payment`;
- Execute `docker run -it -v $PWD:/var/www felpspdi02 bash -c "composer install && php artisan key:generate"`;
- Crie o arquivo `.env` e preencha com os dados necessários;
- Execute `docker compose up`.

## START:

No projeto `payment` rode o comando `docker composer up` para iniciá-lo.

No projeto `store` rode o comando `make shell-container`, depois `php artisan db:seed --class=TestDataSeeder` e depois `php app:process-payment`, toda a vez que algo na tabela `payments` surgir com o `status = pending` ele irá se comunicar com o outro projeto por websocket.
