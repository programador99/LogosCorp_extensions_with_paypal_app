<?php

namespace LogosCorp\StoreLocator\Block;

use LogosCorp\StoreLocator\Helper\Data;
use Magento\Customer\Model\SessionFactory;


class StoreLocator extends \Magento\Framework\View\Element\Template
{

    /**
     * @var StoreManagerInterface 
     */
    protected $_storeManager;

    /**
     * @var Data
     */
    protected $_helper;

    /**
     * @var SessionFactory
     */
    protected $_sessionFactory;

    protected $_customerId;

    /**
     * @var SessionFactory
     */
    protected $_customer;

    /**
     * @param SessionFactory $sessionFactory
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        SessionFactory $sessionFactory,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        Data $helper
    ) {
        parent::__construct($context);
        $this->_storeManager = $storeManager;
        $this->_helper = $helper;
        $this->_sessionFactory = $sessionFactory;
        $this->_customerId = $this->identifyCustomerInSession();
    }

    public function getCustomerId()
    {
        return $this->_customerId;
    }

    private function IdentifyCustomerInSession()
    {
        $result = null;
        try {
            $result = $this->_sessionFactory->create()->getCustomerData()->getId();
        } catch (\Throwable $th) {
            //throw $th;
        }
        return $result;
    }


    public function getStore()
    {
        $store = $this->_storeManager->getStore();
        return $this->_helper->getStore($store);
    }

    public function getWebsite()
    {
        return $this->_storeManager->getStore()->getWebsite();
    }

    public function getStoreInfo()
    {
        $store = $this->_storeManager->getStore();
        return $this->_helper->getStoreInformation($store);
    }

    public function getWebSites()
    {
        return $this->_helper->getWebSites();
    }

    public function getPreferredStore($customerId)
    {
        return $this->_helper->getPreferredStore($customerId);
    }

    /**
     * Calculates the distance between two points, given their 
     * latitude and longitude, and return distance in Km
     *
     * @param  float $fromLatitud Latitude of the first point
     * @param  float $fromLongitud Longitude of the first point
     * @param  float $toLatitud Latitude of the second point
     * @param  float $toLongitud Longitude of the second point
     * @return float distance in Km
     */
    public function getDistanceKm($fromLatitud, $fromLongitud, $toLatitud, $toLongitud)
    {
        if (($fromLatitud == $toLatitud) && ($fromLongitud == $toLongitud)) {
            return 0;
        }

        $theta = $fromLongitud - $toLongitud;
        $dist = sin(deg2rad($fromLatitud)) * sin(deg2rad($toLatitud)) +  cos(deg2rad($fromLatitud)) * cos(deg2rad($toLatitud)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;

        // Km distance
        return ($miles * 1.609344);
    }
}
