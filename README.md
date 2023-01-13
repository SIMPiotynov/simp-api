# simp-api

## Install project dependencies
```composer install```

## Env config
Don't forget to overwrite your .env file

## Run docker stack
```docker-compose up```

## Update database schema 
if database is not created : ```php bin/console doctrine:schema:create```
```php bin/console doctrine:schema:update -f```

