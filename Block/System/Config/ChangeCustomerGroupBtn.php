<?php
declare(strict_types=1);

namespace Vbdev\SwitchCustomerGroup\Block\System\Config;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Data\Form\FormKey;
use Magento\Framework\Exception\LocalizedException;
use Vbdev\SwitchCustomerGroup\Model\Config;

class ChangeCustomerGroupBtn extends Field
{
    protected $_template = 'system/config/changeCustomerGroupBtn.phtml';

    private Config $customerGroupConfig;

    /**
     * @param Context $context
     * @param Config $customerGroupConfig
     * @param FormKey $formKey
     * @param array $data
     */
    public function __construct(
        Context $context,
        Config  $customerGroupConfig,
        FormKey $formKey,
        array   $data = []
    ) {
        $this->customerGroupConfig = $customerGroupConfig;
        $this->formKey = $formKey;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     * @throws LocalizedException
     */
    public function getFormKey(): string
    {
        return $this->formKey->getFormKey();
    }

    /**
     * @return mixed
     */
    public function getEnabled()
    {
        return $this->customerGroupConfig->getSwitchCustomerGroupEnabled();
    }

    /**
     * Remove scope label
     *
     * @param AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element): string
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }

    /**
     * Return element html
     *
     * @param AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element): string
    {
        return $this->_toHtml();
    }

    /**
     * @return string
     */
    public function getAjaxUrl(): string
    {
        return $this->getUrl('changecustomer/group');
    }

    /**
     * @return mixed
     * @throws LocalizedException
     */
    public function getButtonHtml()
    {
        $button = $this->getLayout()->createBlock(
            'Magento\Backend\Block\Widget\Button'
        )->setData([
            'id' => 'vbdev_change_customer_group',
            'label' => __('Change Customer Group')
        ]);

        return $button->toHtml();
    }
}
