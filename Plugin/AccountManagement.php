<?php
declare(strict_types=1);

namespace Vbdev\SwitchCustomerGroup\Plugin;

use Magento\Customer\Api\AccountManagementInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;
use Vbdev\SwitchCustomerGroup\Model\Config as SwitchCustomerGroupConfig;

class AccountManagement
{
    private CustomerRepositoryInterface $customerRepository;

    private LoggerInterface $logger;

    private SwitchCustomerGroupConfig $switchCustomerGroupConfig;

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
     * @param AccountManagementInterface $subject
     * @param CustomerInterface $customer
     * @return CustomerInterface
     */
    public function afterCreateAccount(
        AccountManagementInterface $subject,
        CustomerInterface $customer
    ): CustomerInterface {
        if (!$this->switchCustomerGroupConfig->getSwitchCustomerGroupEnabled() || !$this->switchCustomerGroupConfig->getAfterAccountCreationAction()) {
            return $customer;
        }

        if ($customer->getGroupId() != $this->switchCustomerGroupConfig->getAfterAccountCreationSourceGroupSelected()) {
            return $customer;
        }

        try {
            $customer->setGroupId($this->switchCustomerGroupConfig->getAfterAccountCreationTargetGroupSelected());
            $this->customerRepository->save($customer);
        } catch (LocalizedException $exception) {
            $this->logger->error("Error updating customer group on account creation", [
                    'customer_id' => $customer->getId(),
                    'customer_email' => $customer->getEmail(),
                    'error_message' => $exception->getMessage(),
                ]);
            throw new \RuntimeException("Error updating customer group on account creation");
        }

        return $customer;
    }
}
