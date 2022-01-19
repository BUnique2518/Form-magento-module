<?php

namespace Appseconnect\Form\Model\ResourceModel\Grid;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';
    /**
     * Define resource model.
     */
    protected function _construct()
    {
        $this->_init(
            'Appseconnect\Form\Model\Grid',
            'Appseconnect\Form\Model\ResourceModel\Grid'
        );
    }
}
