<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Database Translation Edit Form
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Adminhtml_Block_System_Translation_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Getter
     *
     * @return Mage_Core_Model_Translate
     */
    public function getTranslate()
    {
        return Mage::registry('current_translation');
    }

    /**
     * Prepare form before rendering HTML
     *
     * @return Mage_Adminhtml_Block_System_Translation_Edit_Form
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getData('action'),
            'method' => 'post'
        ));

        $fieldset = $form->addFieldset('base', array(
            'legend'=>Mage::helper('adminhtml')->__('Database Translation'),
            'class'=>'fieldset-wide'
        ));

        $fieldset->addField('string', 'text', array(
            'name'     => 'string',
            'label'    => Mage::helper('adminhtml')->__('Original String'),
            'title'    => Mage::helper('adminhtml')->__('Original String'),
            'required' => true,
            'class'    => 'validate-text'
        ));

        $fieldset->addField('translate', 'text', array(
            'name'     => 'translate',
            'label'    => Mage::helper('adminhtml')->__('Translation'),
            'title'    => Mage::helper('adminhtml')->__('Translation'),
            'required' => true
        ));

        $fieldset->addField('store_id', 'select', array(
            'name'   => 'store_id',
            'label'  => Mage::helper('adminhtml')->__('Store view'),
            'title'  => Mage::helper('adminhtml')->__('Store view'),
            'values' => Mage::getModel('adminhtml/system_config_source_store')->toOptionHash()
        ));

        $fieldset->addField('locale', 'select', array(
            'name'   => 'locale',
            'label'  => Mage::helper('adminhtml')->__('Locale'),
            'title'  => Mage::helper('adminhtml')->__('Locale'),
            'values' => Mage::getModel('adminhtml/system_config_source_locale')->toOptionHash()
        ));

        $form->setValues($this->getTranslate()->getData())
            ->addFieldNameSuffix('translation')
            ->setUseContainer(true);

        $this->setForm($form);
        return parent::_prepareForm();
    }

}
