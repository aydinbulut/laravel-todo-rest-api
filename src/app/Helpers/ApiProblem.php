<?php

namespace App\Helpers;

class ApiProblem
{
    public const TYPE_VALIDATION_ERROR = 'validation_error';
    public const TYPE_NOT_FOUND_ERROR = 'not_found_error';
    public const TYPE_SERVER_ERROR = 'server_error';

    public static $titles = [
        self::TYPE_VALIDATION_ERROR => 'There was a validation error',
        self::TYPE_NOT_FOUND_ERROR => 'The resource not found',
        self::TYPE_SERVER_ERROR => 'An error occurred during the process',
    ];

    /** @var int */
    private $statusCode;

    /** @var string */
    private $type;

    /** @var string */
    private $title;

    /** @var array */
    private $data = [];

    /**
     * ApiProblem constructor.
     *
     * @param int $statusCode
     * @param string $type
     * @throws \Exception
     */
    public function __construct(int $statusCode, string $type)
    {
        $this->statusCode = $statusCode;
        $this->type = $type;

        if (!isset(self::$titles[$type])) {
            throw new \Exception(sprintf("Api problem type '%s' not found", $type));
        }

        $this->title = self::$titles[$type];
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     * @return void
     */
    public function setStatusCode($statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
        $this->title = self::$titles[$type];
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function addData(string $key, $value): void
    {
        $this->data[$key] = $value;
    }

    /**
     * @param string $key
     * @return false|mixed
     */
    public function getData(string $key)
    {
        return $this->data[$key] ?? false;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_merge(
            [
                'status' => $this->statusCode,
                'type' => $this->type,
                'title' => $this->title,
            ],
            $this->data
        );
    }
}

