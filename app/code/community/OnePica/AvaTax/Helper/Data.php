<?php
/**
 * OnePica_AvaTax
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0), a
 * copy of which is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   OnePica
 * @package    OnePica_AvaTax
 * @author     OnePica Codemaster <codemaster@onepica.com>
 * @copyright  Copyright (c) 2009 One Pica, Inc.
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */

/**
 * The base AvaTax Helper class
 *
 * @category   OnePica
 * @package    OnePica_AvaTax
 * @author     OnePica Codemaster <codemaster@onepica.com>
 */
class OnePica_AvaTax_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Xml path to taxable_country config
     */
    const XML_PATH_TO_TAX_AVATAX_TAXABLE_COUNTRY = 'tax/avatax/taxable_country';

    /**
     * Identifier for error message
     */
    const CALCULATE_ERROR_MESSAGE_IDENTIFIER = 'avatax_calculate_error';

    /**
     * Identifier for validation notice
     */
    const VALIDATION_NOTICE_IDENTIFIER = 'avatax_validation_notice';

    /**
     * Check if avatax extension is enabled
     *
     * @param null|bool|int|Mage_Core_Model_Store $store $store
     * @return bool
     */
    public function isAvataxEnabled($store = null)
    {
        return ($this->_getConfig('action', $store) != OnePica_AvaTax_Model_Config::ACTION_DISABLE);
    }

    /**
     * Gets the documenation url
     *
     * @return string
     */
    public function getDocumentationUrl()
    {
        return 'http://www.onepica.com/magento-extensions/avatax/';
    }

    /**
     * Loads a class from the AvaTax library.
     *
     * @param string $className
     * @return OnePica_AvaTax_Helper_Data
     */
    public function loadClass($className)
    {
        require_once $this->getLibPath() . DS . 'classes' . DS . $className . '.class.php';
        return $this;
    }

    /**
     * Loads an array of AvaTax classes.
     *
     * @param array $classes
     * @return OnePica_AvaTax_Helper_Data
     */
    public function loadClasses(array $classes)
    {
        foreach ($classes as $class) {
            $this->loadClass($class);
        }
        return $this;
    }

    /**
     * Load functions required to work with Avalara API
     *
     * @return $this
     */
    public function loadFunctions()
    {
        require_once $this->getLibPath() . DS . 'functions.php';
        return $this;
    }

    /**
     * Returns the path to the etc directory.
     *
     * @return string
     */
    public function getEtcPath ()
    {
        return dirname(dirname(__FILE__)) . DS . 'etc';
    }

    /**
     * Returns the path to the AvaTax SDK lib directory.
     *
     * @return string
     */
    public function getLibPath ()
    {
        return Mage::getModuleDir('', 'OnePica_AvaTax') . DS . 'lib';
    }

    /**
     * Returns the path to the AvaTax SDK WSDL directory.
     *
     * @return string
     */
    public function getWsdlPath ()
    {
        return $this->getLibPath() . DS . 'wsdl';
    }

    /**
     * Returns a config value from the admin.
     *
     * @param string $path
     * @param null|bool|int|Mage_Core_Model_Store $store
     * @return string
     */
    protected function _getConfig ($path, $store = null)
    {
        return Mage::getSingleton('avatax/config')->getConfig($path, $store);
    }

    /**
     * Returns the logging level
     *
     * @param null|bool|int|Mage_Core_Model_Store $store
     * @return int
     */
    public function getLogMode($store = null)
    {
        return $this->_getConfig('log_status', $store);
    }

    /**
     * Returns the logging type
     *
     * @param null|bool|int|Mage_Core_Model_Store $store
     * @return string
     */
    public function getLogType($store = null)
    {
        return explode(",", $this->_getConfig('log_type_list', $store));
    }

    /**
     * Returns shipping line item faked sku
     *
     * @param null|bool|int|Mage_Core_Model_Store $store
     * @return string
     */
    public function getShippingSku($store = null)
    {
        return $this->_getConfig('shipping_sku', $store);
    }

    /**
     * Returns giftwraporder line item faked sku
     *
     * @param null|bool|int|Mage_Core_Model_Store $store
     * @return string
     */
    public function getGwOrderSku($store = null)
    {
        return $this->_getConfig('gw_order_sku', $store);
    }

    /**
     * Returns giftwrapitems line item faked sku
     *
     * @param null|bool|int|Mage_Core_Model_Store $store
     * @return string
     */
    public function getGwItemsSku($store = null)
    {
        return $this->_getConfig('gw_items_sku', $store);
    }

    /**
     * Returns giftwrapprintedcard line item faked sku
     *
     * @param null|bool|int|Mage_Core_Model_Store $store
     * @return string
     */
    public function getGwPrintedCardSku($store = null)
    {
        return $this->_getConfig('gw_printed_card_sku', $store);
    }

    /**
     * Returns shipping line item faked sku
     *
     * @param null|bool|int|Mage_Core_Model_Store $store
     * @return string
     */
    public function getSalesPersonCode($store = null)
    {
        return $this->_getConfig('sales_person_code', $store);
    }

    /**
     * Returns attribute code for the location code to send to Avalara
     *
     * @param null|bool|int|Mage_Core_Model_Store $store
     * @return string
     */
    public function getLocationCode($store = null)
    {
        return $this->_getConfig('location_code', $store);
    }

    /**
     * Returns attribute code for the reference code 1 to send to Avalara
     *
     * @param null|bool|int|Mage_Core_Model_Store $store
     * @return string
     */
    public function getRef1AttributeCode($store = null)
    {
        return $this->_getConfig('line_ref1_code', $store);
    }

    /**
     * Returns attribute code for the reference code 2 to send to Avalara
     *
     * @param null|bool|int|Mage_Core_Model_Store $store
     * @return string
     */
    public function getRef2AttributeCode($store = null)
    {
        return $this->_getConfig('line_ref2_code', $store);
    }

    /**
     * Returns the positive adjustment identifier to send to Avalara
     *
     * @param null|bool|int|Mage_Core_Model_Store $store
     * @return string
     */
    public function getPositiveAdjustmentSku($store = null)
    {
        return $this->_getConfig('adjustment_positive_sku', $store);
    }

    /**
     * Returns the negative adjustment identifier to send to Avalara
     *
     * @param null|bool|int|Mage_Core_Model_Store $store
     * @return string
     */
    public function getNegativeAdjustmentSku($store = null)
    {
        return $this->_getConfig('adjustment_negative_sku', $store);
    }

    /**
     * Returns the required field list
     *
     * @param null|bool|int|Mage_Core_Model_Store $store
     * @return string
     */
    public function getFieldRequiredList($store = null)
    {
        return $this->_getConfig('field_required_list', $store);
    }

    /**
     * Returns the rules for field
     *
     * @param null|bool|int|Mage_Core_Model_Store $store
     * @return string
     */
    public function getFieldRule($store = null)
    {
        return $this->_getConfig('field_rule', $store);
    }

    /**
     * Returns full stop on error
     *
     * @param Mage_Sales_Model_Quote $quote
     * @return bool
     */
    public function fullStopOnError($quote)
    {
        if ($quote->getData('estimate_tax_error') && $this->getFullStopOnErrorMode($quote->getStoreId())) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Returns full stop on error mode
     *
     * @param @param null|bool|int|Mage_Core_Model_Store $store
     * @return bool
     */
    public function getFullStopOnErrorMode($store = null)
    {
        $validateAddress = $this->getValidateAddress($store);
        $errorFullStop = $this->getErrorFullStop($store);
        $enablePreventOrderConst = OnePica_AvaTax_Model_Source_Addressvalidation::ENABLED_PREVENT_ORDER;
        if (!$validateAddress && $errorFullStop || $validateAddress == $enablePreventOrderConst) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Returns error full stop config value
     *
     * @param @param null|bool|int|Mage_Core_Model_Store $store
     * @return bool
     */
    public function getErrorFullStop($store = null)
    {
        return (bool)$this->_getConfig('error_full_stop', $store);
    }

    /**
     * Returns validate address config value
     *
     * @param @param null|bool|int|Mage_Core_Model_Store $store
     * @return bool
     */
    public function getValidateAddress($store = null)
    {
        return $this->_getConfig('validate_address', $store);
    }

    /**
     * Get address validation countries
     *
     * @return array
     */
    public function getAddressValidationCountries()
    {
        return explode(',', $this->_getConfig('address_validation_countries'));
    }

    /**
     * Adds error message if there is an error
     *
     * @param null|bool|int|Mage_Core_Model_Store $store
     * @return string
     */
    public function addErrorMessage($store = null)
    {
        $message = $this->getErrorMessage($store);
        if (Mage::app()->getStore()->isAdmin()) {
            /** @var Mage_Adminhtml_Model_Session_Quote $session */
            $session = Mage::getSingleton('adminhtml/session_quote');
        } else {
            /** @var Mage_Checkout_Model_Session $session */
            $session = Mage::getSingleton('checkout/session');
        }

        $messages = $session->getMessages();
        if (!$messages->getMessageByIdentifier(self::CALCULATE_ERROR_MESSAGE_IDENTIFIER)) {
            /** @var Mage_Core_Model_Message_Error $error */
            $error = Mage::getSingleton('core/message')->error($message);
            $error->setIdentifier(self::CALCULATE_ERROR_MESSAGE_IDENTIFIER);
            $session->addMessage($error);
        }
        return $message;
    }

    /**
     * Remove error message
     *
     * @return $this
     */
    public function removeErrorMessage()
    {
        if (Mage::app()->getStore()->isAdmin()) {
            /** @var Mage_Adminhtml_Model_Session_Quote $session */
            $session = Mage::getSingleton('adminhtml/session_quote');
        } else {
            /** @var Mage_Checkout_Model_Session $session */
            $session = Mage::getSingleton('checkout/session');
        }
        /** @var Mage_Core_Model_Message_Collection $messages */
        $messages = $session->getMessages();
        $messages->deleteMessageByIdentifier(self::CALCULATE_ERROR_MESSAGE_IDENTIFIER);
        return $this;
    }

    /**
     * Gets error message
     *
     * @param null|bool|int|Mage_Core_Model_Store $store
     * @return string
     */
    public function getErrorMessage($store = null)
    {
        if (Mage::app()->getStore()->isAdmin()) {
            return $this->_getConfig('error_backend_message', $store);
        } else {
            return $this->_getConfig('error_frontend_message', $store);
        }
    }

    /**
     * Does any store have this extension disabled?
     *
     * @return bool
     */
    public function isAnyStoreDisabled()
    {
        $disabled = false;
        $storeCollection = Mage::app()->getStores();

        foreach ($storeCollection as $store) {
            //@startSkipCommitHooks
            $disabled |= Mage::getStoreConfig('tax/avatax/action', $store->getId()) == OnePica_AvaTax_Model_Config::ACTION_DISABLE;
            //@finishSkipCommitHooks
        }

        return $disabled;
    }

    /**
     * Determines if address validation is enabled
     *
     * @param Mage_Customer_Model_Address $address
     * @param int $storeId
     * @return bool
     */
    public function isAddressValidationOn($address, $storeId)
    {
        if (!$this->isAddressActionable($address, $storeId)) {
            return false;
        }
        return $this->getValidateAddress($storeId);
    }

    /**
     * Determines if address normalization is enabled
     *
     * @param Mage_Customer_Model_Address $address
     * @param int $storeId
     * @return bool
     */
    public function isAddressNormalizationOn($address, $storeId)
    {
        if (!$this->isAddressActionable($address, $storeId)) {
            return false;
        }
        return Mage::getStoreConfig('tax/avatax/normalize_address', $storeId);
    }

    /**
     * Determines if the address should be filtered
     *
     * @param Mage_Customer_Model_Address $address
     * @param int $storeId
     * @param int $filterMode
     * @return bool
     */
    public function isAddressActionable($address, $storeId, $filterMode = OnePica_AvaTax_Model_Config::REGIONFILTER_ALL)
    {
        $filter = false;

        if (Mage::getStoreConfig('tax/avatax/action', $storeId) == OnePica_AvaTax_Model_Config::ACTION_DISABLE) {
            return false;
        }

        if (Mage::getStoreConfig('tax/avatax/region_filter_mode', $storeId) >= $filterMode) {
            $filter = $this->_getFilterRegion($address, $storeId);
        }

        if (!in_array($address->getCountryId(), $this->getTaxableCountryByStore($storeId))) {
            $filter = 'country';
        }

        if ($filter && $this->getLogMode($storeId)) {
            $filterLog = Mage::getSingleton('avatax/session')->getFilterLog();
            if (!is_array($filterLog)) {
                $filterLog = array();
            }
            $key = $address->getCacheHashKey();

            //did we already log this filtered address?
            if (!in_array($key, $filterLog)) {
                $filterLog[] = $key;
                Mage::getSingleton('avatax/session')->setFilterLog($filterLog);

                $type = ($filterMode == OnePica_AvaTax_Model_Config::REGIONFILTER_TAX) ?
                    'tax_calc' : 'tax_calc|address_opts';
                Mage::getModel('avatax_records/log')
                    ->setStoreId($storeId)
                    ->setLevel('Success')
                    ->setType('Filter')
                    ->setRequest(print_r($address->debug(), true))
                    ->setResult('filter: ' . $filter . ', type: ' . $type)
                    ->save();
            }
        }

        return $filter ? false : true;
    }

    /**
     * Get region filter
     *
     * @param Mage_Customer_Model_Address $address
     * @param int                         $storeId
     * @return string|bool
     */
    protected function _getFilterRegion($address, $storeId)
    {
        $filter = false;
        $regionFilters = explode(',', Mage::getStoreConfig('tax/avatax/region_filter_list', $storeId));
        $entityId = $address->getRegionId() ?: $address->getCountryId();
        if (!in_array($entityId, $regionFilters)) {
            $filter = 'region';
        }
        return $filter;
    }

    /**
     * Get taxable country by store
     *
     * @param int $storeId
     * @return array
     */
    public function getTaxableCountryByStore($storeId = null)
    {
        return explode(',', Mage::getStoreConfig(self::XML_PATH_TO_TAX_AVATAX_TAXABLE_COUNTRY, $storeId));
    }

    /**
     * Get taxable country by website
     *
     * @param int $websiteId
     * @return array
     */
    public function getTaxableCountryByWebSite($websiteId)
    {
        return explode(',', Mage::app()
            ->getWebsite($websiteId)
            ->getConfig(self::XML_PATH_TO_TAX_AVATAX_TAXABLE_COUNTRY)
        );
    }

    /**
     * Get taxable country by current scope
     *
     * Used in admin panel
     *
     * @return array
     */
    public function getTaxableCountryByCurrentScope()
    {
        $websiteId = Mage::app()->getRequest()->get('website');
        $storeId = Mage::app()->getRequest()->get('store');
        if ($websiteId && !$storeId) {
            return $this->getTaxableCountryByWebSite($websiteId);
        }
        return $this->getTaxableCountryByStore($storeId);
    }

    /**
     * Determines if the object (quote, invoice, or credit memo) should use AvaTax services
     *
     * @param Mage_Sales_Model_Quote|Mage_Sales_Model_Order_Invoice|Mage_Sales_Model_Order_Creditmemo $object
     * @param Mage_Sales_Model_Quote_Address $shippingAddress
     * @return bool
     */
    public function isObjectActionable($object, $shippingAddress = null)
    {
        $storeId = $object->getStore()->getId();

        //is action enabled?
        $action = $object->getOrder() ?
            OnePica_AvaTax_Model_Config::ACTION_CALC_SUBMIT : OnePica_AvaTax_Model_Config::ACTION_CALC;
        if (Mage::getStoreConfig('tax/avatax/action', $storeId) < $action) {
            return false;
        }

        if (!$shippingAddress) {
            $shippingAddress = $object->getShippingAddress();
        }
        if (!$shippingAddress) {
            $shippingAddress = $object->getBillingAddress();
        }

        //is the region filtered?
        if (!$this->isAddressActionable($shippingAddress, $storeId, OnePica_AvaTax_Model_Config::REGIONFILTER_TAX)) {
            return false;
        }

        return true;
    }

    /**
     * Get UPC attributeCode
     *
     * @param int $storeId
     * @return string
     */
    public function getUpcAttributeCode($storeId = null)
    {
        if (!(bool)$this->_getConfig('upc_check_status', $storeId)) {
            return '';
        }
        return (string)$this->_getConfig('upc_attribute_code', $storeId);
    }

    /**
     * Get existing types log
     *
     * @return array
     */
    public function getExistingTypesLog()
    {
        return array(
            OnePica_AvaTax_Model_Source_Logtype::FILTER   => OnePica_AvaTax_Model_Source_Logtype::FILTER,
            OnePica_AvaTax_Model_Source_Logtype::GET_TAX  => OnePica_AvaTax_Model_Source_Logtype::GET_TAX,
            OnePica_AvaTax_Model_Source_Logtype::PING     => OnePica_AvaTax_Model_Source_Logtype::PING,
            OnePica_AvaTax_Model_Source_Logtype::QUEUE    => OnePica_AvaTax_Model_Source_Logtype::QUEUE,
            OnePica_AvaTax_Model_Source_Logtype::VALIDATE => OnePica_AvaTax_Model_Source_Logtype::VALIDATE,
        );
    }
}
