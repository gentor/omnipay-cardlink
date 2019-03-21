<?php

namespace DigiTickets\Cardlink\Messages;

use Omnipay\Common\Message\AbstractResponse;

class PurchaseResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        // @TODO: Implement isSuccessful() method.
        return false; // @TODO: for now
    }
}