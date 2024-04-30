Fiz esse projeto para praticar PHP, Nginx, Docker, PostgreSQL, Slim Framework, RabbitMQ, PHPUnit e Elasticsearch. 
A ideia é criar uma api simples para gerenciar posts utilizando todos esses recursos.

O Readme está incompleto!

Para subir os containers, basta rodar o comando `docker-compose up --build` na raiz do projeto.

Para entrar no container do postgres, basta rodar o comando `docker exec -it posts-api-ecosystem-db-1 bash` no terminal.

Para usar a cli no container do banco de dados, basta rodar o comando `psql -U postgres -d posts` no terminal do container do banco de dados.

Para criar o banco de dados e a tabela, basta rodar os seguintes comandos no terminal do container do banco de dados:
```sql
CREATE DATABASE events;

```
O Nginx estará disponível em `http://localhost:8080` 

O RabbitMQ estará disponível em  `http://localhost:15672`. user = guest, password = guest

O Kibana estará disponível em `http://localhost:5601`. user = elastic, password = changeme

Para testar os endpoints, você pode usar o arquivo api.http que está na raiz do projeto com a extensão REST Client do VSCode.

Endpoints:
- GET /api/posts
- GET /api/posts/{id}
- POST /api/posts
- PUT /api/posts/{id}
- DELETE /api/posts/{id}

Observações: 
- Os testes unitários ainda não estão prontos. Mas pretendo fazer com PHPUnit.
- A documentação da api ainda não está pronta. Mas pretendo fazer com Swagger.
- Ainda não fiz injecção de dependência. Mas pretendo fazer com PHP-DI.
