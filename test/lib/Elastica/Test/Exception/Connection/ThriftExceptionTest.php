<?php
namespace Elastica\Test\Exception\Connection;

use Elastica\Test\Exception\AbstractExceptionTest;
use Elasticsearch\RestClient;

class ThriftExceptionTest extends AbstractExceptionTest
{
    public static function setUpBeforeClass(): void
    {
        if (!class_exists(RestClient::class)) {
            self::markTestSkipped('munkie/elasticsearch-thrift-php package should be installed to run thrift exception tests');
        }
    }
}
