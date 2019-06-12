<?php

namespace Supermarket\Model\Config\ApplicationConfig;

use InvalidArgumentException;

class DatabaseConfig
{
    private const PDO_DSN_TEMPLATE = 'mysql:host=%s:%d;dbname=%s';

    /**
     * @var string
     */
    private $host;

    /**
     * @var int
     */
    private $port;

    /**
     * @var string
     */
    private $dbname;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    private function __construct(string $host, int $port, string $dbname, string $username, string $password)
    {
        $this->host = $host;
        $this->port = $port;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;
    }

    public static function createFromArray(array $connection): DatabaseConfig
    {
        $data = $connection['connection'];
        foreach (['host', 'port', 'dbname', 'username', 'password'] as $key) {
            if (empty($data[$key])) {
                throw new InvalidArgumentException(sprintf('Invalid configuration for %s', $key));
            }
        }

        return new self($data['host'], $data['port'], $data['dbname'], $data['username'], $data['password']);
    }

    public function toPDOConfig(): array
    {
        return [
            sprintf(self::PDO_DSN_TEMPLATE, $this->host, $this->port, $this->dbname),
            $this->username,
            $this->password,
        ];
    }
}
