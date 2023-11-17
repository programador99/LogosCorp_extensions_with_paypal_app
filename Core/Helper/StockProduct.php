<?php

/**
 * Code Example and Explanation MSI
 * https://magento.stackexchange.com/questions/266697/magento-2-3-how-to-fetch-stock-statuses-of-all-the-stores        
 */
 namespace LogosCorp\Core\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\InventorySales\Model\ResourceModel\GetAssignedStockIdForWebsite;
use Magento\InventorySales\Model\GetProductSalableQty;

class StockProduct extends \Magento\Framework\App\Helper\AbstractHelper
{

    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        GetAssignedStockIdForWebsite $getAssignedStockIdForWebsite,
        GetProductSalableQty $getProductSalableQty
    )
    {
        $this->_getProductSalableQty = $getProductSalableQty;
        $this->_storeManager = $storeManager;
        $this->_getAssignedStockIdForWebsite = $getAssignedStockIdForWebsite;
        $this->_currentStock=$this->getStockFromCurrentWebSite();
        parent::__construct($context);
    }

    public function getStockFromCurrentWebSite()
    {
        $websiteCode = $this->_storeManager->getStore()->getWebsite()->getCode();
        return  $this->_getAssignedStockIdForWebsite->execute($websiteCode);
    }


    public function getProductSalableQty($sku)
    {
        return $this->_getProductSalableQty->execute($sku,strval($this->_currentStock));
    }

}