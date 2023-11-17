<?php

namespace LogosCorp\CustomLogin\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
	const PATH = 'logoscorp_custom_login/redirect_login/redirect_page';

    const CONFIG_MODULE_IS_ENABLED = 'logoscorp_custom_login/redirect_login/enable';

    public function isModuleEnabled()
    {
        $isEnabled = $this->scopeConfig->getValue(self::CONFIG_MODULE_IS_ENABLED, ScopeInterface::SCOPE_STORE);
        return $isEnabled;
    }

	public function getRedirectPage()
    {
        return $this->scopeConfig->getValue(self::PATH, ScopeInterface::SCOPE_STORE);
    }
}