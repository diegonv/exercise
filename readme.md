#Setup
Installation form scratch using Laradoc & docker ( if I had more time I ll not use laradoc, I ll made a docker hub mirror to have more security in the docker images )

Install laradoc:

$ git clone https://github.com/Laradock/laradock.git
$ cd laradock
$ cp ../exercise/.laradocsenv .env
$ cp ../exercise/my.cnf mysql/my.cnf

In laradocs .env:
DOCKER_HOST_IP=127.0.0.1

docker-compose up -d nginx mysql phpmyadmin

Configure mysql:

$ docker-compose exec mysql bash
root@c9525b8e5105:/# mysql -u root -p

mysql> ALTER USER 'default'@'%' IDENTIFIED WITH mysql_native_password BY 'secret';

mysql> create database exercise;

If I had more time I ll use something to manage the secrets. ( like Vault )

Phpmyadmin:
http://localhost:8081

##Database Seed:
- docker-compose exec workspace bash
- php artisan migrate:refresh --seed

I prefer API first design that include made the API specs, Apib or openapi and then build 2 apps, 1 for the API and other for frontend, or even micro services.

 
Code coverage report
/exercise/build/coverage-report/dashboard.html

I use larvel auth and this repo to test it https://github.com/DCzajkowski/auth-tests/tree/5.6.2

I remove password reset from auth

With more time i ll change the auth service to laravel passport and vue.js in the frontend

- docker-compose exec workspace bash
- npm run watch

Use https://github.com/laracasts/flash for alerts

Default user:
admin@admin.com
Pass admin

#Next steps:
 - Form Validation
 - Users ABM
 - Frontend test with Mocha and vue-test-utils