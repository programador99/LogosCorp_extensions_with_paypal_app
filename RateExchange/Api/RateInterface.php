<?php 
namespace LogosCorp\RateExchange\Api;

interface RateInterface{
    /**
     * Returns greeting message to user
     *
     * @api
     * @param mixed $rates   ========== Assign type string to your $rateCode param variable
     * @return mixed
     */
    public function calculateAmount($rates);
}