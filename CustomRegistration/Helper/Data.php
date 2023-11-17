<?php

namespace LogosCorp\CustomRegistration\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
	const PATH = 'logoscorp_custom_registration/terms_settings/terms_page';

	public function getTermsConfig()
    {
        return $this->scopeConfig->getValue(self::PATH, ScopeInterface::SCOPE_STORE);
    }
}