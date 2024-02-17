<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

if (file_exists(dirname(__DIR__).'/config/bootstrap.php')) {
    require dirname(__DIR__).'/config/bootstrap.php';
} elseif (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
}

if (file_exists(dirname(__DIR__).'/var/test.db')) {
    shell_exec('rm ' . dirname(__DIR__) . '/var/test.db');
}
shell_exec('php ' .dirname(__DIR__). '/bin/console doctrine:database:create --env=test --quiet');
shell_exec('php ' .dirname(__DIR__). '/bin/console doctrine:schema:create --env=test --quiet');
shell_exec('php ' .dirname(__DIR__). '/bin/console doctrine:fixtures:load --env=test --quiet');
