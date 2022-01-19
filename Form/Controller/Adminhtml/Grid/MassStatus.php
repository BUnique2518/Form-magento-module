<?php
namespace Appseconnect\Form\Controller\Adminhtml\Grid;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Appseconnect\Form\Model\ResourceModel\Grid\CollectionFactory;

/**
* Class MassDelete
*/
class MassStatus extends \Magento\Backend\App\Action
{
   /**
     * Massactions filter.
     * @var Filter
     */
    protected $_filter;

    /**
     * @var CollectionFactory
     */
    protected $_collectionFactory;

    /**
     * @param Context           $context
     * @param Filter            $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory
    ) {

        $this->_filter = $filter;
        $this->_collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

   /**
    * @param AbstractCollection $collection
    * @return \Magento\Backend\Model\View\Result\Redirect
    */
   public function execute()
   {
	   $collection = $this->_filter->getCollection($this->_collectionFactory->create());
       $rateChangeStatus = 0;
       foreach ($collection as $rate) {
           $rate->setStatus($this->getRequest()->getParam('status'))->save();
           $rateChangeStatus++;
       }

       if ($rateChangeStatus) {
           $this->messageManager->addSuccess(__('A total of %1 record(s) were updated.', $rateChangeStatus));
       }
       /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
       $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
       $resultRedirect->setPath($this->getComponentRefererUrl());

       return $resultRedirect;
   }

   /**
    * @return bool
    */
   protected function _isAllowed()
   {
       return $this->_authorization->isAllowed('Appseconnect_Form::Earning_Rates');
   }

}
