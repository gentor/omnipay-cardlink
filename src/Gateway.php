<?php

namespace Omnipay\Cardlink;

use Omnipay\Cardlink\Messages\CompletePurchaseRequest;
use Omnipay\Cardlink\Messages\PurchaseRequest;
use Omnipay\Common\AbstractGateway;

/**
 *
 */
class Gateway extends AbstractGateway
{
    const VERSION = 2;
    const TEST_ENDPOINT = 'https://alphaecommerce-test.cardlink.gr/vpos/shophandlermpi';
    const LIVE_ENDPOINT = 'https://www.alphaecommerce.gr/vpos/shophandlermpi';

    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     */
    public function getName()
    {
        return 'Cardlink';
    }

    /**
     * @return mixed
     */
    public function getEndPoint()
    {
        return $this->getParameter('endpoint') ?:
            $this->getTestMode() ? self::TEST_ENDPOINT : self::LIVE_ENDPOINT;
    }

    /**
     * @param $value
     * @return Gateway
     */
    public function setEndPoint($value)
    {
        return $this->setParameter('endpoint', $value);
    }

    /**
     * @return mixed
     */
    public function getLanguage()
    {
        return $this->getParameter('language');
    }

    /**
     * @param $value
     * @return Gateway
     */
    public function setLanguage($value)
    {
        return $this->setParameter('language', $value);
    }

    /**
     * @return mixed
     */
    public function getMerchantId()
    {
        return $this->getParameter('mid');
    }

    /**
     * @param $value
     * @return Gateway
     */
    public function setMerchantId($value)
    {
        $this->setParameter('merchantId', $value);

        return $this->setParameter('mid', $value);
    }

    /**
     * @return mixed
     */
    public function getSharedSecret()
    {
        return $this->getParameter('sharedSecret');
    }

    /**
     * @param $value
     * @return Gateway
     */
    public function setSharedSecret($value)
    {
        return $this->setParameter('sharedSecret', $value);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Cardlink\Messages\PurchaseRequest
     */
    public function purchase(array $parameters = array())
    {
        return $this->createRequest(PurchaseRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return \Omnipay\Cardlink\Messages\CompletePurchaseRequest
     */
    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest(CompletePurchaseRequest::class, $parameters);
    }

    /**
     * @return string[]
     */
    public function getDefaultParameters()
    {
        return array(
            'language' => 'en',
        );
    }
}
