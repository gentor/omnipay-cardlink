<?php

namespace Omnipay\Cardlink\Messages;

use Omnipay\Cardlink\lib\DigestCalculator;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;

class CompletePurchaseResponse extends AbstractResponse
{
    // Possible statuses
    const STATUS_AUTHORIZED = 'AUTHORIZED';
    const STATUS_CAPTURED = 'CAPTURED';
    const STATUS_CANCELED = 'CANCELED';
    const STATUS_REFUSED = 'REFUSED';
    const STATUS_ERROR = 'ERROR';

    /**
     * @var bool $digestIsValid
     */
    private $digestIsValid = false;

    public function __construct(RequestInterface $request, $data)
    {
        // TODO: Fix this
        unset($data['query_trace']);

        parent::__construct($request, $data);

        // Determine whether the digest is valid.
        /**
         * @var CompletePurchaseRequest $request
         */

        $digest = DigestCalculator::calculate($data, $request->getSharedSecret());
        $this->digestIsValid = isset($data['digest']) && $data['digest'] == $digest;
    }

    public function isSuccessful()
    {
        return $this->digestIsValid && isset($this->data['status']) &&
            (self::STATUS_AUTHORIZED === $this->data['status'] || self::STATUS_CAPTURED === $this->data['status']);
    }

    public function isCancelled()
    {
        return $this->digestIsValid && isset($this->data['status']) && self::STATUS_CANCELED === $this->data['status'];
    }

    public function getTransactionReference()
    {
        return $this->digestIsValid && isset($this->data['paymentRef']) ?
            $this->data['paymentRef'] : $this->data['txId'] ?? null;
    }

    public function getMessage()
    {
        return $this->digestIsValid
            ?
            (isset($this->data['message']) ? $this->data['message'] : null)
            :
            'Digest is not valid';
    }

    public function getAuthCode()
    {
        return null;
    }
}
