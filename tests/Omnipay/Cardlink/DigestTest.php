<?php

namespace Omnipay\Cardlink;

use DigiTickets\Cardlink\lib\DigestCalculator;
use Omnipay\Common\CreditCard;
use Omnipay\Tests\TestCase;

class DigestTest extends TestCase
{
    public function testDigest()
    {
        $data = [
            'one' => 'one',
            'two' => 'two'
        ];

        $this->assertEquals('2PyXWhzQtfX4tLJEVHKx5C8wnQk=', DigestCalculator::calculate($data, 'xyz'));
    }
}