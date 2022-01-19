<?php
namespace Appseconnect\Form\Controller\Adminhtml\Grid;

use Magento\Framework\App\Filesystem\DirectoryList;

class Save extends \Magento\Backend\App\Action
{
    var $gridFactory;
	
	/**
	* @var \Magento\Framework\Image\AdapterFactory
	*/
	protected $adapterFactory;
	/**
	* @var \Magento\MediaStorage\Model\File\UploaderFactory
	*/
	protected $uploader;
	/**
	* @var \Magento\Framework\Filesystem
	*/
	protected $filesystem;
	/**
	* @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
	*/
	protected $timezoneInterface;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Appseconnect\Form\Model\GridFactory $gridFactory,
		\Magento\Framework\Image\AdapterFactory $adapterFactory,
		\Magento\MediaStorage\Model\File\UploaderFactory $uploader,
		\Magento\Framework\Filesystem $filesystem
    ) {
        parent::__construct($context);
        $this->gridFactory = $gridFactory;
		$this->adapterFactory = $adapterFactory;
		$this->uploader = $uploader;
		$this->filesystem = $filesystem;
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
//		/* for upload image */
//		$uploader = $this->uploader->create(['fileId' => 'image']);
//
//		$uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
//
//		$uploader->setAllowRenameFiles(true);
//
//		$uploader->setFilesDispersion(false);
//
//		$path = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath('images/');
//
//		$uploader->save($path);
//
     /* echo "<pre>";
     print_r($uploader);
     exit(); */
        // $rowId = (int) $this->getRequest()->getParam('id');
        // echo '<pre>'; print_r($rowId); die();
		$resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
		
		//$imagePath = 'images/' . $uploader['file'];
        //$data['image'] = $imagePath;
        if (!$data) {
            $this->_redirect('grid/grid/addrow');
            return;
        }
        try {
            $rowData = $this->gridFactory->create();
            $rowData->setData($data);
            if (isset($data['id'])) {
                $rowData->setId($data['id']);
            }
            $rowData->save();
            $this->messageManager->addSuccess(__('Form data has been successfully saved.'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
		if ($this->getRequest()->getParam('back')) {
			return $resultRedirect->setPath('*/*/addrow', ['id' => $rowData->getId(), '_current' => true]);
		}
        //$this->_redirect('grid/grid/index');
		return $resultRedirect->setPath('*/*/');
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Appseconnect_Form::save');
    }
}
