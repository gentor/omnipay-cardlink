<?php

namespace Omnipay\Cardlink\Messages;

use Omnipay\Cardlink\Gateway;
use Omnipay\Cardlink\lib\DigestCalculator;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\ResponseInterface;

class PurchaseRequest extends AbstractRequest
{
    public function getMerchantId()
    {
        return $this->getParameter('mid');
    }

    public function setMerchantId($value)
    {
        // This is so that we can test whether this parameter has been supplied, but output a friendly name
        // ("merchantId) to the outside world, instead of the internal name ("mid"). See the call to validate() in
        // getData() below.
        $this->setParameter('merchantId', $value);

        return $this->setParameter('mid', $value);
    }

    public function getSharedSecret()
    {
        return $this->getParameter('sharedSecret');
    }

    public function setSharedSecret($value)
    {
        return $this->setParameter('sharedSecret', $value);
    }

    /**
     * @return mixed
     */
    public function getEndPoint()
    {
        return $this->getParameter('endpoint') ?:
            $this->getTestMode() ? Gateway::TEST_ENDPOINT : Gateway::LIVE_ENDPOINT;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setEndPoint($value)
    {
        return $this->setParameter('endpoint', $value);
    }

    public function getLanguage()
    {
        return $this->getParameter('language');
    }

    public function setLanguage($value)
    {
        return $this->setParameter('language', $value);
    }

    public function getData()
    {
        // Check that the essential data values are present.
        $this->validate(
            'merchantId',
            'sharedSecret',
            'transactionId',
            'amount',
            'currency',
            'returnUrl',
            'cancelUrl',
            'card',
        );

        $data = [
            'version' => Gateway::VERSION,
            'mid' => $this->getMerchantId(),
            'lang' => $this->getLanguage(),
            'orderid' => $this->getTransactionId(),
            'orderDesc' => $this->getDescription() ?: $this->getTransactionId(),
            'orderAmount' => $this->getAmount(),
            'currency' => $this->getCurrency(),
            'payerEmail' => $this->getCard()->getEmail(),
            'payerPhone' => $this->getCard()->getBillingPhone(),
            'billCountry' => $this->getCard()->getBillingCountry(),
            'billState' => $this->getCard()->getBillingState(),
            'billZip' => $this->getCard()->getBillingPostcode(),
            'billCity' => $this->getCard()->getBillingCity(),
            'billAddress' => $this->getCard()->getBillingAddress1(),
            'trType' => '1',
            'confirmUrl' => $this->getReturnUrl(),
            'cancelUrl' => $this->getCancelUrl(),
        ];
        $data['digest'] = DigestCalculator::calculate($data, $this->getSharedSecret());

        return $data;
    }

    public function sendData($data)
    {
        return $this->response = new PurchaseResponse($this, $data);
    }
}
