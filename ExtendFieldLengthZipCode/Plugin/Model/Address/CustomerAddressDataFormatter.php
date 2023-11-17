<?php

namespace LogosCorp\ExtendFieldLengthZipCode\Plugin\Model\Address;

use LogosCorp\ExtendFieldLengthZipCode\Helper\ZipCodes as HelperZipCodes;

class CustomerAddressDataFormatter
{
   
    /**
     * @var HelperZipCodes
     */
    protected $_helperZipCodes;

    /**
     * @param HelperZipCodes $helperZipCodes
     */
    public function __construct(
        HelperZipCodes $helperZipCodes
    ) {
        $this->_helperZipCodes = $helperZipCodes;
    }

    /**
     * Prepare customer address data.
     *
     * @param AddressInterface $customerAddress
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function afterPrepareAddress(\Magento\Customer\Model\Address\CustomerAddressDataFormatter $subject, $result)
    {
        $result['custom_attributes'][]=[
            'attribute_code'=>'postcode_alias',
            'value'=>$this->_helperZipCodes->getPostcodeAlias($result['postcode']),
        ];
        return $result;
    }

}