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

-Passo 4: Rodar o comando para subir os containers (./vendor/bin/sail up)