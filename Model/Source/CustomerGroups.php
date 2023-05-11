<?php
declare(strict_types=1);

namespace Vbdev\SwitchCustomerGroup\Model\Source;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Customer\Model\ResourceModel\Group\Collection;
use Magento\Framework\Data\OptionSourceInterface;

class CustomerGroups extends Template implements OptionSourceInterface
{

    /**
     * @var Collection
     */
    protected Collection $customerGroupCollection;

    /**
     * @param Context $context
     * @param Collection $customerGroupColl
     * @param array $data
     */
    public function __construct(
        Context    $context,
        Collection $customerGroupColl,
        array      $data = []
    ) {
        $this->customerGroupCollection = $customerGroupColl;
        parent::__construct($context, $data);
    }

    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        return $this->customerGroupCollection->toOptionArray();
    }
}
