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
 * Database Translation Edit Container
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author     Magento Core Team <core@magentocommerce.com>
 */

class Mage_Adminhtml_Block_System_Translation_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Internal constructor
     *
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_objectId = 'id';
        $this->_controller = 'system_translation';
    }

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
     * Prepare layout.
     * Adding save_and_continue button
     *
     * @return Mage_Adminhtml_Block_System_Translation_Edit
     */
    protected function _preparelayout()
    {
        $this->_addButton('save_and_edit', array(
            'label'     => Mage::helper('adminhtml')->__('Save and Continue Edit'),
            'class'     => 'save',
            'onclick'   => 'editForm.submit(\'' . $this->getSaveAndContinueUrl() . '\');'
        ), 100);
        if (!$this->getTranslate()->getId()) {
            $this->removeButton('delete');
        }
        return parent::_prepareLayout();
    }

    /**
     * Return translated header text depending on creating/editing action
     *
     * @return string
     */
    public function getHeaderText()
    {
        if ($this->getTranslate()->getId()) {
            return Mage::helper('adminhtml')->__('Database Translation: "%s"', $this->escapeHtml($this->getTranslate()->getString()));
        }
        else {
            return Mage::helper('adminhtml')->__('New Database Translation');
        }
    }

    /**
     * Return save url for edit form
     *
     * @return string
     */
    public function getSaveUrl()
    {
        return $this->getUrl('*/*/save', array('_current' => true, 'back' => null));
    }

    /**
     * Return save and continue url for edit form
     *
     * @return string
     */
    public function getSaveAndContinueUrl()
    {
        return $this->getUrl('*/*/save', array('_current' => true, 'back' => 'edit'));
    }
}
