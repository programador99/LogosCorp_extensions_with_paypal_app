<?php

namespace LogosCorp\ExtendFieldLengthZipCode\Model\Config\Source;

use Magento\Eav\Model\ResourceModel\Entity\Attribute\OptionFactory;
use Magento\Framework\DB\Ddl\Table;
use LogosCorp\ExtendFieldLengthZipCode\Helper\ZipCodes as HelperZipCodes;

class PostcodesOptions extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
   
    protected $optionFactory;
    protected $_helperZipCodes;

    /**
     * @param OptionFactory $optionFactory
     * @param HelperZipCodes $helperZipCodes
     */
     public function __construct(
         OptionFactory $optionFactory,
         HelperZipCodes $helperZipCodes
         )
      {
        $this->optionFactory = $optionFactory;
        $this->_helperZipCodes = $helperZipCodes;
      } 

    /**
     * Get all options.
     *
     * @return array
     */
    public function getAllOptions($includeDetails=false,$websiteId=null)
    {
        $this->_options = [
            ['label' => ' ', 'value' => ' '],
            ['label' => __("My urbanization does not appear"), 'value' => '1']
        ];

        try {
          
            $listZipCodes = $this->_helperZipCodes->getZipCodes();

            $list_tablerate=[];
            foreach ($listZipCodes as  $tablerate) {
                if(!in_array($tablerate['dest_zip'],$list_tablerate)){
                    if($includeDetails){
                        $this->_options[]= [
                            'label' => $tablerate['alias'],
                            'value' => $tablerate['dest_zip'],
                            'region_id' => $tablerate['dest_region_id'],
                            'country_id' => $tablerate['dest_country_id']
                        ];
                    }else{
                        $this->_options[]= [
                            'label' => $tablerate['alias'],
                            'value' => $tablerate['dest_zip']
                        ];
                    }
                }
            }
        } catch (\Throwable $th) {
        }
        return $this->_options;
    }

}
