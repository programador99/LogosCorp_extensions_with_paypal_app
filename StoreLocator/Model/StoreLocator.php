<?php

namespace LogosCorp\StoreLocator\Model;

use LogosCorp\StoreLocator\Api\StoreLocatorInterface;
use LogosCorp\StoreLocator\Helper\Data;
use LogosCorp\StoreLocator\Helper\CustomerSaveStore;

class StoreLocator implements StoreLocatorInterface
{

    /**
     * @var Data
     */
    private $_helper;


    /**
     * @var CustomerSaveStore
     */
    private $_customerHelper;


    /**
     * constructor.
     * @param Data $helper
     * @param CustomerSaveStore $customerHelper
     */
    public function __construct(
        Data $helper,
        CustomerSaveStore $customerHelper
    ) {
        $this->_helper = $helper;
        $this->_customerHelper = $customerHelper;
    }

    /** 
     * {@inheritdoc}
     */
    public function getWebSites()
    {
        return $this->_helper->getWebSites();
    }

    /**
     * {@inheritdoc}
     */
    public function savePreferredStore(int $customerId, int $storeId)
    {
        try {
            $this->_customerHelper->savePreferredStore($customerId, $storeId);

            $result=[
                'success' => true,
                'message' => 'Preferred store saved successfully'
            ];

        } catch (\Throwable $th) {

            $result=[
                'success' => false,
                'message' => $th->getMessage()
            ];

        }

        return [$result];
    }
}
