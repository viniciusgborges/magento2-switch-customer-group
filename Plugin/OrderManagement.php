<?php
declare(strict_types=1);

namespace Vbdev\SwitchCustomerGroup\Plugin;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderManagementInterface;
use Psr\Log\LoggerInterface;
use Vbdev\SwitchCustomerGroup\Model\Config as SwitchCustomerGroupConfig;

class OrderManagement
{
    protected LoggerInterface $logger;

    protected CustomerRepositoryInterface $customerRepository;

    protected SwitchCustomerGroupConfig $switchCustomerGroupConfig;

    /**
     * @param CustomerRepositoryInterface $customerRepository
     * @param LoggerInterface $logger
     * @param SwitchCustomerGroupConfig $switchCustomerGroupConfig
     */
    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        LoggerInterface             $logger,
        SwitchCustomerGroupConfig   $switchCustomerGroupConfig
    ) {
        $this->customerRepository = $customerRepository;
        $this->logger = $logger;
        $this->switchCustomerGroupConfig = $switchCustomerGroupConfig;
    }

    /**
     * Change the customer group of a customer when they are place order in based on the configuration settings.
     * @param OrderManagementInterface $subject
     * @param OrderInterface $result
     * @return OrderInterface
     */
    public function afterPlace(OrderManagementInterface $subject, OrderInterface $result): OrderInterface
    {
        if (!$this->switchCustomerGroupConfig->getSwitchCustomerGroupEnabled() || !$this->switchCustomerGroupConfig->getAfterOrderAction()) {
            return $result;
        }

        $customer = $this->getCustomerById($result->getCustomerId());
        if (!$customer || $customer->getGroupId() != $this->switchCustomerGroupConfig->getAfterOrderSourceGroupSelected()) {
            return $result;
        }

        try {
            $customer->setGroupId($this->switchCustomerGroupConfig->getAfterOrderTargetGroupSelected());
            $this->customerRepository->save($customer);
        } catch (LocalizedException $e) {
            $this->logger->error($e->getMessage(), ['exception' => $e]);
        }

        return $result;
    }

    /**
     * @param $customerId
     * @return false|CustomerInterface
     */
    private function getCustomerById($customerId)
    {
        try {
            return $this->customerRepository->getById($customerId);
        } catch (LocalizedException $exception) {
            $this->logger->error('Error occurred while loading customer by ID: ' . $customerId . ' with error: ' . $exception->getMessage());
            return false;
        }
    }
}
