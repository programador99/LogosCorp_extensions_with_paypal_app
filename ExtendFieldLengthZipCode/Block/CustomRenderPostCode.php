<?php

namespace LogosCorp\ExtendFieldLengthZipCode\Block;
use LogosCorp\ExtendFieldLengthZipCode\Model\Config\Source\PostcodesOptions;
use \Magento\Store\Model\ScopeInterface;

class CustomRenderPostCode extends \Magento\Framework\View\Element\Template
{

    protected $_postcodesOptions;
    protected $_scopeConfig;

    protected $_pathConfig = 'logoscorp_custom_render_postcode/general_settings/';

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context, 
        PostcodesOptions $postcodesOptions,
        array $data = array())
    {
        parent::__construct($context, $data);
        $this->_postcodesOptions=$postcodesOptions;
        $this->_scopeConfig     = $context->getScopeConfig();
    }

    public function isEnable(){
        $path=$this->_pathConfig.'enable';
        $scope = ScopeInterface::SCOPE_STORE;
        return $this->_scopeConfig->getValue($path, $scope)=="1";
    }

    public function applyInCheckoutFormShipping(){
        $path=$this->_pathConfig.'apply_in_form_shiping';
        $scope = ScopeInterface::SCOPE_STORE;
        return $this->_scopeConfig->getValue($path, $scope)=="1";
    }

    public function applyInCheckoutFormBilling(){
        $path=$this->_pathConfig.'apply_in_form_billing';
        $scope = ScopeInterface::SCOPE_STORE;
        return $this->_scopeConfig->getValue($path, $scope)=="1";
    }

    public function getNameLabelField(){
        $path=$this->_pathConfig.'label_field';
        $scope = ScopeInterface::SCOPE_STORE;
        return $this->_scopeConfig->getValue($path, $scope);
    }

    

    
    public function getLocations()
    {
        $scope = ScopeInterface::SCOPE_STORE;
        $listPostCodes= $this->_postcodesOptions->getAllOptions(true);
        $countriesIdentified=[];
        foreach ($listPostCodes as $postCode) {
            if(isset($postCode['country_id'])){
                $countriesIdentified[$postCode['country_id']]='';
            }
        }
        return [
            'listPostCodes'=>$listPostCodes,
            'countriesIdentified'=>array_keys($countriesIdentified)
        ];
    }
}