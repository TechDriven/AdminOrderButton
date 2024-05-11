<?php
declare(strict_types=1);

namespace TechDriven\AdminOrderButton\Plugin\Sales\Block\Order\View;

use Magento\Framework\View\LayoutInterface;
use Magento\Sales\Block\Adminhtml\Order\View;
use TechDriven\AdminOrderButton\Model\Config;

class AddCommentButton
{
    public function __construct(
        protected Config $config
    ){}

    public function beforeSetLayout(
        View $subject,
        LayoutInterface $layout
    ) {
        if ($this->config->getIsOrderButtonEnable()) {
            $subject->addButton(
                'add_comment_button',
                [
                    'label' => __('Add Comment'),
                    'class' => 'save primary add-comment-btn',
                    'id' => 'add-comment-btn',
                    'onclick' => 'setLocation(\'' . $subject->getUrl(
                            'td-order/*/addcomment',
                            [
                                'ret' => $subject->getRequest()->getParam('order_id'),
                            ]
                        ) . '\')'
                ]
            );
        }
        return [$layout];
    }
}
