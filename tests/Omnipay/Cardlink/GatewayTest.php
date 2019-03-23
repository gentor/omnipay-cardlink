<?php

namespace Omnipay\Cardlink;

use DigiTickets\Cardlink\HostedGateway;
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
            'returnUrl' => 'https://www.example.com/return',
            'transactionId' => '123456',
            'returnUrl' => 'https://www.example.com/return',
            'cancelUrl' => 'https://www.example.com/cancel',
        );
    }

}