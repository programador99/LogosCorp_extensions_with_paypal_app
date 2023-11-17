<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace LogosCorp\Net247\Block\Form;

/**
 * @api
 * @since 100.0.2
 */
class CcExtended extends \Magento\Payment\Block\Form\Cc
{
    /**
     * @var string
     */
    protected $_template = 'LogosCorp_Net247::form/cc.phtml';

    /**
     * Payment config model
     *
     * @var \Magento\Payment\Model\Config
     */
    protected $_paymentConfig;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Payment\Model\Config $paymentConfig
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Payment\Model\Config $paymentConfig,
        array $data = []
    ) {
        parent::__construct($context, $paymentConfig, $data);
        $this->_paymentConfig = $paymentConfig;
    }
}
