<?php
declare(strict_types=1);

namespace TechDriven\AdminOrderButton\Controller\Adminhtml\Order;

use Magento\Backend\App\Action;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\Result\RawFactory;
use Magento\Framework\Registry;
use Magento\Framework\Translate\InlineInterface;
use Magento\Framework\View\Result\LayoutFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Sales\Api\OrderManagementInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Controller\Adminhtml\Order;
use Psr\Log\LoggerInterface;
use TechDriven\AdminOrderButton\Model\AddOrderComment;

class AddComment extends Order
{
    private AddOrderComment $addOrderComment;

    public function __construct(
        Action\Context $context,
        Registry $coreRegistry,
        FileFactory $fileFactory,
        InlineInterface $translateInline,
        PageFactory $resultPageFactory,
        JsonFactory $resultJsonFactory,
        LayoutFactory $resultLayoutFactory,
        RawFactory $resultRawFactory,
        OrderManagementInterface $orderManagement,
        OrderRepositoryInterface $orderRepository,
        LoggerInterface $logger,
        AddOrderComment $addOrderComment
    ) {
        parent::__construct($context, $coreRegistry, $fileFactory, $translateInline, $resultPageFactory, $resultJsonFactory, $resultLayoutFactory, $resultRawFactory, $orderManagement, $orderRepository, $logger);
        $this->addOrderComment = $addOrderComment;
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            $orderObject = $this->_initOrder();
            $this->addOrderComment->addComment($orderObject);
            $this->messageManager->addSuccessMessage(__('Comment updated successfully!'));
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
        }
        return $resultRedirect->setPath('sales/order/view',
            ['order_id' => $this->getRequest()->getParam('order_id')]);
    }
}
