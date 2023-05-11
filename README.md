# Magento 2.4.x module for Switch Customer Group

    composer require vbdev/magento2-switch-customer-group

## Main Functionalities
- The module offers a configuration in the admin, in **Stores->Configuration->VBDEV->Switch Customer Group**
- The module provides functionality to change customer groups based on three actions that can be chosen by the shopkeeper.

![change consumer groups based on actions](https://i.imgur.com/8TW9eZS.png)

- The module also provides the possibility to change customer groups by customer id quickly.

![change customer groups by customer id](https://i.imgur.com/T6ENsE7.png)

## Install
### Type 1: Zip file

- Unzip the zip file in `app/code/Vbdev`
- Enable the module by running `bin/magento module:enable Vbdev_SwitchCustomerGroup`
- Apply database updates by running `bin/magento setup:upgrade`
- Flush the cache by running `bin/magento cache:flush`

### Type 2: Composer

- Install the module composer by running `composer require vbdev/magento2-switch-customer-group`
- enable the module by running `bin/magento module:enable Vbdev_SwitchCustomerGroup`
- apply database updates by running `bin/magento setup:upgrade`
- Flush the cache by running `bin/magento cache:flush`
