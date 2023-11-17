<?php
namespace LogosCorp\CustomTierPrice\Helper;

class CustomTierPrice extends \Magento\Framework\App\Helper\AbstractHelper
{
    public function getHtml($_productTier,$id) {

        //$product->getTierPrices()[0]->getValue() 
        $html='';
        $html.='<div class="tier-price-container" id="card_'.$id.'"">';
            $html.='<span class="close-card" id="'.$id.'">X</span>';
            $html.='<div class="massive-purchase-card"></div>';
            $html.='<p>'.__('Volume purchase').'</p>';
        foreach ($_productTier as $tierPrice) {
                $html.='<p class="tier-item">';
                    $html.='<span>'.number_format($tierPrice->getQty()).' UNID </span>';
                    $html.='<span>'.$tierPrice->getValue().'</span>';
                $html.='</p>';
            }
        $html.='</div>';
        return $html;
    }

}