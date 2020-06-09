<?php

namespace Omnipay\Cardlink;

use DigiTickets\Cardlink\lib\DigestCalculator;
use Omnipay\Tests\TestCase;

class DigestTest extends TestCase
{
    const SECRET_KEY = 'Cardlink1';

    public function testDigest()
    {
        $data = [
            'version' => 2,
            'mid' => '0101119349',
            'lang' => 'en',
            'deviceCategory' => '0',
            'orderid' => 'O170911143656',
            'orderDesc' => 'Test order some items',
            'orderAmount' => '0.12',
            'currency' => 'EUR',
            'payerEmail' => 'cardlink@cardlink.gr',
            'payerPhone' => '6900000000',
            'element' => 'GRUK',
            'payMethod' => 'visa',
            'confirmUrl' => 'https://euro.test.modirum.com/vpostestsv4/shops/shopdemo.jsp?cmd=confirm',
            'cancelUrl' => 'https://euro.test.modirum.com/vpostestsv4/shops/shopdemo.jsp?cmd=cancel',
        ];

        $expectedDigest = 'Xw19+XA5lQXbzEHvvFYe1Zrm7N+rvpdIvzuIyM9HY3Q=';

        // Try without a "digest" element.
        $this->assertEquals($expectedDigest, DigestCalculator::calculate($data, self::SECRET_KEY));

        $data['digest'] = $expectedDigest;

        // Try with a "digest" element - should get same answer.
        $this->assertEquals($expectedDigest, DigestCalculator::calculate($data, self::SECRET_KEY));
    }

    public function testDigestWithGreekChar() {

          $data = [
              'version' => 2,
              'mid' => '0101119349',
              'lang' => 'en',
              'deviceCategory' => '0',
              'orderid' => 'O170911143656',
              'orderDesc' => 'UsingGreekCharsΓ', // contains the greek character
              'orderAmount' => '0.12',
              'currency' => 'EUR',
              'payerEmail' => 'cardlink@cardlink.gr',
              'payerPhone' => '6900000000',
              'element' => 'GRUK',
              'payMethod' => 'visa',
              'confirmUrl' => 'https://euro.test.modirum.com/vpostestsv4/shops/shopdemo.jsp?cmd=confirm',
              'cancelUrl' => 'https://euro.test.modirum.com/vpostestsv4/shops/shopdemo.jsp?cmd=cancel',
          ];

        $expectedDigest = 'FUypWRVCh+Q4qdpArKME2OQZlm+anJU4iHwigY6Bp60=';

        // Try without a "digest" element.
        $this->assertEquals($expectedDigest, DigestCalculator::calculate($data, self::SECRET_KEY));

        $data['digest'] = $expectedDigest;

        // Try with a "digest" element - should get same answer.
        $this->assertEquals($expectedDigest, DigestCalculator::calculate($data, self::SECRET_KEY));

    }
}