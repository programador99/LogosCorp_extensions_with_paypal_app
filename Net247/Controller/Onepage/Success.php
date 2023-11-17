<?php

namespace LogosCorp\Net247\Controller\Onepage;

use Magento\Framework\Controller\ResultFactory;

class Success extends \Magento\Checkout\Controller\Onepage\Success
{

    /**
     * Order success action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $this->_paymentSession = $this->_objectManager->get(\Magento\Backend\Model\Session::class);
        $this->_orderManager = $this->_objectManager->get(\Magento\Sales\Api\OrderManagementInterface::class);
        $this->_successValidator = $this->_objectManager->get(\Magento\Checkout\Model\Session\SuccessValidator::class);

        $paymentInfo = $this->_paymentSession->getLogosCorpPaymentResultInfo();

        if (!empty($paymentInfo) && !$paymentInfo["result"]) {
            $orderManager = $this->_orderManager;
            $orderManager->cancel($paymentInfo["order_id"]);

            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            $resultRedirect->setPath('net247-info');
            return $resultRedirect;
        }

        $session = $this->getOnepage()->getCheckout();
        if (!$this->_successValidator->isValid()) {
            return $this->resultRedirectFactory->create()->setPath('checkout/cart');
        }
        $session->clearQuote();
        // @todo: Refactor it to match CQRS
        $resultPage = $this->resultPageFactory->create();
        $this->_eventManager->dispatch(
            'checkout_onepage_controller_success_action',
            [
                'order_ids' => [$session->getLastOrderId()],
                'order' => $session->getLastRealOrder()
            ]
        );
        return $resultPage;
    }
}
