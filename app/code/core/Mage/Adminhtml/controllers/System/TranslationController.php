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
 * Translate admin controller
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Mage_Adminhtml_System_TranslationController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Initialize Layout and set breadcrumbs
     *
     * @return Mage_Adminhtml_System_TranslateController
     */
    protected function _initLayout()
    {
        $this->loadLayout()
            ->_setActiveMenu('system/dbtranslation')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Database Translation Editor'), Mage::helper('adminhtml')->__('Database Translation Editor'));
        return $this;
    }

    /**
     * Initialize Translate object
     *
     * @return Mage_Core_Model_Translate
     */
    protected function _initTranslate()
    {
        $this->_title($this->__('System'))->_title($this->__('Database Translation Editor'));

        $translateId = $this->getRequest()->getParam('id', null);
        /* @var $emailVariable Mage_Core_Model_Translate */
        $translation = Mage::getModel('core/translate');
        if ($translateId) {
            $translation->load($translateId);
        }
        Mage::register('current_translation', $translation);
        return $translation;
    }

    /**
     * Index Action
     *
     */
    public function indexAction()
    {
        $this->_title($this->__('System'))->_title($this->__('Database Translation Editor'));

        $this->_initLayout()
            ->_addContent($this->getLayout()->createBlock('adminhtml/system_translation'))
            ->renderLayout();
    }

    /**
     * New Action (forward to edit action)
     *
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * Edit Action
     *
     */
    public function editAction()
    {
        $translation = $this->_initTranslate();

        $this->_title($translation->getId() ? $this->__('Edit Translation: %s',$translation->getString()) : $this->__('New Translation'));

        $this->_initLayout()
            ->_addContent($this->getLayout()->createBlock('adminhtml/system_translation_edit'))
            ->renderLayout();
    }

    /**
     * Save Action
     *
     */
    public function saveAction()
    {
        $translation = $this->_initTranslate();
        $data = $this->getRequest()->getPost('translation');
        $back = $this->getRequest()->getParam('back', false);
        if ($data) {
            $data['key_id'] = $translation->getId();
            $translation->setData($data);
            try {
                $translation->save();
                $this->_getSession()->addSuccess(
                    Mage::helper('adminhtml')->__('The database translation has been saved.')
                );
                if ($back) {
                    $this->_redirect('*/*/edit', array('_current' => true, 'id' => $translation->getId()));
                } else {
                    $this->_redirect('*/*/', array());
                }
                return;
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('_current' => true, ));
                return;
            }
        }
        $this->_redirect('*/*/', array());
        return;
    }

    /**
     * Delete Action
     *
     */
    public function deleteAction()
    {
        $translation = $this->_initTranslate();
        if ($translation->getId()) {
            try {
                $translation->delete();
                $this->_getSession()->addSuccess(
                    Mage::helper('adminhtml')->__('The database translation has been deleted.')
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('_current' => true, ));
                return;
            }
        }
        $this->_redirect('*/*/', array());
        return;
    }

    /**
     * Check current user permission
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('system/dbtranslate');
    }
}
