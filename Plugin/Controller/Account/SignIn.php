<?php
declare(strict_types=1);

namespace Vbdev\SwitchCustomerGroup\Plugin\Controller\Account;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Controller\Account\LoginPost;
use Magento\Customer\Model\Session;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;
use Vbdev\SwitchCustomerGroup\Model\Config as SwitchCustomerGroupConfig;

class SignIn
{
    protected LoggerInterface $logger;

    protected CustomerRepositoryInterface $customerRepository;

    protected SwitchCustomerGroupConfig $switchCustomerGroupConfig;

    private Session $customerSession;

    /**
     * @param Session $customerSession
     * @param CustomerRepositoryInterface $customerRepository
     * @param LoggerInterface $logger
     * @param SwitchCustomerGroupConfig $switchCustomerGroupConfig
     */
    public function __construct(
        Session                     $customerSession,
        CustomerRepositoryInterface $customerRepository,
        LoggerInterface             $logger,
        SwitchCustomerGroupConfig   $switchCustomerGroupConfig
    ) {
        $this->customerSession = $customerSession;
        $this->customerRepository = $customerRepository;
        $this->logger = $logger;
        $this->switchCustomerGroupConfig = $switchCustomerGroupConfig;
    }

    /**
     * Change the customer group of a customer when they log in based on the configuration settings.
     * @param LoginPost $subject
     * @param $result
     * @return mixed
     * @throws LocalizedException
     */
    public function afterExecute(
        LoginPost $subject,
        $result
    ) {
        if (!$this->switchCustomerGroupConfig->getSwitchCustomerGroupEnabled() || !$this->switchCustomerGroupConfig->getAfterSignInAction()) {
            return $result;
        }
        $customer = $this->getCustomerById($this->customerSession->getCustomerId());

        if (!$customer || $customer->getGroupId() != $this->switchCustomerGroupConfig->getAfterSignInSourceGroupSelected()) {
            return $result;
        }

        try {
            $customer->setGroupId($this->switchCustomerGroupConfig->getAfterSignInTargetGroupSelected());
            $this->customerRepository->save($customer);
        } catch (LocalizedException $exception) {
            $errorMessage = 'Failed to switch customer group after sign-in: ' . $exception->getMessage();
            $this->logger->error($errorMessage);
            throw new LocalizedException(__($errorMessage));
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
