<?php

namespace Omnipay\Cardlink;

use DigiTickets\Cardlink\HostedGateway;
use Omnipay\Common\CreditCard;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->gateway = new HostedGateway($this->getHttpClient(), $this->getHttpRequest());

        $this->options = array(
            'merchantId' => '1234',
            'sharedSecret' => 'nottellingyou',
            'currency' => 'EUR',
            'amount' => '10.00',
            'transactionId' => '123456',
            'returnUrl' => 'https://www.example.com/return',
            'cancelUrl' => 'https://www.example.com/cancel',
            'card' => new CreditCard(array(
                'email' => 'payer@example.com',
                'billingPhone' => '012233 445566',
                'billingCountry' => 'UK',
                'billingState' => 'AZ',
                'billingPostcode' => 'XX12 3YY',
                'billingCity' => 'Metropolis',
                'billingAddress1' => '10, High Street',
            )),
        );
    }

    public function testMandatoryParameters()
    {
        // Loop through the options, and for each one, clone the options and remove that one from the clone, then
        // try to create a purchase request.
        foreach ($this->options as $removeOption) {
            $testOptions = $this->options;
            unset($testOptions[$removeOption]);
            // We have to check that it does throw an exception, and therefore doesn't
            // go the "assert true is false" line.
            try {
                $this->gateway->purchase($testOptions)->send();
                $this->assertTrue(false, 'Missing "'.$removeOption.'" should throw an exception in send');
            } catch(InvalidRequestException $e) {
                $this->assertTrue(true);
            }
        }
    }

    public function testPurchase()
    {
        $response = $this->gateway->purchase($this->options)->send();

        $this->assertInstanceOf('\DigiTickets\Cardlink\Messages\PurchaseResponse', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertEquals('POST', $response->getRedirectMethod());

        // Check the redirect data values.
        $redirectData = $response->getRedirectData();
        $this->assertEquals($this->options['merchantId'], $redirectData['mid']);
        $this->assertEquals($this->options['transactionId'], $redirectData['orderid']);
        $this->assertEquals($this->options['amount'], $redirectData['orderAmount']);
        $this->assertEquals($this->options['currency'], $redirectData['currency']);
        $this->assertEquals('1', $redirectData['trType']);
        $this->assertEquals($this->options['returnUrl'], $redirectData['confirmUrl']);
        $this->assertEquals($this->options['cancelUrl'], $redirectData['cancelUrl']);
        $this->assertEquals($this->options->getCard()->getEmail(), $redirectData['payerEmail']);
        $this->assertEquals($this->options->getCard()->getBillingPhone(), $redirectData['payerPhone']);
        $this->assertEquals($this->options->getCard()->getBillingCountry(), $redirectData['billCountry']);
        $this->assertEquals($this->options->getCard()->getBillingState(), $redirectData['billState']);
        $this->assertEquals($this->options->getCard()->getBillingPostcode(), $redirectData['billZip']);
        $this->assertEquals($this->options->getCard()->getBillingCity(), $redirectData['billCity']);
        $this->assertEquals($this->options->getCard()->getBillingAddress1(), $redirectData['billAddress']);
    }
}