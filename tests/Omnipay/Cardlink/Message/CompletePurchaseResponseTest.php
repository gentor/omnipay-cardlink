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

    /**
     * This tests the provider sending back a message saying the purchase was canceled.
     */
    public function testCompletePurchaseCancel()
    {
        $msg = 'Failed, user canceled';
        $response = new CompletePurchaseResponse(
            $this->completePurchaseRequest,
            [
                'mid' => '1234',
                'orderid' => 'ABC123',
                'status' => 'CANCELED',
                'orderAmount' => '0.03',
                'currency' => 'EUR',
                'paymentTotal' => '0.03',
                'message' => $msg,
                'riskScore' => '',
                'txId' => '123456789',
                'digest' => 'gvTEdfBkqUOuHA3Dl5xEDmxNf0s=',
            ]
        );
        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isCancelled());
        $this->assertEquals($msg, $response->getMessage());
        $this->assertNull($response->getTransactionReference());
        $this->assertNull($response->getAuthCode());
    }

    /**
     * This tests the provider sending back a message saying the purchase was successful.
     */
    public function testCompletePurchaseSuccess()
    {
        $msg = 'OK, 00 - Approved';
        $txRef = '123456';
        $response = new CompletePurchaseResponse(
            $this->completePurchaseRequest,
            [
                'mid' => '1234',
                'orderid' => 'ABC123',
                'status' => 'CAPTURED',
                'orderAmount' => '0.03',
                'currency' => 'EUR',
                'paymentTotal' => '0.03',
                'message' => $msg,
                'riskScore' => '0',
                'payMethod' => 'mastercard',
                'txId' => '123456789',
                'paymentRef' => $txRef,
                'digest' => 'Svp9WX6D9ASM/0gHvWIAL1PSsC4=',
            ]
        );
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isCancelled());
        $this->assertEquals($msg, $response->getMessage());
        $this->assertEquals($txRef, $response->getTransactionReference());
        $this->assertNull($response->getAuthCode());
    }

    /**
     * This tests a hacker trying to pretend to be the provider sending back a message saying the purchase was
     * successful.
     */
    public function testCompletePurchaseInvalidDigest()
    {
        $response = new CompletePurchaseResponse(
            $this->completePurchaseRequest,
            [
                'mid' => '5678',
                'orderid' => 'DEF456',
                'status' => 'CAPTURED',
                'orderAmount' => '0.03',
                'currency' => 'EUR',
                'paymentTotal' => '0.03',
                'message' => 'OK, 00 - Approved',
                'riskScore' => '0',
                'payMethod' => 'mastercard',
                'txId' => '987654321',
                'paymentRef' => '654321',
                'digest' => 'TryingToSpoofIt=',
            ]
        );
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isCancelled());
        $this->assertEquals('Digest is not valid', $response->getMessage());
        $this->assertNull($response->getTransactionReference());
        $this->assertNull($response->getAuthCode());
    }
}