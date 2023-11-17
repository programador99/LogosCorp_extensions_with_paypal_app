<?php

namespace LogosCorp\ExtendFieldLengthZipCode\Helper;

use \Magento\Framework\App\ResourceConnection;

class ZipCodes extends \Magento\Framework\App\Helper\AbstractHelper
{

    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $_resourceConnection;

    /**
     * @param ResourceConnection $resourceConnection
   
     */
    public function __construct(
        ResourceConnection $resourceConnection
    ) {
      
        $this->_resourceConnection = $resourceConnection;
    }

    public function getZipCodes(){
        $listZipCodes = [];

        try {
            $connection = $this->_resourceConnection->getConnection();
            $tableName = $this->_resourceConnection->getTableName('shipping_tablerate'); 
            $sql="
            SELECT dest_zip, dest_country_id, dest_region_id, alias
            FROM ".$tableName."
            WHERE pk in (SELECT MIN(pk) AS dest_zip
            FROM ".$tableName."
            GROUP BY dest_zip)
            ORDER BY alias ASC
            ";
            $result = $connection->fetchAll($sql); 
            $list_tablerate=[];
            foreach ($result as  $tablerate) {
                if(!in_array($tablerate['dest_zip'],$list_tablerate)){
                    $listZipCodes[]=$tablerate;
                }
            }
        } catch (\Throwable $th) {
        }

        return $listZipCodes;
    }

    public function getZipCodesOptions()
    {
        $options = [
            ['label' => __('My urbanization does not appear'), 'value' => '0'],
        ];
        
        try {
            $list_tablerate=[];
            foreach ($this->getZipCodes() as  $tablerate) {
                $options[]= ['label' => $tablerate['alias'], 'value' => $tablerate['dest_zip']];
            }
        } catch (\Throwable $th) {
        }
        return $options;
    }

    public function getListZipCodes(){
        $result=[];
        $listZipCodes = $this->getZipCodes();
        foreach ($listZipCodes as $zipCode) {
            $result[$zipCode['dest_zip']]=$zipCode['alias'];
        }
        return $result;
    }

    public function getPostcodeAlias($postcode){
        $listZipCodes=$this->getListZipCodes();
        if(isset($listZipCodes[$postcode])){
            return $listZipCodes[$postcode];
        }else{
            return $postcode;
        }
    }

}
