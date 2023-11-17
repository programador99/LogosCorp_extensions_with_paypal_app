<?php

namespace LogosCorp\CustomAddToCart\Model;

use LogosCorp\CustomAddToCart\Api\InventoryStockInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\InventorySales\Model\ResourceModel\GetAssignedStockIdForWebsite;
use Magento\InventorySales\Model\GetProductSalableQty;

class InventoryStock implements InventoryStockInterface {
  

    public function __construct(
        StoreManagerInterface $storeManager,
        GetAssignedStockIdForWebsite $getAssignedStockIdForWebsite,
        GetProductSalableQty $getProductSalableQty
    ){
        $this->_getProductSalableQty = $getProductSalableQty;
        $this->_storeManager = $storeManager;
        $this->_getAssignedStockIdForWebsite = $getAssignedStockIdForWebsite;
        $this->_currentStock=$this->getStockFromCurrentWebSite();
    }

    public function getStockFromCurrentWebSite()
    {
        $websiteCode = $this->_storeManager->getStore()->getWebsite()->getCode();
        return  $this->_getAssignedStockIdForWebsite->execute($websiteCode);
    }


    /**
     * Returns Inventory Stock of Product
     *
     * @api
     * @param string $productSku
     * @return array
     */
    public function get($sku)
    {
        $result = [
            'error'=>null,
            'stock'=>null,
            'success'=>false
        ];
        
        try {
            $result['success']=true;
            $result['stock']=$this->_getProductSalableQty->execute($sku,strval($this->_currentStock));    
        } catch (\Throwable $th) {
            $result['error']=$th->getMessage();
        }
        return [$result];
    }
}