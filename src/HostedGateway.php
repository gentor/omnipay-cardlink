<?php

namespace DigiTickets\Cardlink;

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

    public function getLanguage()
    {
        return $this->getParameter('language');
    }

    public function setLanguage($value)
    {
        return $this->setParameter('language', $value);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\DigiTickets\Cardlink\Messages\PurchaseRequest', $parameters);
    }

    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('DigiTickets\Cardlink\Messages\CompletePurchaseRequest', $parameters);
    }

    public function getDefaultParameters()
    {
        return array(
            'language' => 'en',
        );
    }
}
