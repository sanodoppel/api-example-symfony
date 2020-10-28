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

To start local web server run next command inside container:
    
    symfony server:start
    
Url for browser: http://10.5.0.2:8000/    

### How to run migrations and fixtures
    php bin/console doctrine:migrations:migrate
    php bin/console doctrine:fixtures:load
    

### How to generate the SSH keys

    openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
    openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
    
    openssl genrsa -out config/jwt/private-test.pem -aes256 4096
    openssl rsa -pubout -in config/jwt/private-test.pem -out config/jwt/public-test.pem
### Test endpoint for jwt token generation
    
    curl -X POST -H "Content-Type: application/json" http://10.5.0.2:8000/api/login_check -d '{"username":"test","password":"test"}'

