<?php

namespace DigiTickets\Cardlink\Messages;

class CompletePurchaseRequest extends PurchaseRequest
{
    public function getData()
    {
        // Simply return the posted values.
        return $this->httpRequest->request->all();
    }

    public function sendData($data)
    {
        return $this->response = new CompletePurchaseResponse($this, $data);
    }
}
