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
        // @TODO: Get all the data for these fields.
        $data = [
            'mid' => '1234567890',
            'lang' => 'en',
            'deviceCategory' => '0',
            'orderid' => 'XXXXXXXX',
            'orderDesc' => 'Dev test',
            'orderAmount' => '0.05',
            'currency' => 'EUR',
            'payerEmail' => 'someone@example.com',
            'payerPhone' => '01234 112233',
            'billCountry' => 'GB',
            'billState' => 'Here',
            'billZip' => 'AA1 1AA',
            'billCity' => 'Metropolis',
            'billAddress' => 'Gotham',
            'reject3dsU' => 'Y',
            'payMethod' => '',
            'trType' => '1',
            'confirmUrl' => 'success',
            'cancelUrl' => 'cancel',
        ];
        // @TODO: Get the shared secret from the purchase request, which in turn gets it from the config.
        $data['digest'] = $this->determineDigest($data, 'MySecret');

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