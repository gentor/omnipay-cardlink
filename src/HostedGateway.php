<?php

namespace DigiTickets\Cardlink;

use DigiTickets\Cardlink\Messages\CompletePurchaseRequest;
use DigiTickets\Cardlink\Messages\PurchaseRequest;
use Omnipay\Common\AbstractGateway;

class HostedGateway extends AbstractGateway
{
    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     */
    public function getName()
    {
        return 'Cardlink (hosted)';
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest(PurchaseRequest::class, $parameters);
    }

    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest(CompletePurchaseRequest::class, $parameters);
    }

    public function getDefaultParameters()
    {
        return array(
            'merchantId'  => '',
            'sharedSecret' => '',
            'language' => 'en',
        );
    }
}
