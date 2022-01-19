<?php

namespace Codilar\Vendor\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\View\Result\PageFactory;
Use Codilar\Vendor\Helper\Data;
Use Codilar\Vendor\Block\Vendor;

class Index extends Action
{
    /**
     * @var PageFactory
     */
    protected $pageFactory;

    /**
     * @var Data
     */
    protected $enableData;
     /**
     * @var Vendor
     */
    protected $VendorId;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        Data $enableData,
        Vendor $VendorId
    )
    {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
        $this->enableData=$enableData;
        $this->VendorId=$VendorId;
    }

    /**
     * Execute action based on request and return result
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        if($this->enableData->isEnable()) {
            return $this->pageFactory->create();
        }
        else {
            return $this->resultRedirectFactory->create()->setPath('cms/noroute/index');
        }

    }
}