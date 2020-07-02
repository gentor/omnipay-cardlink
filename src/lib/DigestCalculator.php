<?php

namespace DigiTickets\Cardlink\lib;

class DigestCalculator
{
    public static function calculate($data, $sharedSecret)
    {
        // This is a fairly "dumb" method, but it's in line with how the digest is supposed to be calculated.
        // First, make sure there is no digest element in the data values we're going to work on.
        unset($data['digest']);

        // Now take all the data values, join them together, append the shared secret, encode the result and that's
        // the digest!
        return base64_encode(
            hash(
                'sha256',
                implode('', $data).$sharedSecret,
                true
            )
        );
    }
}
