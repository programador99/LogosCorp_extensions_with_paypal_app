<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace LogosCorp\ExtendFieldLengthZipCode\Block\Address\Renderer;

use Magento\Customer\Model\Address\AddressModelInterface;
use Magento\Customer\Model\Address\Mapper;
use Magento\Customer\Model\Metadata\ElementFactory;
use Magento\Directory\Model\Country\Format;
use Magento\Framework\View\Element\AbstractBlock;
use LogosCorp\ExtendFieldLengthZipCode\Helper\ZipCodes as HelperZipCodes;

/**
 * Address format renderer default
 */
class DefaultRenderer extends \Magento\Customer\Block\Address\Renderer\DefaultRenderer
{

     /**
     * @var HelperZipCodes
     */
    protected $_helperZipCodes;

    /**
     * Constructor
     * @param HelperZipCodes $helperZipCodes
     * @param \Magento\Framework\View\Element\Context $context
     * @param ElementFactory $elementFactory
     * @param \Magento\Directory\Model\CountryFactory $countryFactory
     * @param \Magento\Customer\Api\AddressMetadataInterface $metadataService
     * @param Mapper $addressMapper
     * @param array $data
     */
    public function __construct(
        HelperZipCodes $helperZipCodes,
        \Magento\Framework\View\Element\Context $context,
        ElementFactory $elementFactory,
        \Magento\Directory\Model\CountryFactory $countryFactory,
        \Magento\Customer\Api\AddressMetadataInterface $metadataService,
        Mapper $addressMapper,
        array $data = []
    ) {
        $this->_helperZipCodes = $helperZipCodes;
        parent::__construct($context, $elementFactory,$countryFactory,$metadataService,$addressMapper,$data);
    }


    /**
     * Render address by attribute array
     *
     * @param array $addressAttributes
     * @param Format|null $format
     * @return string
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function renderArray($addressAttributes, $format = null)
    {
        switch ($this->getType()->getCode()) {
            case 'html':
                $dataFormat = ElementFactory::OUTPUT_FORMAT_HTML;
                break;
            case 'pdf':
                $dataFormat = ElementFactory::OUTPUT_FORMAT_PDF;
                break;
            case 'oneline':
                $dataFormat = ElementFactory::OUTPUT_FORMAT_ONELINE;
                break;
            default:
                $dataFormat = ElementFactory::OUTPUT_FORMAT_TEXT;
                break;
        }

        $attributesMetadata = $this->_addressMetadataService->getAllAttributesMetadata();
        $data = [];
        foreach ($attributesMetadata as $attributeMetadata) {
            if (!$attributeMetadata->isVisible()) {
                continue;
            }
            $attributeCode = $attributeMetadata->getAttributeCode();
            if ($attributeCode == 'country_id' && isset($addressAttributes['country_id'])) {
                $data['country'] = $this->_countryFactory->create()->loadByCode(
                    $addressAttributes['country_id']
                )->getName();
            } elseif ($attributeCode == 'region' && isset($addressAttributes['region'])) {
                $data['region'] = (string)__($addressAttributes['region']);
            } elseif (isset($addressAttributes[$attributeCode])) {
                $value = $addressAttributes[$attributeCode];
                $dataModel = $this->_elementFactory->create($attributeMetadata, $value, 'customer_address');
                $value = $dataModel->outputValue($dataFormat);
                if ($attributeMetadata->getFrontendInput() == 'multiline') {
                    $values = $dataModel->outputValue(ElementFactory::OUTPUT_FORMAT_ARRAY);
                    // explode lines
                    foreach ($values as $k => $v) {
                        $key = sprintf('%s%d', $attributeCode, $k + 1);
                        $data[$key] = $v;
                    }
                }
                $data[$attributeCode] = $value;
            }
        }
        if ($this->getType()->getEscapeHtml()) {
            foreach ($data as $key => $value) {
                $data[$key] = $this->escapeHtml($value);
            }
        }
        
        $aliasPostcode=$this->_helperZipCodes->getPostcodeAlias($data['postcode']);
        $addressAttributes['postcode_alias']=$aliasPostcode;
        $data['postcode_alias']=$aliasPostcode;
        $format = $format !== null ? $format : $this->getFormatArray($addressAttributes);
        return $this->filterManager->template($format, ['variables' => $data]);
    }

}