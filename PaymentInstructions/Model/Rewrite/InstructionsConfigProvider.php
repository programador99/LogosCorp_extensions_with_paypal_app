<?php

namespace LogosCorp\PaymentInstructions\Model\Rewrite;

class InstructionsConfigProvider extends \Magento\OfflinePayments\Model\InstructionsConfigProvider

{
    public function getInstructions($code)
    {
        if($code == 'banktransfer' || $code == 'custompaymentsmethod1' || $code == 'custompaymentsmethod2' || $code == 'custompaymentsmethod3'){//check payment method is banktransfer
            return nl2br($this->methods[$code]->getInstructions());// removed escapeHtml function!
        }else{
            return nl2br($this->escaper->escapeHtml($this->methods[$code]->getInstructions()));
        }
    }

}