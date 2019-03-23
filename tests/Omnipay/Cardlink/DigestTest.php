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

        $this->assertEquals('123456', DigestCalculator::calculate($data, 'xyz'));
    }
}