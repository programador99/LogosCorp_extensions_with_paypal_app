<?php
namespace LogosCorp\StoreLocator\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class InstallData implements InstallDataInterface {

	private $_eavSetupFactory;
	private $_attributeRepository;

	public function __construct(
		\Magento\Eav\Setup\EavSetupFactory $eavSetupFactory,
		\Magento\Eav\Model\AttributeRepository $attributeRepository
	)
	{
		$this->_eavSetupFactory = $eavSetupFactory;
		$this->_attributeRepository = $attributeRepository;
	}

	public function install( ModuleDataSetupInterface $setup, ModuleContextInterface $context )
	{

		$eavSetup = $this->_eavSetupFactory->create(['setup' => $setup]);

		// add preferred_store to customer
		$eavSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, 'preferred_store');
		$eavSetup->addAttribute(
			\Magento\Customer\Model\Customer::ENTITY, 'preferred_store', [
				'type' => 'varchar',
				'label' => 'Preferred Store',
				'input' => 'text',
				'required' => false,
				'system' => 0,
				'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
				'sort_order' => '999'
			]
		);

		// allow preferred_store attribute to be saved in the specific areas
		$attribute = $this->_attributeRepository->get('customer', 'preferred_store');
		$setup->getConnection()
		->insertOnDuplicate(
			$setup->getTable('customer_form_attribute'),
			[
				['form_code' => 'adminhtml_customer', 'attribute_id' => $attribute->getId()],
				['form_code' => 'customer_account_create', 'attribute_id' => $attribute->getId()],
				['form_code' => 'customer_account_edit', 'attribute_id' => $attribute->getId()],
			]
		);
	}
}