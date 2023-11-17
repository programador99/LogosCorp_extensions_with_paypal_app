<?php

namespace LogosCorp\Net247\Model;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Store\Model\ScopeInterface;

final class ConfigProvider extends AbstractHelper implements ConfigProviderInterface
{
    const CODE = Payment::CODE;    

    protected $_currencyCodeFactory = null;

    public function __construct(
        \LogosCorp\Net247\Helper\Data $_netHelper,
        \LogosCorp\Net247\Model\CurrencyCodeFactory $currencyCodeFactory,
        \Magento\Framework\App\Helper\Context $context
    ){ 
        parent::__construct($context);
        $this->netHelper = $_netHelper;
        $this->_currencyCodeFactory = $currencyCodeFactory;
    }
        
    public function getPaymentInstructions($code)
    {
        return $this->scopeConfig->getValue("payment/".$code."/instructions", ScopeInterface::SCOPE_STORE);
    }

    public function getPaymentCms($code)
    {
        return $this->scopeConfig->getValue("payment/".$code."/cms", ScopeInterface::SCOPE_STORE);
    }

    public function getCurrencyCode()
    {
        return $this->_currencyCodeFactory
        ->create()
        ->getCollection()
        ->setOrder('name', 'ASC')
        ->getData();
    }

    public function getConfig()
    {
        $instructions = $this->getPaymentInstructions( self::CODE );

        $cms = $this->getPaymentCms( self::CODE );

        $currencys = array_map(function ($element) {
            return [
                'value'     => $element['currency_id'],
                'currency'  => $element['currency_id'].' - '.$element['name']
            ];
        }, $this->getCurrencyCode());

        $config = [
            'payment' => [
                'instructions' => [
                    self::CODE => $instructions
                ],
                'cms' => [
                    self::CODE => ( !is_null($cms) ) ? $this->_getUrl($cms) : null
                ],
                'session_timeout' => [
                    self::CODE => ( $this->netHelper->getSessionEnable() ) ? true : false
                ],
                'currencyCodes' => [
                    self::CODE => $currencys
                ]
            ]
        ];

        return $config;
    }
}
