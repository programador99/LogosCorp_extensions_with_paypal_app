<?php

namespace LogosCorp\StoreLocator\Model;

/**
 * Class Settings
 * @package Logoscorp\ZohoIntegration\Model
 */
class Settings
{
    

    // GENERAL SETTINGS
    const CONFIG_STORE_LOCATOR_LATITUD = 'general/store_information/latitud';
    const CONFIG_STORE_LOCATOR_LONGITUD = 'general/store_information/longitud';
    const CONFIG_STORE_LOCATOR_INCLUDE = 'general/store_information/include_in_storelocator';


    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;


    /**
     * Settings constructor.
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\App\Config\Storage\WriterInterface $configWriter
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\App\Config\Storage\WriterInterface $configWriter
    ) {
        $this->_scopeConfig = $scopeConfig;
        $this->_configWriter = $configWriter;
    }
    

    /**
    * @param $path = 'extension_name/general/data'
    * @param $value = '1'
    */
    // public function setDataConfig($path, $value) {
    //     $this->_configWriter->save($path, $value, $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeId = 0);
    // }


    /*
    * @return CONFIG_STORE_LOCATOR_LATITUD
    */
    public function getConfigStoreLocatorLatitud($scopeCode)
    {
        return $this->_scopeConfig->getValue(self::CONFIG_STORE_LOCATOR_LATITUD, \Magento\Store\Model\ScopeInterface::SCOPE_WEBSITE,  $scopeCode);
    }

    /*
    * @return CONFIG_STORE_LOCATOR_LONGITUD
    */
    public function getConfigStoreLocatorLongitud($scopeCode)
    {
        return $this->_scopeConfig->getValue(self::CONFIG_STORE_LOCATOR_LONGITUD, \Magento\Store\Model\ScopeInterface::SCOPE_WEBSITE, $scopeCode);
    } 

    /*
    * @return CONFIG_STORE_LOCATOR_INCLUDE
    */
    public function getConfigStoreLocatorInclude($scopeCode)
    {
        return $this->_scopeConfig->getValue(self::CONFIG_STORE_LOCATOR_INCLUDE, \Magento\Store\Model\ScopeInterface::SCOPE_WEBSITE, $scopeCode);
    } 
    
}