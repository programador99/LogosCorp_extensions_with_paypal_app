<?php

namespace LogosCorp\StoreLocator\Helper;

use LogosCorp\StoreLocator\Model\Settings;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Store\Model\Information as StoreInformation;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\View\LayoutFactory;
use Magento\Framework\Locale\Resolver as LocaleResolver;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    /**
     * @var StoreManagerInterface 
     */
    private $_storeManager;

    /**
     * @var Settings
     */
    private $_settings;

    /**
     * @var StoreInformation;
     */
    private $_storeInformation;


    /**
     * @var CustomerRepositoryInterface
     */
    private $_customerRepository;


    /**
     * @var LayoutFactory
     */
    private $_layoutFactory;

    /**
     * @var LocaleResolver
     */
    private $_localeResolver;

    /**
     * @param StoreManagerInterface $storeManager
     * @param Settings $settings
     * @param StoreInformation $storeInformation
     * @param CustomerRepositoryInterface $customerRepository
     * @param LayoutFactory $layoutFactory
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        Settings $settings,
        StoreInformation $storeInformation,
        CustomerRepositoryInterface $customerRepository,
        LayoutFactory $layoutFactory,
        LocaleResolver $localeResolver
    ) {
        $this->_settings = $settings;
        $this->_storeManager = $storeManager;
        $this->_storeInformation = $storeInformation;
        $this->_customerRepository = $customerRepository;
        $this->_layoutFactory = $layoutFactory;
        $this->_localeResolver = $localeResolver;
    }

    public function getStoreInformation($store)
    {
        return $this->_storeInformation->getStoreInformationObject($store)->getData();
    }

    public function getWebSites()
    {
        $stores = $this->_storeManager->getStores();
        $data = [];
        $dataWebsites = [];

        foreach ($stores as $store) {
            $websiteId = $store->getWebsiteId();

            if ($store->getCode() !== 'admin' 
                && $this->_settings->getConfigStoreLocatorInclude($websiteId) == '1'
                && $store->isDefault()) {
                $dataWebsites = array_merge(
                    $store->getData(),
                    $this->getStoreInformation($store),
                    [
                        'latitud' => $this->_settings->getConfigStoreLocatorLatitud($websiteId),
                        'longitud' => $this->_settings->getConfigStoreLocatorLongitud($websiteId),
                        'website_url' => $store->getBaseUrl('web', true)
                    ]
                );

                $dataWebsites['phones'] = explode("|", $dataWebsites['phone']);
                $dataWebsites['schedule'] = explode("|", $dataWebsites['hours']);

                $data[] = $dataWebsites;
            }
        }

        return $data;
    }

    public function getStore(\Magento\Store\Model\Store $store)
    {
        //$id = $store->getid();
        $id = $store->getWebsiteId();

        $data = array_merge(
            $store->getData(),
            $this->getStoreInformation($store),
            [
                'latitud' => $this->_settings->getConfigStoreLocatorLatitud($id),
                'longitud' => $this->_settings->getConfigStoreLocatorLongitud($id),
                'website_url' => $store->getBaseUrl('web', true)
            ]
        );

        $data['phones'] = explode("|", $data['phone']);
        $data['schedule'] = explode("|", $data['hours']);

        return $data;
    }

    public function getPreferredStore(int $customerId)
    {
        $customer = $this->_customerRepository->getById($customerId);
        $preferredStore = $customer->getCustomAttribute('preferred_store');

        if (is_null($preferredStore)) {
            return null;
        } else {
            return $preferredStore->getValue();
        }
    }


    public function getPreferredStoreField($currentPreferredStore)
    {
        $layout = $this->_layoutFactory->create();
        $blockOption = $layout->createBlock("Magento\Framework\View\Element\Template")
        ->setTemplate("LogosCorp_StoreLocator::form/preferred_store.phtml")->setData('storeList', $this->getWebSites())->setData('currentPreferredStore', $currentPreferredStore);
       return $blockOption->toHtml();
    }

    public function getLocaleCode()
    {
        return $this->_localeResolver->getLocale();
    }
}
