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
        $expectedDigest = '2PyXWhzQtfX4tLJEVHKx5C8wnQk=';

        // Try without a "digest" element.
        $this->assertEquals($expectedDigest, DigestCalculator::calculate($data, 'xyz'));

        $data['digest'] = $expectedDigest;

        // Try with a "digest" element - should get same answer.
        $this->assertEquals($expectedDigest, DigestCalculator::calculate($data, 'xyz'));
    }
}