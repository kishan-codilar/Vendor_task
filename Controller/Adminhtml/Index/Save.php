<?php
namespace Codilar\Vendor\Controller\Adminhtml\Index;

use Magento\Framework\App\Action\Action;
use Codilar\Vendor\Model\VendorFactory as ModelFactory;
use Codilar\Vendor\Model\ResourceModel\Vendor as ResourceModel;
use Magento\Framework\App\Action\Context;

class Save extends Action
{
    /**
     * @var ModelFactory
     */
    protected $modelFactory;

    /**
     * @var ResourceModel
     */
    protected $resourceModel;

    public function __construct(
        Context $context,
        ModelFactory $modelFactory,
        ResourceModel $resourceModel
    )
    {
        parent::__construct($context);
        $this->modelFactory = $modelFactory;
        $this->resourceModel = $resourceModel;
    }

    public function execute()
    {
            $post = $this->getRequest()->getParams();
            $emptyVendor = $this->modelFactory->create();
            // var_dump($post);
            // die();
            if(!empty($post['entity_id']))
            {
                  $this->resourceModel->load($emptyVendor, $post['entity_id']);
             }
            $emptyVendor->setIsActive($post['is_active'] ?? 1);
            $emptyVendor->setVendorname($post['vendorname'] ?? null);
            $emptyVendor->setWebsite($post['website'] ?? null);
            $emptyVendor->setNumber($post['number'] ?? null);
            $emptyVendor->setEmail($post['email'] ?? null);
            $emptyVendor->setAddress($post['address'] ?? null);
        try {
            $this->resourceModel->save($emptyVendor);
            $this->messageManager->addSuccessMessage(__('Vendor %1 saved successfully', $emptyVendor->getVendorname()));
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage(__("Error saving Vendor"));
        }
        if ($this->getRequest()->getParam('back')) {
            $id = $emptyVendor->getEntityId();
            return $this->resultRedirectFactory->create()->setPath('*/*/form', ['entity_id' => $id, '_current' => true]);
        }
        else{
            return $this->resultRedirectFactory->create()->setPath('*/*/index');
        }
    }
}
