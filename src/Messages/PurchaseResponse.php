<?php

namespace DigiTickets\Cardlink\Messages;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    public function isSuccessful()
    {
        return false;
    }

    public function isRedirect()
    {
        return true;
    }

    public function getRedirectUrl()
    {
        // @TODO: This depends on whether it's a live or test transaction.
        return 'https://euro.test.modirum.com/vpos/shophandlermpi';
    }

    public function getRedirectMethod()
    {
        return 'POST';
    }

    public function getRedirectData()
    {
        // Build the initial data set.
        // We then calculate the digest and add it to the set.
        /**
         * @var PurchaseRequest $request
         */
        $request = $this->getRequest();
        $data = [
            'mid' => $request->getMerchantId(),
            'lang' => $request->getLanguage(),
            'orderid' => $request->getTransactionId(),
            'orderAmount' => $request->getAmount(),
            'currency' => $request->getCurrency(),
            'payerEmail' => $request->getCard()->getEmail(),
            'payerPhone' => $request->getCard()->getBillingPhone(),
            'billCountry' => $request->getCard()->getBillingCountry(),
            'billState' => $request->getCard()->getBillingState(),
            'billZip' => $request->getCard()->getBillingPostcode(),
            'billCity' => $request->getCard()->getBillingCity(),
            'billAddress' => $request->getCard()->getBillingAddress1(),
            'trType' => '1',
            'confirmUrl' => $request->getReturnUrl(),
            'cancelUrl' => $request->getCancelUrl(),
        ];
        $data['digest'] = $this->determineDigest($data, $request->getSharedSecret());

        return $data;
    }

    private function determineDigest($data, $sharedSecret)
    {
        // This is a fairly "dumb" method, but it's in line with how the digest is supposed to be calculated.
        // Take all the data values, join them together, append the shared secret, obfuscate the result and that's
        // the digest.
        $digestData = implode('', $data).$sharedSecret;
        $digest = base64_encode(sha1(utf8_encode($digestData), true));

        return $digest;
    }
}