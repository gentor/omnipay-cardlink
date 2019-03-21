<?php

namespace DigiTickets\Cardlink\Messages;

use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\ResponseInterface;

class PurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        // @TODO: Implement getData() method.
    }

    public function sendData($data)
    {
        // @TODO: Implement sendData() method.
        $responseTBC = null;
        return $this->response = new PurchaseResponse($this, $responseTBC);
    }
}