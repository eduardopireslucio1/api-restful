Para utilizar a api, deve-se seguir os seguintes passos:
Passo 1: Clonar o repositorio com git clone https://github.com/eduardopireslucio1/api-restful

Passo 2: Entrar no diretório do projeto (cd api-restful)

Passo 3: No diretório do projeto instale as dependências do composer com os seguintes comandos
docker run --rm \
-u "$(id -u):$(id -g)" \
-v "$(pwd):/var/www/html" \
-w /var/www/html \
laravelsail/php82-composer:latest \
composer install --ignore-platform-reqs

Passo 4: Renomear arquivo .env.exemplo para .env

Passo 5: Configurar variáveis de ambiente:
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=testing
DB_USERNAME=sail
DB_PASSWORD=password

-Passo 6: Rodar o comando para subir os containers (./vendor/bin/sail up)

-Pronto agora está tudo certo para utilizar a API-LiberFly
-Lembrando que para utilizar os endpoints, terá que adicionar os Headers Acceppt(application/json) e Content-Type(application/json).

-A API terá endpoint para registrar um usuário (/api/liberfly/register)
-Endpoint para realizar o login (/api/liberfly/login)
-Endpoint "ME" para retornar o usuário autenticado (/api/liberfly/me)

-Dentre a funcionalidade da api, terá cadastro de cliente relacionado com usuário, ou seja, somente o usuário que cadastrar o cliente
poderá visualiza-lo, edita-lo, e excluí-lo.
Métodos de cliente:
create, getById, getAll, update, delete.

Para acessar a documentação: localhost/api/documentation

Para rodar os testes de integração basta rodar o comando: ./vendor/bin/sail php artisan test
