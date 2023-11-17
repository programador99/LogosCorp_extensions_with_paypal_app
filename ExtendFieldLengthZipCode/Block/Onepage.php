<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace LogosCorp\ExtendFieldLengthZipCode\Block;

use LogosCorp\ExtendFieldLengthZipCode\Helper\ZipCodes as HelperZipCodes;

/**
 * Onepage checkout block
 * @api
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @since 100.0.2
 */
class Onepage extends \Magento\Checkout\Block\Onepage
{

     /**
     * @var \Magento\Framework\Serialize\SerializerInterface
     */
    private $serializer;

    /**
     * @var HelperZipCodes
     */
    protected $_helperZipCodes;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Data\Form\FormKey $formKey
     * @param \Magento\Checkout\Model\CompositeConfigProvider $configProvider
     * @param array $layoutProcessors
     * @param array $data
     * @param \Magento\Framework\Serialize\Serializer\Json $serializer
     * @param \Magento\Framework\Serialize\SerializerInterface $serializerInterface
     * @param HelperZipCodes $helperZipCodes
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Data\Form\FormKey $formKey,
        \Magento\Checkout\Model\CompositeConfigProvider $configProvider,
        array $layoutProcessors = [],
        array $data = [],
        \Magento\Framework\Serialize\Serializer\Json $serializer = null,
        \Magento\Framework\Serialize\SerializerInterface $serializerInterface = null,
        HelperZipCodes $helperZipCodes
    ) {
        $this->_helperZipCodes = $helperZipCodes;
        $this->serializer = $serializerInterface ?: \Magento\Framework\App\ObjectManager::getInstance()
            ->get(\Magento\Framework\Serialize\Serializer\JsonHexTag::class);
        parent::__construct($context, $formKey, $configProvider, $layoutProcessors, $data, $serializer, $serializerInterface );
    }

    /**
     * Retrieve serialized checkout config.
     *
     * @return bool|string
     * @since 100.2.0
     */
    public function getSerializedCheckoutConfig()
    {   
        $checkoutConfig=$this->getCheckoutConfig();
        $checkoutConfig['listZipCodes'] = $this->_helperZipCodes->getListZipCodes();
        return  $this->serializer->serialize($checkoutConfig);
    }

}