<?php
/**
 * Copyright © 2021 All rights reserved.
 * See COPYING.txt for license details.
 */

namespace PixieMedia\NoWelcomeEmail\Plugin\Frontend\Magento\Customer\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class EmailNotification
{
    const XML_IS_DISABLED = 'nowelcomeemail/options/is_disabled';

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->_scopeConfig = $scopeConfig;
    }

    public function aroundNewAccount(
        \Magento\Customer\Model\EmailNotification $subject,
        \Closure $proceed,
        $customer,
        $type = 'registered',
        $backUrl = '',
        $storeId = 0,
        $sendemailStoreId = null
    ) {
        if (!$this->_scopeConfig->isSetFlag(self::XML_IS_DISABLED, ScopeInterface::SCOPE_STORE)) {
            $result = $proceed($customer, $type, $backUrl, $storeId, $sendemailStoreId);
            return $result;
        }
    }
}
