<?php
declare(strict_types=1);

namespace TechDriven\AdminOrderButton\Plugin\Ui\Component\MassAction;

use TechDriven\AdminOrderButton\Model\Config;

class CommentAction
{
    public function __construct(
        protected Config $config
    ){}

    public function afterGetChildComponents(
        \Magento\Ui\Component\MassAction $subject,
        $result
    ) {
        if (isset($result['td_massordercomment']) &&
            !$this->config->getIsOrderButtonEnable()
        ) {
            unset($result['td_massordercomment']);
        }
        return $result;
    }
}
