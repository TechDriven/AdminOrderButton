<?php
declare(strict_types=1);

namespace TechDriven\AdminOrderButton\Controller\Adminhtml\Order;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Sales\Controller\Adminhtml\Order\AbstractMassAction;
use Magento\Ui\Component\MassAction\Filter;
use TechDriven\AdminOrderButton\Model\AddOrderComment;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use Magento\Framework\Controller\ResultFactory;
class MassOrderComment extends AbstractMassAction
{
    private AddOrderComment $addOrderComment;

    public function __construct(
        Context $context,
        Filter $filter,
        AddOrderComment $addOrderComment,
        CollectionFactory $collectionFactory
    ) {
        parent::__construct($context, $filter);
        $this->collectionFactory = $collectionFactory;
        $this->addOrderComment = $addOrderComment;
    }

    protected function massAction(AbstractCollection $collection)
    {
        $updated = 0;
        foreach ($collection->getItems() as $order) {
            try {
                $this->addOrderComment->addComment($order);
                $updated++;
            } catch (\Exception $exception) {
                $this->messageManager->addErrorMessage(__('Cannot update comment form order #%1. Please try again later.', $order->getIncrementId()));
            }
        }
        if ($updated) {
            $this->messageManager->addSuccessMessage(__('Comment for %1 order(s) have been updated.', $updated));
        }

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath($this->getComponentRefererUrl());

        return $resultRedirect;
    }
}
