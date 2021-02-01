### Postman

link collection: https://www.getpostman.com/collections/cb85dc95ff451fb14bf3

### Docker e migrations

```sh
$ docker-composer up -d
$ docker exec -it container_walter composer install -d /var/www/html
$ docker exec -it container_walter service apache2 start
$ docker exec -it container_walter php /var/www/html/artisan migrate
```

### Link para o projeto

http://localhost:800/public


### .env

Criar arquivo .env e copiar arquivo .env.example

