<?php

namespace LogosCorp\Net247\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
	public function getSessionEnable()
    {
        return $this->scopeConfig->getValue(
            'payment/net247/session_enable',
            ScopeInterface::SCOPE_STORE
        );
    }

	public function getSessionTime()
    {
        return $this->scopeConfig->getValue(
            'payment/net247/session_time',
            ScopeInterface::SCOPE_STORE
        );
    }

	public function getSessionMessage()
    {
        return $this->scopeConfig->getValue(
            'payment/net247/session_message',
            ScopeInterface::SCOPE_STORE
        );
    }
}