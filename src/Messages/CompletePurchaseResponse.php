<?php

namespace DigiTickets\Cardlink\Messages;

use Omnipay\Common\Message\AbstractResponse;

class CompletePurchaseResponse extends AbstractResponse
{
    // Possible statuses
    const STATUS_AUTHORIZED = 'AUTHORIZED';
    const STATUS_CAPTURED = 'CAPTURED';
    const STATUS_CANCELED = 'CANCELED';
    const STATUS_REFUSED = 'REFUSED';
    const STATUS_ERROR = 'ERROR';

    public function isSuccessful()
    {
        return isset($this->data['status']) &&
            (self::STATUS_AUTHORIZED === $this->data['status'] || self::STATUS_CAPTURED === $this->data['status']);
    }

    public function isCancelled()
    {
        return isset($this->data['status']) && self::STATUS_CANCELED !== $this->data['status'];
    }

    public function getTransactionReference()
    {
        return isset($this->data['paymentRef']) ? $this->data['paymentRef'] : null;
    }

    public function getMessage()
    {
        return isset($this->data['message']) ? $this->data['message'] : null;
    }

    public function getAuthCode()
    {
        return isset($this->data['authCode']) ? $this->data['authCode'] : null;
    }
}
