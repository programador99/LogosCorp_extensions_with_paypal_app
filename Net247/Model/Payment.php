<?php

namespace LogosCorp\Net247\Model;

class Payment extends \Magento\Payment\Model\Method\Cc
{
    const CODE = 'net247';

    const TRANSACTION_TIME_OUT = 12;
    const IS_CUSTOMER_NOTIFIED = false; //SET TO FALSE WHILE DEV MODE

    // URLS 
    const GET_CARD_TOKEN        = '/api/v1/tokenize/check/';
    const CREATE_CARD_TOKEN     = '/api/v1/tokenize/';
    const ACTIVATE_CARD_TOKEN   = '/api/v1/tokenize/activate/';
    const MAKE_PAYMENT          = '/api/v1/pos/payment/online/sale/';
    const VOID_PAYMENT          = '/api/v1/pos/payment/void/';

    protected $_apiToken = null;
    protected $_apiPreRegistrationCode = null;
    protected $_code = self::CODE;
    protected $_isGateway = true;
    protected $_canAuthorize = false;
    protected $_canCapture = true;
    protected $_canCapturePartial = false;
    protected $_canRefund = false;
    protected $_canRefundInvoicePartial = false;
    protected $_merchantId = null;
    protected $_tender = null;
    protected $_apiUrl = null;
    protected $_isDebugModeOn = false;
    protected $_countryFactory;
    protected $_minAmount = null;
    protected $_maxAmount = null;
    protected $_supportedCurrencyCodes = ["VEF", "USD"];
    protected $_backendSession = null;
    protected $_storeManager = null;
    protected $_priceCurrency = null;
    protected $_currencyCodeFactory = null;
    protected $_isapppayment = false;

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory,
        \Magento\Payment\Helper\Data $paymentData,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Payment\Model\Method\Logger $logger,
        \Magento\Framework\Module\ModuleListInterface $moduleList,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate,
        \Magento\Directory\Model\CountryFactory $countryFactory,
        \Magento\Backend\Model\Session $backendSession,
        \Magento\Store\Model\StoreManagerInterface $_storeManager,
        \Magento\Framework\Pricing\PriceCurrencyInterface $_priceCurrency,
        \LogosCorp\Net247\Model\CurrencyCodeFactory $currencyCodeFactory,
        array $data = array()
    ) {
        parent::__construct(
            $context,
            $registry,
            $extensionFactory,
            $customAttributeFactory,
            $paymentData,
            $scopeConfig,
            $logger,
            $moduleList,
            $localeDate,
            null,
            null,
            $data
        );

        $this->_countryFactory = $countryFactory;
        $this->_tender = $this->getConfigData('tender');
        $this->_merchantId = $this->getConfigData('merchant_id');
        $this->_apiToken = $this->getConfigData('api_token');
        $this->_apiUrl = $this->getConfigData('api_url');
        $this->_minAmount = $this->getConfigData('min_order_total');
        $this->_maxAmount = $this->getConfigData('max_order_total');
        $this->_isDebugModeOn = $this->getConfigData('debug');
        $this->_backendSession = $backendSession;
        $this->_storeManagerInterface = $_storeManager;
        $this->_priceCurrencyInterface = $_priceCurrency;
        $this->_currencyCodeFactory = $currencyCodeFactory;
    }

    public function assignData(\Magento\Framework\DataObject $data)
    {
        $additionalData = $data->getData("additional_data");
        $nData = (array) $additionalData;
        $cc_microcharge = array_key_exists("cc_microcharge", $nData) ? $additionalData["cc_microcharge"] : "";
        $cc_currency = array_key_exists("cc_currency", $nData) ? $additionalData["cc_currency"] : "USD";


        $isapppayment = array_key_exists("isapppayment", $nData);

        $isapppayment = $isapppayment ? $additionalData['isapppayment'] : false;

        $this->_backendSession->setIsAppPayment($isapppayment);

        // $this->_backendSession->setCcMicroCharge($additionalData["cc_microcharge"]);
        // $this->_backendSession->setCcCurrency($additionalData["cc_currency"]);
        $this->_backendSession->setCcMicroCharge($cc_microcharge);
        $this->_backendSession->setCcCurrency($cc_currency);
        
        $info = $this->getInfoInstance();
        $info->addData(
            [
                // Custom fields
                // 'cc_microcharge'        => $additionalData["cc_microcharge"],
                // 'cc_currency'           => $additionalData["cc_currency"],
                //---->
                'cc_type'           => $additionalData["cc_type"],
                'cc_number'         => $additionalData["cc_number"],
                'cc_cid'            => $additionalData["cc_cid"],
                'cc_cid_enc'        => $additionalData["cc_cid"],
                'cc_exp_month'      => $additionalData["cc_exp_month"],
                'cc_exp_year'       => $additionalData["cc_exp_year"],
                'cc_ss_issue'       => $additionalData["cc_ss_issue"],
                'cc_ss_start_month' => $additionalData["cc_ss_start_month"],
                'cc_ss_start_year'  => $additionalData["cc_ss_start_year"],
                'cc_last_4'         => substr($additionalData["cc_number"], -4),
                'cc_number_enc'     => $additionalData["cc_number"],
                'additional_information' => []
            ]
        );
        return $this;
    }

    public function capture(\Magento\Payment\Model\InfoInterface $payment, $amount)
    {
        try {

            $order = $payment->getOrder();
            
            // Jacidi & Biomercados
            if( $this->_backendSession->getIsAppPayment() ) {
                $order->save();
                return $this;
            }

            $billingAddress = $order->getBillingAddress()->getData();
            $microCharge = ($this->_backendSession->getCcMicroCharge()) ? $this->_backendSession->getCcMicroCharge() : null;

            // Checking TimeOut
            if (!$this->_verifyTimeOut() && !$this->_isDebugModeOn) {
                throw new \Magento\Framework\Validator\Exception(__("The allotted time for this operation has expired, please try again later."));
            }

            // Check the order amount
            if (empty($amount) || $amount <= 0) {
            
                throw new \Magento\Framework\Validator\Exception(__("The order amount is invalid."));
            
            } elseif (strlen($amount) > 15) {
            
                throw new \Magento\Framework\Validator\Exception(__("The amount of the order cannot be processed. Exceeds the allowed amount."));
            
            }

            // GET CREDIT CARD SECURITY TOKEN INFORMATION
            $getCardToken = $this->_callApiCustomUrl($this::GET_CARD_TOKEN, $payment->getCcNumber() );
                
            $this->_customLogger('Consult Credit Card', $amount, $payment, $billingAddress, $getCardToken);
            
            if ( $getCardToken->code == 400) {

                // CREATE CREDIT CARD SECURITY TOKEN
                $createCardToken = $this->_createCardToken($amount, $payment, $billingAddress);
                
            } elseif ( $getCardToken->code == 200 && $getCardToken->data->blocked ) {
                 
                throw new \Magento\Framework\Validator\Exception(__("The card is blocked. Please contact the administrator."));
            
            } elseif ( $getCardToken->code == 200 && $getCardToken->data->active ) {
            
                $onlinePayment = $this->_makeOnlinePayment($amount, $payment, $billingAddress);

            } elseif ( $getCardToken->code == 200 && !$getCardToken->data->active && is_null($microCharge) ) {
                
                throw new \Magento\Framework\Validator\Exception(__("The card has an active validation. Please enter the amount of the micro charge made to continue."));
                
            } elseif ( $getCardToken->code == 200 && !$getCardToken->data->active && !is_null($microCharge) ) {
                
                $activateCard = $this->_activateCardToken($amount, $payment, $billingAddress, $microCharge);

                $onlinePayment = $this->_makeOnlinePayment($amount, $payment, $billingAddress);
            }

            $order->addStatusHistoryComment(
                __('Transaction reference number: <strong>%1</strong>.', $onlinePayment->data->retref)
            );
            $order->save();

            // Save result info in session variable
            $this->_backendSession->setLogoscorpPaymentResultInfo([
                "order_id"              => $order->getId(),
                "order_increment_id"    => $order->getIncrementId(),
                "result"                => $onlinePayment->data->respcode,
                "result_message"        => $onlinePayment->data->resptext,
                "result_voucher"        => $onlinePayment->data->retref
            ]);

            // Cleanup the customer data from session
            $this->_backendSession->unsCcMicroCharge();
            $this->_backendSession->unsCcCurrency();

        } catch (\Exception $e) {

            if ($this->_isDebugModeOn) {
                $remove = 4;
                $this->debugData([
                    "CardHolder"        => $billingAddress['firstname'].' '.$billingAddress['lastname'],
                    "CardNumber"        => "XXXXXXX" . substr($payment->getCcNumber(), ($remove * -1)),
                    "CVC"               => '****',
                    "Expiration"        => sprintf('%02d', $payment->getCcExpMonth()) . $payment->getCcExpYear(),
                    "Amount"            => $amount,
                    'ExceptionMessage'  => $e->getMessage()
                ]);
            }

            $this->_logger->error($e->getMessage());

            throw new \Magento\Framework\Validator\Exception(__($e->getMessage()));
        }
        
        return $this;
    }

    private function _createCardToken($amount, $payment, $billingAddress) 
    {
        $requestData = [
            'account'       => $payment->getCcNumber(),
            'expiry'        => sprintf('%02d', $payment->getCcExpMonth()) . $payment->getCcExpYear(),
            'address'       => $billingAddress['street'],
            'postal'        => $billingAddress["postcode"],
            'cvv2'          => $payment->getCcCid(),
            'merchantId'    => $this->_merchantId,
        ];

        $response = $this->_callApi($this::CREATE_CARD_TOKEN, $requestData);
                
        $this->_customLogger('Create Card Token', $amount, $payment, $billingAddress, $response);

        if ( $response->code == 400 ) {
                    
            throw new \Magento\Framework\Validator\Exception(__("The token for the transaction could not be generated."));

        } elseif ( $response->code == 200 ) {
            
            throw new \Magento\Framework\Validator\Exception(__("A micro charge has been made to your account to validate the credit card. Please enter the amount of the same to continue the process."));

        }

        return $response;
    }

    private function _activateCardToken($amount, $payment, $billingAddress, $microCharge)
    {
        $requestData = [
            'account'   => $payment->getCcNumber(),
            'value'     => $microCharge,
            'currencyCode' => $this->_backendSession->getCcCurrency(),
        ];

        $response = $this->_callApi($this::ACTIVATE_CARD_TOKEN, $requestData);
                
        $this->_customLogger('Activation Card Token', $amount, $payment, $billingAddress, $response);

        if ( $response->code == 400 ) {        
            throw new \Magento\Framework\Validator\Exception(__("Failed to activate token for transaction."));
        }

        return $response;
    }

    private function _makeOnlinePayment($amount, $payment, $billingAddress)
    {
        $requestData = [
            //'amount'        => strval($amount),
            'amount'        => strval(number_format($amount, 2)),
            'expiry'        => sprintf('%02d', $payment->getCcExpMonth()) . $payment->getCcExpYear(),
            'account'       => $payment->getCcNumber(),
            'name'          => $billingAddress['firstname'].' '.$billingAddress['lastname'],
            'merchantId'    => $this->_merchantId,
            'tender'        => $this->_tender,
            'cvv'           => $payment->getCcCid(),
            'zip'           => $billingAddress["postcode"],
            'address'       => $billingAddress["street"],
            'serviceFeeAndTaxes' => [],
            'customFields' => [
                'sucursal' => $this->_storeManagerInterface->getStore()->getWebsite()->getName(),
            ],
            'subchannel'    => 'api'
        ];

        $response = $this->_callApi($this::MAKE_PAYMENT, $requestData);
                
        $this->_customLogger('Make Online Payment', $amount, $payment, $billingAddress, $response);

        if ($response->code != 200) {
        
            throw new \Magento\Framework\Validator\Exception(__("Online payment of the transaction could not be generated."));
        
        } elseif ($response->code == 200 && $response->data->respstat == 'B') {
        
            throw new \Magento\Framework\Validator\Exception(__("Please try again."));
        
        } elseif ($response->code == 200 && $response->data->respstat == 'C') {
            
            throw new \Magento\Framework\Validator\Exception(__("Transaction declined."));

        }

        return $response;
    }

    private function _verifyTimeOut()
    {
        $isValid = FALSE;

        //Get the vars from session.
        $startTime = $this->_backendSession->getStartTime();
        $transactionStartTime = new \DateTime($startTime);

        //Current Time
        $transactionCurrentTime = new \DateTime(date("Y-m-d h:i:s", time()));

        //Get the time spent by the user to send the payment data, in minutes
        $transactionTimeSpent = $transactionStartTime->diff($transactionCurrentTime)->format("%i");
        if ($transactionTimeSpent <= self::TRANSACTION_TIME_OUT) {
            $isValid = TRUE;
        }
        return $isValid;
    }

    private function _callApiCustomUrl($endpoint, $ccNumber) 
    {
        $url = $this->_apiUrl . $endpoint . base64_encode($ccNumber);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "x-api-key: $this->_apiToken",
            "Content-Type: application/json",
        ));

        $server_output = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($server_output);

        if ($result === false || is_null($result)) {
            throw new \Magento\Framework\Validator\Exception(__("Failed transaction, no valid result was received, you should contact support!"));
        }

        return $result;
    }

    private function _callApi($endpoint, $data) 
    {
        $url = $this->_apiUrl . $endpoint;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "x-api-key: $this->_apiToken",
            "Content-Type: application/json",
        ));

        $server_output = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($server_output);

        if ($result === false || is_null($result)) {
            throw new \Magento\Framework\Validator\Exception(__("Failed transaction, no valid result was received, you should contact support!"));
        }

        return $result;
    }

    private function _customLogger($step, $amount, $payment, $billingAddress, $response)
    {
        if ($this->_isDebugModeOn) {
            $remove = 4;

            $this->debugData([
                'Step'          => $step,
                'CardHolder'    => $billingAddress['firstname'].' '.$billingAddress['lastname'],
                'CardNumber'    => "XXXXXXX" . substr($payment->getCcNumber(), ($remove * -1)),
                'Amount'        => $amount,
                'Message'       => (property_exists($response, 'error')) ? $response->error : $response->message,
                'Status'        => $response->status,
                'Code'          => $response->code,
            ]);
        }
    }
}