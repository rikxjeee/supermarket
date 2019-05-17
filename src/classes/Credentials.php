<?php


namespace Load\classes;


class Credentials
{
    private const DB_SERVER = 'mysql:host=localhost:9999;dbname=supermarket';
    private const DB_USER = 'root';
    private const DB_PASSWORD ='simple';



    public function getCredentials(): array
    {
        $credentials[] = self::DB_SERVER;
        $credentials[] = self::DB_USER;
        $credentials[] = self::DB_PASSWORD;

        return $credentials;

    }
}