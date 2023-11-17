<?php

namespace LogosCorp\ExtendFieldLengthZipCode\Model;
use LogosCorp\ExtendFieldLengthZipCode\Api\AliasPostCodeInterface;
use LogosCorp\ExtendFieldLengthZipCode\Helper\ZipCodes as HelperZipCodes;

class AliasPostCode implements AliasPostCodeInterface {
  

    /**
     * @var HelperZipCodes
     */
    protected $_helperZipCodes;

    /**
    * @param HelperZipCodes $helperZipCodes
    */
    public function __construct(
        HelperZipCodes $helperZipCodes
    ){
        $this->_helperZipCodes = $helperZipCodes;
    }

    /**
     * Returns urbanizaciones
     *
     * @api
     * @return array
     */
    public function get()
    {
        return $this->_helperZipCodes->getZipCodes();
    }
}