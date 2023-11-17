<?php declare(strict_types=1);

namespace LogosCorp\Net247\Model;

use Magento\Framework\Model\AbstractModel;

class CurrencyCode extends AbstractModel
{
    protected function _construct(): void
    {
        $this->_init(ResourceModel\CurrencyCode::class);
    }
}