<?php

namespace LogosCorp\CustomLogin\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Customer\Model\SessionFactory;
use Magento\Customer\Model\Session as SessionCustomer;

class SessionHelper extends AbstractHelper
{
    /**
    * @var SessionFactory
    */
    protected $_sessionFactory;

      /**
   * Constructor
   * @param SessionFactory $sessionFactory
   * @param Context $context
   * @param SessionCustomer $session
   */

    public function __construct(
        SessionFactory $sessionFactory,
        SessionCustomer $session,
        Context $context)
    {
        parent::__construct($context);
        $this->_customerSession = $session;
        $this->_sessionFactory = $sessionFactory;
    }
    public function getCustomerSessionStatus() {
        $customerId=$this->getCustomerInSession();
        return (!is_null($customerId) && is_numeric($customerId));
      }
    
    private function getCustomerInSession() {
        $result=null;
        try {
            $result=$this->_sessionFactory->create()->getCustomerData()->getId();
        } catch (\Throwable $th) {
        }
        return $result;
    }
}