<?php

namespace Omnipay\Cardlink\Messages;

use Omnipay\Cardlink\lib\DigestCalculator;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    const TEST_ENDPOINT = 'https://euro.test.modirum.com/vpos/shophandlermpi';
    const LIVE_ENDPOINT = 'https://vpos.eurocommerce.gr/vpos/shophandlermpi';
    const VERSION = 2;

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
        // The URL depends on whether it's a live or test transaction.
        /**
         * @var PurchaseRequest $request
         */
        $request = $this->getRequest();

        return $request->getTestMode() ? self::TEST_ENDPOINT : self::LIVE_ENDPOINT;
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
            'version' => self::VERSION,
            'mid' => $request->getMerchantId(),
            'lang' => $request->getLanguage(),
            'orderid' => $request->getTransactionId(),
            'orderDesc' =>  $request->getTransactionId(),
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
        $data['digest'] = DigestCalculator::calculate($data, $request->getSharedSecret());

        return $data;
    }
}
