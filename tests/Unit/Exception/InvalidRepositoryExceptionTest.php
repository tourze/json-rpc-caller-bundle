<?php

namespace Tourze\JsonRPCCallerBundle\Tests\Unit\Exception;

use PHPUnit\Framework\TestCase;
use Tourze\JsonRPCCallerBundle\Exception\InvalidRepositoryException;

final class InvalidRepositoryExceptionTest extends TestCase
{
    public function testConstructorFormatsMessageCorrectly(): void
    {
        $expectedClass = 'App\Repository\ExpectedRepository';
        $actualClass = 'App\Repository\ActualRepository';
        
        $exception = new InvalidRepositoryException($expectedClass, $actualClass);
        
        $expectedMessage = sprintf(
            'Expected repository of type %s, but got %s',
            $expectedClass,
            $actualClass
        );
        
        self::assertSame($expectedMessage, $exception->getMessage());
    }
    
    public function testExceptionExtendsRuntimeException(): void
    {
        $exception = new InvalidRepositoryException('Expected', 'Actual');
        
        self::assertInstanceOf(\RuntimeException::class, $exception);
    }
}