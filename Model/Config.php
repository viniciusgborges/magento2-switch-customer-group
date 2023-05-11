<?php
declare(strict_types=1);

namespace Vbdev\SwitchCustomerGroup\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    const XML_PATH_ENABLE = 'switch_customer_group/switch_customer_group_config/enabled';
    const XML_PATH_AFTER_ACCOUNT_CREATION_ACTION = 'switch_customer_group/switch_customer_group_config/after_account_creation_action';
    const XML_PATH_AFTER_ORDER_ACTION = 'switch_customer_group/switch_customer_group_config/after_order_action';
    const XML_PATH_AFTER_SIGN_IN_ACTION = 'switch_customer_group/switch_customer_group_config/after_sign_in_action';
    const XML_PATH_AFTER_ACCOUNT_CREATION_SOURCE_GROUP_SELECTED = 'switch_customer_group/switch_customer_group_config/after_account_creation_source_group_selected';
    const XML_PATH_AFTER_ACCOUNT_CREATION_TARGET_GROUP_SELECTED = 'switch_customer_group/switch_customer_group_config/after_account_creation_target_group_selected';
    const XML_PATH_AFTER_ORDER_SOURCE_GROUP_SELECTED = 'switch_customer_group/switch_customer_group_config/after_order_source_group_selected';
    const XML_PATH_AFTER_ORDER_TARGET_GROUP_SELECTED = 'switch_customer_group/switch_customer_group_config/after_order_target_group_selected';
    const XML_PATH_AFTER_SIGN_IN_SOURCE_GROUP_SELECTED = 'switch_customer_group/switch_customer_group_config/after_sign_in_source_group_selected';
    const XML_PATH_AFTER_SIGN_IN_TARGET_GROUP_SELECTED = 'switch_customer_group/switch_customer_group_config/after_sign_in_target_group_selected';
    private ScopeConfigInterface $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return mixed
     */
    public function getSwitchCustomerGroupEnabled()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_ENABLE, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function getAfterAccountCreationAction()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_AFTER_ACCOUNT_CREATION_ACTION, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function getAfterOrderAction()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_AFTER_ORDER_ACTION, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function getAfterSignInAction()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_AFTER_SIGN_IN_ACTION, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function getAfterAccountCreationSourceGroupSelected()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_AFTER_ACCOUNT_CREATION_SOURCE_GROUP_SELECTED, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function getAfterAccountCreationTargetGroupSelected()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_AFTER_ACCOUNT_CREATION_TARGET_GROUP_SELECTED, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function getAfterOrderSourceGroupSelected()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_AFTER_ORDER_SOURCE_GROUP_SELECTED, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function getAfterOrderTargetGroupSelected()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_AFTER_ORDER_TARGET_GROUP_SELECTED, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function getAfterSignInSourceGroupSelected()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_AFTER_SIGN_IN_SOURCE_GROUP_SELECTED, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return mixed
     */
    public function getAfterSignInTargetGroupSelected()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_AFTER_SIGN_IN_TARGET_GROUP_SELECTED, ScopeInterface::SCOPE_STORE);
    }
}
