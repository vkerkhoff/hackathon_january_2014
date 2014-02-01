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
 * Stock Productalert Grid Container
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author     Magento Core Team <core@magentocommerce.com>
 */

class Mage_Adminhtml_Block_Productalert_Stock_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Internal constructor
     *
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('productalertStockGrid');
        $this->setDefaultSort('alert_stock_id');
        $this->setDefaultDir('ASC');
        $this->setUseAjax(true);
        $this->setSaveParametersInSession(true);

    }

    /**
     * Prepare grid collection object
     *
     * @return Mage_Adminhtml_Block_System_Variable_Grid
     */
    protected function _prepareCollection()
    {
        /* @var $collection Mage_Productalert_Model_Resource_Stock_Collection */
        $collection = Mage::getModel('productalert/stock')->getCollection();
        // Join with customer
        $tbl_customer = Mage::getSingleton('core/resource')->getTableName('customer_entity');
        $collection->getSelect()->join(array('customer'=>$tbl_customer),'main_table.customer_id=customer.entity_id',array('customer_email'=>'email'));

        // Join with product
        $tbl_product = Mage::getSingleton('core/resource')->getTableName('catalog_product_entity');
        $collection->getSelect()->join(array('product'=>$tbl_product),'main_table.product_id=product.entity_id',array('product_sku'=>'sku'));

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Prepare grid columns
     *
     * @return Mage_Adminhtml_Block_System_Variable_Grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn('alert_stock_id', array(
            'header'    => Mage::helper('adminhtml')->__('Alert ID'),
            'width'     => '1',
            'index'     => 'alert_stock_id',
        ));

        $this->addColumn('add_date', array(
            'header'    => Mage::helper('adminhtml')->__('Add date'),
            'width'     => '150px',
            'type'      => 'datetime',
            'index'     => 'add_date',
        ));

        $this->addColumn('customer_id', array(
            'header'    => Mage::helper('adminhtml')->__('Customer ID'),
            'width'     => '80px',
            'type'      => 'number',
            'index'     => 'customer_id',
        ));

        $this->addColumn('customer_email', array(
            'header'    => Mage::helper('adminhtml')->__('Customer E-mail'),
            'index'     => 'customer_email',
            'filter_index'   => 'customer.email',
        ));

        $this->addColumn('product_sku', array(
            'header'    => Mage::helper('adminhtml')->__('SKU'),
            'index'     => 'product_sku',
            'filter_index'   => 'product.sku',
        ));

        $this->addColumn('website_id', array(
            'header'    => Mage::helper('customer')->__('Website'),
            'align'     => 'center',
            'width'     => '180px',
            'type'      => 'options',
            'options'   => Mage::getSingleton('adminhtml/system_store')->getWebsiteOptionHash(false),
            'index'     => 'website_id',
            'filter_index' => 'main_table.website_id',
        ));

        $this->addColumn('send_date', array(
            'header'    => Mage::helper('adminhtml')->__('Send date'),
            'width'     => '150px',
            'type'      => 'datetime',
            'index'     => 'send_date',
        ));

        $this->addColumn('send_count', array(
            'header'    => Mage::helper('adminhtml')->__('Send Count'),
            'width'     => '1',
            'index'     => 'send_count',
        ));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('alert_stock_id');
        $this->getMassactionBlock()->setUseSelectAll(true);


        $this->getMassactionBlock()->addItem('delete_productalert', array(
            'label'=> Mage::helper('productalert')->__('Delete Productalert'),
            'url'  => $this->getUrl('*/*/massDeleteProductalert'),
        ));

        return $this;
    }

    /**
     * Row click url
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return false;
    }

    /**
     * Grid url
     *
     * @return string
     */

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }
}
