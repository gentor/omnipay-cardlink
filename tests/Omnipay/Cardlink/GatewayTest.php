<?php

namespace Omnipay\Cardlink;

use DigiTickets\Cardlink\HostedGateway;
use DigiTickets\Cardlink\Messages\PurchaseResponse;
use Omnipay\Common\CreditCard;
use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->gateway = new HostedGateway($this->getHttpClient(), $this->getHttpRequest());

        $this->options = array(
            'mid' => '1234',
            'sharedSecret' => 'nottellingyou',
            'currency' => 'EUR',
            'amount' => '10.00',
            'transactionId' => '123456',
            'returnUrl' => 'https://www.example.com/return',
            'cancelUrl' => 'https://www.example.com/cancel',
        );
    }

    public function testPurchase()
    {
        $response = $this->gateway->purchase($this->options)->send();

        $this->assertInstanceOf(PurchaseResponse::class, $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
    }
}