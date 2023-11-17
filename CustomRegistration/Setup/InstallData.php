<?php
namespace LogosCorp\CustomRegistration\Setup;

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

	public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context )
	{
		$attributes = array();

		$eavSetup = $this->_eavSetupFactory->create(['setup' => $setup]);

		// Promociones y descuentos
		//$eavSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, 'promotions_and_discounts');
		$eavSetup->addAttribute(
			\Magento\Customer\Model\Customer::ENTITY, 'promotions_and_discounts', [
				'type' 					=> 'varchar',
				'label' 				=> 'Promociones y descuentos',
				'input' 				=> 'boolean',
				'required' 				=> false,
				'system' 				=> 0,
				'global' 				=> 1,
				'sort_order' 			=> 999,
				'position' 				=> 999,
				'is_used_in_grid' 		=> true,
				'is_visible_in_grid' 	=> true,
				'is_filterable_in_grid' => true,
				'is_searchable_in_grid' => true,
				'backend' 				=> \Magento\Customer\Model\Attribute\Backend\Data\Boolean::class,
				'default' 				=> 0,
			]
		);
		$attributes[] = $this->_attributeRepository->get('customer', 'promotions_and_discounts');

		// Eventos
		//$eavSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, 'events');
		$eavSetup->addAttribute(
			\Magento\Customer\Model\Customer::ENTITY, 'events', [
				'type' 					=> 'varchar',
				'label' 				=> 'Eventos',
				'input' 				=> 'boolean',
				'required' 				=> false,
				'system' 				=> 0,
				'global' 				=> 1,
				'sort_order' 			=> 999,
				'position' 				=> 999,
				'is_used_in_grid' 		=> true,
				'is_visible_in_grid' 	=> true,
				'is_filterable_in_grid' => true,
				'is_searchable_in_grid' => true,
				'backend' 				=> \Magento\Customer\Model\Attribute\Backend\Data\Boolean::class,
				'default' 				=> 0,
			]
		);
		$attributes[] = $this->_attributeRepository->get('customer', 'events');

		// Bio Insuperables
		//$eavSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, 'bioinsuperables');
		$eavSetup->addAttribute(
			\Magento\Customer\Model\Customer::ENTITY, 'bioinsuperables', [
				'type' 					=> 'varchar',
				'label' 				=> 'Precios #BioInsuperables',
				'input' 				=> 'boolean',
				'required' 				=> false,
				'system' 				=> 0,
				'global' 				=> 1,
				'sort_order' 			=> 999,
				'position' 				=> 999,
				'is_used_in_grid' 		=> true,
				'is_visible_in_grid' 	=> true,
				'is_filterable_in_grid' => true,
				'is_searchable_in_grid' => true,
				'backend' 				=> \Magento\Customer\Model\Attribute\Backend\Data\Boolean::class,
				'default' 				=> 0,
			]
		);
		$attributes[] = $this->_attributeRepository->get('customer', 'bioinsuperables');

		// Acepto los términos y condiciones
		//$eavSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, 'terms_and_conditions');
		$eavSetup->addAttribute(
			\Magento\Customer\Model\Customer::ENTITY, 'terms_and_conditions', [
				'type' 					=> 'varchar',
				'label' 				=> 'Acepto los términos y condiciones',
				'input' 				=> 'boolean',
				'required' 				=> true,
				'system' 				=> 0,
				'global' 				=> 1,
				'sort_order' 			=> 999,
				'position' 				=> 999,
				'is_used_in_grid' 		=> true,
				'is_visible_in_grid' 	=> true,
				'is_filterable_in_grid' => true,
				'is_searchable_in_grid' => true,
				'backend' 				=> \Magento\Customer\Model\Attribute\Backend\Data\Boolean::class,
				'default' 				=> 0,
			]
		);
		$attributes[] = $this->_attributeRepository->get('customer', 'terms_and_conditions');

		foreach ($attributes as $attribute) {
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
}