<?php

namespace Tests\Chargemap\OCPI\Common\Server;

use Chargemap\OCPI\Common\Server\OcpiListingResponse;
use Chargemap\OCPI\Common\Server\StatusCodes\OcpiSuccessHttpCode;
use Chargemap\OCPI\Versions\V2_1_1\Server\Emsp\Tokens\Get\OcpiEmspTokenGetRequest;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class OcpiListingResponseTest extends TestCase
{
    public function testShouldConstructCorrectly()
    {
        $request = new OcpiEmspTokenGetRequest(
            Psr17FactoryDiscovery::findRequestFactory()->createRequest('GET', '/test?offset=10&limit=10')
                ->withHeader('Authorization', 'Token PLOPPLOP')
        );

        $mock = $this->getMockBuilder(OcpiListingResponse::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $reflectedClass = new ReflectionClass(OcpiListingResponse::class);
        $constructor = $reflectedClass->getConstructor();
        $constructor->invoke($mock, $request, 45, 10, 'Message!');
        $mock->method('getData')->willReturn(null);

        /** @var OcpiListingResponse $mock */
        $this->assertEquals('Message!', $mock->jsonSerialize()['status_message']);
        $responseInterface = $mock->getResponseInterface();

        $this->assertEquals(OcpiSuccessHttpCode::HTTP_OK, $responseInterface->getStatusCode());
        $this->assertEquals('/test?offset=20&limit=10', $responseInterface->getHeader('Link')[0]);
        $this->assertEquals(45, $responseInterface->getHeader('X-Total-Count')[0]);
        $this->assertEquals(10, $responseInterface->getHeader('X-Limit')[0]);
    }
}
