<?php

namespace Omnipay\Cardlink\Messages;

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
            'cancelUrl'
        );

        return null; // There isn't any data!
    }

    public function sendData($data)
    {
        return $this->response = new PurchaseResponse($this, $data);
    }
}
