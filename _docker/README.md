## Configure hosts
```
sudo vim /etc/hosts
#add line
192.100.10.20 flaconi.develop www.flaconi.develop
```



## Configure application


## URLs
PHPMyAdmin: `http://localhost:8080/`
Site: `http://flaconi.develop/`


## Working inside docker
Login into `php` machine with `docker exec -i -t flaconi_php bash`

Docker usage:
```php composer.phar install```
```php composer.phar require nelmio/api-doc-bundle```

## Working outside docker

Warning!!! You should work inside `php` docker machine. Working outside can make permissions problems.


## Useful commands
```
docker exec -i -t flaconi_php bash
docker exec -i -t flaconi_web bash
```

```
docker-compose -f "docker-compose.yml" down
docker-compose -f "docker-compose.yml" up
```

Installing package with composer
```
sudo docker run --rm -v $(pwd)/application:/app composer install
sudo docker run --rm -v $(pwd)/application:/app composer require symfony/yaml
```

Updating PHP dependencies with composer
```
sudo docker run --rm -v $(pwd)/web/app:/app composer update
```

Generating PHP API documentation
```
sudo docker-compose exec -T php ./app/vendor/bin/apigen generate app/src --destination ./app/doc
```

Testing PHP application with PHPUnit
```
sudo docker-compose exec -T php ./app/vendor/bin/phpunit --colors=always --configuration ./app/
```

Checking the standard code with PSR2
```
sudo docker-compose exec -T php ./app/vendor/bin/phpcs -v --standard=PSR2 ./app/src
```

Checking installed PHP extensions
```
sudo docker-compose exec php php -m
```

Listining docker images & containers
```
docker image ls -a
docker container ls -a
```

Removing docker images & containers
```
docker kill $(docker ps -q)
docker rm $(docker ps -aq) -f
docker rmi $(docker images -q) -f
```


## Useful links

 * https://stackoverflow.com/questions/35845144/how-can-i-create-a-mysql-db-with-docker-compose
 * https://github.com/nanoninja/docker-nginx-php-mysql
 * http://mikehillyer.com/articles/managing-hierarchical-data-in-mysql/
 * https://cswr.github.io/JsonSchema/spec/basic_types/
 * https://www.sgalinski.de/typo3-agentur/technik/how-to-create-a-basic-rest-api-in-symfony/
 * https://swagger.io/specification/#parameterObject
 * http://zircote.com/swagger-php/1.x/annotations.html
 * https://github.com/OAI/OpenAPI-Specification/blob/master/versions/2.0.md
 * http://williamdurand.fr/2014/02/14/please-do-not-patch-like-an-idiot/
 * http://williamdurand.fr/2012/08/02/rest-apis-with-symfony2-the-right-way/
 * https://spacetelescope.github.io/understanding-json-schema/reference/generic.html
 * https://phpunit.readthedocs.io/en/latest/assertions.html
 * http://behat-api-extension.readthedocs.io/en/latest/guide/verify-server-response.html#id16