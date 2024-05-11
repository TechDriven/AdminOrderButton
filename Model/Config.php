<?php
declare(strict_types=1);

namespace TechDriven\AdminOrderButton\Model;



use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Api\Data\StoreConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    public const XML_PATH_ORDER_COMMENT_ENABLE = 'td_order_comment_button/general/enable';
    public const XML_PATH_ORDER_COMMENT_TEXT = 'td_order_comment_button/general/comment';

    public function __construct(
        protected ScopeConfigInterface $scopeConfig
    ){}

    public function getIsOrderButtonEnable()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_ORDER_COMMENT_ENABLE,
            ScopeInterface::SCOPE_STORE
        );
    }

    public function getOrderComment()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_ORDER_COMMENT_TEXT,
            ScopeInterface::SCOPE_STORE
        );
    }
}
