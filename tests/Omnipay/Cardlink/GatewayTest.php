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
        $card = $this->options['card'];
        $this->assertEquals($card->getEmail(), $redirectData['payerEmail']);
        $this->assertEquals($card->getBillingPhone(), $redirectData['payerPhone']);
        $this->assertEquals($card->getBillingCountry(), $redirectData['billCountry']);
        $this->assertEquals($card->getBillingState(), $redirectData['billState']);
        $this->assertEquals($card->getBillingPostcode(), $redirectData['billZip']);
        $this->assertEquals($card->getBillingCity(), $redirectData['billCity']);
        $this->assertEquals($card->getBillingAddress1(), $redirectData['billAddress']);
    }
}