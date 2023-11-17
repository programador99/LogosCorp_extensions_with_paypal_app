<?php

namespace LogosCorp\StoreLocator\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;
use Magento\Framework\View\Element\Template\Context;
use LogosCorp\StoreLocator\Block\StoreLocator;

class StoresWidget extends Template implements BlockInterface
{
    /**
     * @var StoreLocator
     */
    public $_storeLocator;    

    /**
     * @var Context
     * @var StoreLocator 
    */
    public function __construct(
        StoreLocator $storeLocator,
        Context $context,
        $data = []
    ) {
        $this->_storeLocator = $storeLocator;
        parent::__construct($context, $data);
    }

    /**
     * @var string
     */
    protected $_template = "widget/stores.phtml";
}