<?php

namespace LogosCorp\StoreLocator\Helper;

use \Magento\Customer\Model\SessionFactory;
use \Magento\Store\Model\StoreManagerInterface;
use \Magento\Framework\App\ResourceConnection;
use \Magento\Store\Model\ScopeInterface;
use \Magento\Framework\App\Helper\Context;
use \Magento\Framework\View\LayoutFactory;

class CustomRenderQuotes extends \Magento\Framework\App\Helper\AbstractHelper
{

    /**
     * @var SessionFactory
    */
    protected $_sessionFactory;

    /**
     * @var SessionFactory
    */
    protected $_resourceConnection;

    /**
     * @var StoreManagerInterface 
     */
    private $_storeManager;

    /**
     * @var ScopeInterface 
     */
    protected $_scopeConfig;

    /**
     * @var LayoutFactory 
     */
    protected $_layoutFactory;

    /**
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     * @param ResourceConnection $resourceConnection
     * @param SessionFactory $sessionFactory
     * @param LayoutFactory $layoutFactory
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        SessionFactory $sessionFactory,
        ResourceConnection $resourceConnection,
        LayoutFactory $layoutFactory
        
    ) {
        $this->_scopeConfig         = $context->getScopeConfig();
        $this->_storeManager        = $storeManager;
        $this->_sessionFactory      = $sessionFactory;
        $this->_resourceConnection  = $resourceConnection;
        $this->_layoutFactory       = $layoutFactory;
        parent::__construct($context);
    }

    private function getCustomerInSession(){
        $result=null;
        try {
            $result=$this->_sessionFactory->create()->getCustomerData()->getId();
        } catch (\Throwable $th) {
            //throw $th;
        }
        return $result;
    }

    private function getAllQuotes($customerId)
    {
        $quotes=[];
        try {

            $connection = $this->_resourceConnection->getConnection();
            
            $sql="
            select  sw.name, q.items_count, q.items_qty ,q.store_id, sw.website_id  from quote q 
            join store s on q.store_id=s.store_id
            join store_website sw on s.website_id=sw.website_id 
            where q.is_active = 1 and customer_id=".$customerId;
            $result = $connection->fetchAll($sql); 
            foreach ($result as  $row) {
                $quotes[]=[
                    'itemsCount'=>intval($row['items_count']),
                    'itemsQty'=>intval($row['items_qty']),
                    'storeId'=>intval($row['store_id']),
                    'webSiteName'=>$row['name'],
                    'websiteId'=>intval($row['website_id']),
                ];
            }
        
        } catch (\Throwable $th) {
        }
        return $quotes;
    }

    public function getInfoQuotes(){
        $customerId=$this->getCustomerInSession();
        $filteredQuotes=[];
        $websiteId = $this->_storeManager->getStore()->getWebsiteId();
        if(!is_null($customerId)){
            $quotes=$this->getAllQuotes($customerId);

            foreach ($quotes as $key => $data) {
                
                $typeStore=$this->getTypeStoreByWebSiteId($data['websiteId']);
                /*
                    typeStore defined in StoreLocator/Model/Adminhtml/System/Config/Source/TypeStore.php
                */
                if($typeStore!='2' && intval($websiteId)!=$data['websiteId']){
                    $quoteTmp=$data;
                    $quoteTmp['websiteIdUrl']=$this->_storeManager->getStore($data['storeId'])->getBaseUrl('web', true);
                    $quoteTmp['iconCart']=($typeStore=='3')?'hat':'default';
                    $filteredQuotes[]=$quoteTmp;
                }
            }
        }
        return $filteredQuotes;
    }

    private function getTypeStoreByWebSiteId($websiteId)
    {
        $path = "general/store_information/type_store";
        $scope = ScopeInterface::SCOPE_WEBSITE;
        return $this->_scopeConfig->getValue($path, $scope,$websiteId);
    }

    private function getCurrentTypeStore()
    {
        $path = "general/store_information/type_store";
        $scope = ScopeInterface::SCOPE_WEBSITE;
        return $this->_scopeConfig->getValue($path, $scope);
    }

    public function showStorelocator(){
        $curentTypeStore=$this->getCurrentTypeStore();
        return ($curentTypeStore=='1' || $curentTypeStore=='2');
    }

  

    public function getCartsToRender()
    {
        $infoQuotes=$this->getInfoQuotes();
        if(count($infoQuotes)>0){
            $layout = $this->_layoutFactory->create();
            $blockOption = $layout->createBlock("Magento\Framework\View\Element\Template")
            ->setTemplate("LogosCorp_StoreLocator::custom_render_carts_in_header.phtml")
            ->setData('infoQuotes', $this->getInfoQuotes())
            ;
            return $blockOption->toHtml();
        }else{
            return '';
        }
       
    }
    
}