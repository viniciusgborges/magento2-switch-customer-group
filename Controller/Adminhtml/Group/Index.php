<?php
declare(strict_types=1);

namespace Vbdev\SwitchCustomerGroup\Controller\Adminhtml\Group;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;
use Vbdev\SwitchCustomerGroup\Model\Config as SwitchCustomerGroupConfig;

class Index extends Action
{
    protected LoggerInterface $logger;

    protected CustomerRepositoryInterface $customerRepository;

    protected SwitchCustomerGroupConfig $switchCustomerGroupConfig;

    private JsonFactory $resultJsonFactory;

    /**
     * @param Context $context
     * @param CustomerRepositoryInterface $customerRepository
     * @param JsonFactory $resultJsonFactory
     * @param LoggerInterface $logger
     * @param SwitchCustomerGroupConfig $switchCustomerGroupConfig
     */
    public function __construct(
        Context                     $context,
        CustomerRepositoryInterface $customerRepository,
        JsonFactory                 $resultJsonFactory,
        LoggerInterface             $logger,
        SwitchCustomerGroupConfig   $switchCustomerGroupConfig
    ) {
        $this->customerRepository = $customerRepository;
        $this->logger = $logger;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->switchCustomerGroupConfig = $switchCustomerGroupConfig;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultJson = $this->resultJsonFactory->create();
        $responseData = [
            'response' => 'Fail',
            'customer_ids' => []
        ];

        if (!$this->switchCustomerGroupConfig->getSwitchCustomerGroupEnabled()) {
            return $resultJson->setData($responseData);
        }

        $customerIds = explode(',', $this->getRequest()->getParam('customersId'));

        foreach ($customerIds as $customerId) {
            $customer = $this->getCustomerById($customerId);
            if (!$customer) {
                $responseData['customer_ids'][] = $customerId;
                continue;
            }
            if ($customer->getGroupId() !== $this->getRequest()->getParam('sourceGroup')) {
                continue;
            }
            try {
                $customer->setGroupId($this->getRequest()->getParam('targetGroup'));
                $this->customerRepository->save($customer);
            } catch (LocalizedException $exception) {
                $this->logger->error($exception);
                return $resultJson->setData($responseData);
            }
        }
        $responseData['response'] = 'Success';
        return $resultJson->setData($responseData);
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
