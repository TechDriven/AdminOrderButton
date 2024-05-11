<?php
declare(strict_types=1);

namespace TechDriven\AdminOrderButton\Model;

use Magento\Sales\Api\OrderRepositoryInterface;

class AddOrderComment
{
    protected $comment;
    public function __construct(
        protected OrderRepositoryInterface $orderRepository,
        protected Config $config
    ){}

    public function addComment(\Magento\Sales\Model\Order $orderObj)
    {
        $orderObj->addCommentToStatusHistory($this->getComment());
        $this->orderRepository->save($orderObj);
    }
    private function getComment()
    {
        if (isset($this->comment)) {
            return $this->comment;
        }
        return $this->comment = $this->config->getOrderComment();
    }
}
