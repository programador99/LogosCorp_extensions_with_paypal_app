<?php
namespace LogosCorp\CustomLogin\Plugin;

use LogosCorp\CustomLogin\Helper\Data as LoginHelper;
use LogosCorp\CustomLogin\Helper\SessionHelper;
 
class RedirectCustomUrl
{

    /**
     * @var LoginHelper
     */
    protected $loginHelper;


    protected $sessionHelper;


    /**
     * @param HelperZipCodes $helperZipCodes
     */
    public function __construct(
        LoginHelper $loginHelper,
        SessionHelper $sessionHelper
    ) {
        $this->loginHelper = $loginHelper;
        $this->sessionHelper = $sessionHelper;
    }
 
    public function afterExecute(
        \Magento\Customer\Controller\Account\LoginPost $subject,
        $result)
    {   
        $isLogged = $this->sessionHelper->getCustomerSessionStatus();
        if($this->loginHelper->isModuleEnabled() && $isLogged == true){
            $customUrl = $this->loginHelper->getRedirectPage();
            $result->setPath($customUrl);
        }
        return $result;
    }
}