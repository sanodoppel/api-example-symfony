### How to build the project
In docker folder create .env file from .env.dist

In .env file set APP_PATH for application root 

In project folder run next command to build docker php containers:

    make build

    
To run containers: 

    make up

    
To go inside php container run:

    make exec-php
    
Inside container run
    
    composer install

Then generate the SSH keys

    openssl genpkey -pass pass:qwerty -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
    openssl pkey -passin pass:qwerty -in config/jwt/private.pem -out config/jwt/public.pem -pubout

    openssl genpkey -pass pass:qwerty -out config/jwt/private-test.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
    openssl pkey -passin pass:qwerty -in config/jwt/private-test.pem -out config/jwt/public-test.pem -pubout

Run migrations and fixtures

    php bin/console doctrine:migrations:migrate --no-interaction
    php bin/console doctrine:fixtures:load --no-interaction

Application is available at http://localhost

### Endpoint for jwt token generation
    
    curl -X POST -H "Content-Type: application/json" http://localhost/api/auth -d '{"username":"test","password":"test"}'

For authorization, add a header to requests: 

    Authorization: Bearer <generated token>