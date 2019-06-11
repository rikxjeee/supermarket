<?php

namespace Supermarket\Datastore;

use Exception;

class DatabaseCredentials
{
    /**
     * @return array
     * @throws Exception
     */
    public function getCredentials(): array
    {
        if (!file_exists('./src/Datastore/Config.php')){
            throw new Exception('configuration missing');
        }

        $config = require 'Config.php';

        if (!isset($config['db']['connection'])){
            throw new Exception('db connection configuration missing');
        }

        $credentials = $config['db']['connection'];
        $credentials = DatabaseCredentials::createFromArray($credentials);

        return $credentials;
    }

    public static function createFromArray(array $array): array
    {
        $credentials[] = 'mysql:host='.$array['host'].':'.$array['port'].';dbname='.$array['dbname'];
        $credentials[] = $array['username'];
        $credentials[] = $array['password'];

        return $credentials;
    }
}
