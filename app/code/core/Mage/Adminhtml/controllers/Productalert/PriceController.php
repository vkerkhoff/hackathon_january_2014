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
 * Price Productalert controller
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Adminhtml_Productalert_PriceController extends Mage_Adminhtml_Controller_Action
{

    /**
     * Price Product Alert list.
     */
    public function indexAction()
    {
        $this->_title($this->__('Customers'))->_title($this->__('Productalert'))->_title($this->__('Price'));

        $this->loadLayout();
        $this->_setActiveMenu('customer/productalert/price');
        $this->_addBreadcrumb(Mage::helper('customer')->__('Customers'), Mage::helper('customer')->__('Customers'));
        $this->_addBreadcrumb(Mage::helper('customer')->__('Productalert'), Mage::helper('customer')->__('Productalert'));
        $this->_addBreadcrumb(Mage::helper('customer')->__('Price'), Mage::helper('customer')->__('Price'));
        $this->_addContent($this->getLayout()->createBlock('adminhtml/productalert_price'));
        $this->renderLayout();
    }

    /**
     * Grid action
     */

    public function gridAction(){
        $this->loadLayout();
        $this->getResponse()->setBody($this->getLayout()->createBlock('adminhtml/productalert_price_grid')
            ->toHtml());
    }

    /**
     * Delete customer group action
     */
    public function massDeleteProductalertAction()
    {
        $alerts = $this->getRequest()->getPost('alert_price_id',array());
        $collection = Mage::getResourceModel('productalert/price_collection')
            ->addFieldToFilter('alert_price_id',array('in'=>$alerts));

        try{
            foreach($collection as $alert){
                $alert->delete();
            }
            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('productalert')->__('The selected alerts have been deleted.'));
        }catch(Exception $ex){
            Mage::getSingleton('adminhtml/session')->addError($ex->getMessage());
        }
        $this->_redirect('*/*/');
    }

    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('customer/productalert/price');
    }
}
