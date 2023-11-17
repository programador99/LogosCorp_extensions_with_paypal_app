<?php

namespace LogosCorp\StoreLocator\Model\Adminhtml\System\Config\Source;

class TypeStore implements \Magento\Framework\Option\ArrayInterface
{


    public function getOptions()
    {
        $options = [
            ['value' => '1', 'label' => 'Conventional'],
            ['value' => '2', 'label' => 'Corporative'],
            ['value' => '3', 'label' => 'Educational']
        ];
        return $options;
    }

    public function toOptionArray()
    {
        return $this->getOptions();
    }
}