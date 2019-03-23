<?php

namespace Omnipay\Cardlink\Message;

use DigiTickets\Cardlink\HostedGateway;
use DigiTickets\Cardlink\Messages\CompletePurchaseRequest;
use DigiTickets\Cardlink\Messages\CompletePurchaseResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Tests\TestCase;

class CompletePurchaseResponseTest extends TestCase
{
    /**
     * @var RequestInterface|CompletePurchaseRequest
     */
    private $completePurchaseRequest;

    public function setUp()
    {
        parent::setUp();

        $gateway = new HostedGateway($this->getHttpClient(), $this->getHttpRequest());
        $this->completePurchaseRequest = $gateway->completePurchase([]);
    }

    public function testCompletePurchaseCancel()
    {
        $response = new CompletePurchaseResponse(
            $this->completePurchaseRequest,
            [
                'mid' => '1234',
                'orderid' => 'ABC123',
                'status' => 'CANCELED',
                'orderAmount' => '0.03',
                'currency' => 'EUR',
                'paymentTotal' => '0.03',
                'message' => 'Failed, user canceled',
                'riskScore' => '',
                'txId' => '123456789',
                'digest' => 'JKBvM8/ABTOX9SvMVYZAQqOUyyw=',
            ]
        );
        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isCancelled());
    }
}