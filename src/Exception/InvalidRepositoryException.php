<?php

namespace Tourze\JsonRPCCallerBundle\Exception;

class InvalidRepositoryException extends \RuntimeException
{
    public function __construct(string $expectedClass, string $actualClass)
    {
        parent::__construct(sprintf(
            'Expected repository of type %s, but got %s',
            $expectedClass,
            $actualClass
        ));
    }
}