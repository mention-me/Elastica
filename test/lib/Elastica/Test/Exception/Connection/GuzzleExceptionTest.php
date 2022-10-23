<?php
namespace Elastica\Test\Exception\Connection;

use Elastica\Test\Exception\AbstractExceptionTest;
use GuzzleHttp\Client;

class GuzzleExceptionTest extends AbstractExceptionTest
{
    public static function setUpBeforeClass(): void
    {
        if (!class_exists(Client::class)) {
            self::markTestSkipped('guzzlehttp/guzzle package should be installed to run guzzle transport tests');
        }
    }
}
