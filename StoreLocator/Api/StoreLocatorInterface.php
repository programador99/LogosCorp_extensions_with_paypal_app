<?php

namespace LogosCorp\StoreLocator\Api;

interface StoreLocatorInterface
{

    /**
     * Returns api websites
     *
     * @api
     * @return array
     */
    public function getWebSites();


    /**
     * Return api customer website.
     *
     * @param int $customerId
     * @param int $storeId
     * @return array
     *
     */
    public function savePreferredStore(int $customerId, int $storeId);
}
