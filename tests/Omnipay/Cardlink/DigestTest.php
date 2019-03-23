<?php

namespace Omnipay\Cardlink;

use DigiTickets\Cardlink\lib\DigestCalculator;
use Omnipay\Common\CreditCard;
use Omnipay\Tests\GatewayTestCase;

class DigestTest extends GatewayTestCase
{
    public function testDigest()
    {
        $data = [
            'one' => 'one',
            'two' => 'two'
        ];

        $this->assertEquals('123456', DigestCalculator::calculate($data, 'xyz'));
    }
}