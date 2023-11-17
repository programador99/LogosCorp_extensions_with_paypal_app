<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace LogosCorp\PaymentInstructions\Block\Info;

/**
 * Block for Bank Transfer payment generic info
 *
 * @api
 * @since 100.0.2
 */
class Instructions extends \Magento\Payment\Block\Info
{
    /**
     * Instructions text
     *
     * @var string
     */
    protected $_instructions;

    /**
     * @var string
     */
    protected $_template = 'LogosCorp_PaymentInstructions::info/instructions.phtml';

    /**
     * Get relevant path to template
     *
     * @return string
     */
    public function getTemplate()
    {
        return $this->_template;
    }

     /**
     * Get absolute path to template
     *
     * @param string|null $template
     * @return string|bool
     */
    public function getTemplateFile($template = null)
    {
        $params = ['module' => $this->getModuleName()];
        $area = $this->getArea();
        if ($area) {
            $params['area'] = $area;
        }
        return $this->resolver->getTemplateFileName($template ?: $this->getTemplate(), $params);
    }
    
    /**
     * Get instructions text from order payment
     * (or from config, if instructions are missed in payment)
     *
     * @return string
     */
    public function getInstructions()
    {
        if ($this->_instructions === null) {
            $this->_instructions = $this->getInfo()->getAdditionalInformation(
                'instructions'
            ) ?: trim($this->getMethod()->getConfigData('instructions'));
        }
        return $this->_instructions;
    }
}
