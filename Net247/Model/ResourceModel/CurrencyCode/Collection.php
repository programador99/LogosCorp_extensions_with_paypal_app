<?php declare(strict_types=1);

namespace LogosCorp\Net247\Model\ResourceModel\CurrencyCode;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';
	protected $_eventPrefix = 'logoscorp_currency_codes';
	protected $_eventObject = 'currency_codes';

    protected function _construct(): void
    {
        $this->_init(
            \LogosCorp\Net247\Model\CurrencyCode::class, 
            \LogosCorp\Net247\Model\ResourceModel\CurrencyCode::class
        );
    }
}