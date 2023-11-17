<?php

namespace LogosCorp\CustomPaymentsMethod\Model;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Class ConfigProvider
 */
final class CustomConfigProvider extends AbstractHelper implements ConfigProviderInterface
{
    protected $paymentsCodes = [
        CustomPaymentMethod1::PAYMENT_METHOD_CODE1,
        CustomPaymentMethod2::PAYMENT_METHOD_CODE2,
        CustomPaymentMethod3::PAYMENT_METHOD_CODE3,
        PayPalPaymentMethod::PAYMENT_METHOD_CODE4,
        BinanceUSDTPaymentMethod::PAYMENT_METHOD_CODE5,
        TetherUsdtTRC20PaymentMethod::PAYMENT_METHOD_CODE6,
        MonyPaymentMethod::PAYMENT_METHOD_CODE7,
        C2PPaymentMethod::PAYMENT_METHOD_CODE8,
        
    ];

    public function getPaymentData($code){
        return $this->scopeConfig->getValue("payment/".$code."/instructions", ScopeInterface::SCOPE_STORE);
    }
    /**
     * Retrieve assoc array of checkout configuration
     *
     * @return array
     */
   
    public function getConfig()
    {
        $config = [];
        foreach ($this->paymentsCodes as $code) {
            $validCode = $this->getPaymentData($code);

            if(!is_null($validCode)){
                $config['payment']['instructions'][$code] = $validCode;
            }
            
        }
        return $config;
    }
}
