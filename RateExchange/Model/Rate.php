<?php 
namespace LogosCorp\RateExchange\Model;

use LogosCorp\RateExchange\Api\RateInterface;
use \Magento\Store\Model\StoreManagerInterface;
use \Magento\Directory\Model\Currency;
use \Magento\Directory\Model\Currency\Import\AbstractImport;

class Rate implements RateInterface
{   
    protected $storeManager;
    protected $currencyModel;

    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Directory\Model\Currency $currencyModel
    ) {
        $this->storeManager = $storeManager;
        $this->currencyModel = $currencyModel;
    }

    public function calculateAmount($rates)
    {   
        try {
             $currencies = $this->currencyModel->getConfigAllowCurrencies();
            $baseCurrency = $this->currencyModel->getConfigBaseCurrencies();
            $setRates=array();

            foreach($rates as $key => $value){
                $isValidCurrency = false;

                foreach ($currencies as $currency) {

                    if($currency === $value['code']){
                        $isValidCurrency = true;

                        if($rates[$key]['code'] === $baseCurrency[0]){
                            $setRates[$baseCurrency[0]][$currency]=1;
                            $rates[$key]['exchange']=1;
                            $rates[$key]['update'] = true;
                        }elseif(!is_numeric($rates[$key]['exchange']) || $rates[$key]['exchange'] <= 0) {
                            $rates[$key]['update'] = false;
                        }else{
                            $setRates[$baseCurrency[0]][$currency]=$value['exchange'];
                            $rates[$key]['update'] = true;
                        }

                        break; 
                    }
                }

                if(!$isValidCurrency){
                    $rates[$key]['update'] = false;
                } 
            }

            if (!empty($setRates)){
                $this->currencyModel->saveRates($setRates); 
            }

             return $rates; 

        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
}
