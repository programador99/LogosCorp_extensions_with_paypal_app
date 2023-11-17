<?php

namespace LogosCorp\Net247\Block\Checkout;

class Success extends \Magento\Checkout\Block\Success
{

    protected $session;

    /**
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Sales\Model\OrderFactory $orderFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Sales\Model\OrderFactory $orderFactory,
        array $data = array(),
        \Magento\Backend\Model\Session $session
    ) {
        parent::__construct($context, $orderFactory, $data);
        $this->session = $session;
    }

    /**
     * Retrieves Net247 voucher info
     * @return string
     */
    public function getReferenceCode()
    {
        $voucher = $this->session->getLogoscorpPaymentResultInfo();

        return ( !empty($voucher) ) ? $voucher["result_voucher"] : null;
    }
}
