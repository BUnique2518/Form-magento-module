<?php

namespace Appseconnect\Form\Block\Adminhtml\Grid;

class AddRow extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * Core registry.
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     * @param \Magento\Framework\Registry           $registry
     * @param array                                 $data
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Initialize Imagegallery Images Edit Block.
     */
    protected function _construct()
    {
        $this->_objectId = 'row_id';
        $this->_blockGroup = 'Appseconnect_Form';
        $this->_controller = 'adminhtml_grid';
        parent::_construct();
        if ($this->_isAllowedAction('Appseconnect_Form::add_row')) {
            $this->buttonList->update('save', 'label', __('Save'));
			//$this->buttonList->update('delete', 'label', __('Delete'));
			/* $this->addButton(
								'delete',
								[
									'label' => __('Delete'),
									'onclick' => 'deleteConfirm(' . json_encode(__('Are you sure you want to do this?'))
										. ','
										. json_encode($this->getDeleteUrl()
										)
										. ')',
									'class' => 'scalable delete',
									'level' => -1
								]
							); */
			$this->buttonList->add(
									 'saveandcontinue',
									 [
									 'label' => __('Save and Continue Edit'),
									 'class' => 'save',
									 'data_attribute' => [
									 'mage-init' => [
									 'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form'],
									 ],
									 ]
									 ],
									 -100
								);
        } else {
            $this->buttonList->remove('save');
        }		
		 
        //$this->buttonList->remove('reset');
    }

    /**
     * Retrieve text for header element depending on loaded image.
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        return __('Add New Form');
    }

    /**
     * Check permission for passed action.
     *
     * @param string $resourceId
     *
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }

    /**
     * Get form action URL.
     *
     * @return string
     */
    public function getFormActionUrl()
    {
        if ($this->hasFormActionUrl()) {
            return $this->getData('form_action_url');
        }

        return $this->getUrl('*/*/save');
    }
}
