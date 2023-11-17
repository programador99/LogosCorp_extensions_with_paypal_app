<?php

namespace LogosCorp\CustomPaymentsMethod\Model;

/**
 * Pay In Store payment method model
 */
class CustomPaymentMethod3 extends \Magento\Payment\Model\Method\AbstractMethod
{

    /**
     * Payment code
     *
     * @var string
     */

    const PAYMENT_METHOD_CODE3 = 'custompaymentsmethod3';
    protected $_code           = self::PAYMENT_METHOD_CODE3;

    /**
     * Availability option
     *
     * @var bool
     */
    protected $_isOffline    = true;
    protected $_canAuthorize = true;

    /**
     * Instructions block path
     *
     * @var string
     */
    protected $_infoBlockType = \LogosCorp\CustomPaymentsMethod\Block\Info\Instructions::class;

    public function getInstructions()
    {
        return trim( $this->getConfigData( 'instructions' ) );
    }

}
