<?php

namespace DigiTickets\Cardlink\lib;

class DigestCalculator
{
    public static function calculate(array $data, string $sharedSecret)
    {
        // This is a fairly "dumb" method, but it's in line with how the digest is supposed to be calculated.
        // First, make sure there is no digest element in the data values we're going to work on.
        unset($data['digest']);

        // Now take all the data values, join them together, append the shared secret, encode the result and that's
        // the digest!
        $digestData = implode('', $data).$sharedSecret;
        $digest = base64_encode(sha1(utf8_encode($digestData), true));

        return $digest;
    }
}