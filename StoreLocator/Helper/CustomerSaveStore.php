<?php

namespace LogosCorp\StoreLocator\Helper;

use Magento\Customer\Model\Customer;
use Magento\Customer\Model\ResourceModel\CustomerFactory;

class CustomerSaveStore extends \Magento\Framework\App\Helper\AbstractHelper
{

    /**
     * @var Customer 
     */
    protected $_customer;

    /**
     * @var CustomerFactory 
     */
    protected $_customerFactory;

    /**
     * @param Customer $customer
     * @param CustomerFactory $customerFactory
     */
    public function __construct(
        Customer $customer,
        CustomerFactory $customerFactory
    ) {
        $this->_customer = $customer;
        $this->_customerFactory = $customerFactory;
    }

    public function savePreferredStore(int $customerId, int $storeId)
    {
        $customer = $this->_customer->load($customerId);
        $customerData = $customer->getDataModel();
        $customerData->setCustomAttribute('preferred_store',$storeId);
        $customer->updateData($customerData);
        $customerResource = $this->_customerFactory->create();
        $customerResource->saveAttribute($customer, 'preferred_store');
    }
}