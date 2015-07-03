/**
 * OnePica
 * NOTICE OF LICENSE
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to codemaster@onepica.com so we can send you a copy immediately.
 *
 * @category  OnePica
 * @package   OnePica_AvaTax
 * @copyright Copyright (c) 2012 One Pica, Inc. (http://www.onepica.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
/*global document, $, $$, Event, Class, ONEPICA */
/*jslint browser: true*/
var ONEPICA = ONEPICA || {};
(function () {
    'use strict';
    /**
     * Class RegionCustomDepends
     */
    ONEPICA.RegionCustomDepends = Class.create({

        /**
         * Country list field
         *
         * @type {object}
         */
        countryListField: null,

        /**
         * Country filter mode field
         *
         * @type {object}
         */
        countryFilterModeField: null,

        /**
         * Region list field
         *
         * @type {object}
         */
        regionListField: null,

        /**
         * Initializes
         */
        initialize: function () {
            this.initInitialState();
            this.initOnChangeCountryList();
            this.initOnChangeRegionFilterMode();
        },

        /**
         *  Event initialization for country list
         *
         * @returns {ONEPICA.RegionCustomDepends}
         */
        initOnChangeCountryList: function () {
            this.getCountryListField().on('change', function (event) {
                var i;
                for (i = 0; i < event.target.selectedOptions.length; i += 1) {
                    if (this.isUsSelected(event.target)) {
                        this.getCountryFilterModField().show();
                        if (this.isFilterModEnabled()) {
                            this.getRegionListField().show();
                        }
                        break;
                    }
                    this.getCountryFilterModField().hide();
                }
                if (this.getRegionListField().visible() && !this.getCountryFilterModField().visible()) {
                    this.getRegionListField().hide();
                }
            }.bind(this));

            return this;
        },

        /**
         * Event initialization for region filter mod
         *
         * @returns {ONEPICA.RegionCustomDepends}
         */
        initOnChangeRegionFilterMode: function () {
            $('tax_avatax_region_filter_mode').on('change', function (event) {
                if (this.getCountryFilterModField().visible()) {
                    if (this.isFilterModEnabled()) {
                        this.getRegionListField().show();
                        return this;
                    }
                }
                this.getRegionListField().hide();
            }.bind(this));

            return this;
        },

        /**
         * Init initial element state
         *
         * @returns {ONEPICA.RegionCustomDepends}
         */
        initInitialState: function () {
            if (!this.isUsSelected(this.getCountryListField())) {
                this.getCountryFilterModField().hide();
                this.getRegionListField().hide();
                return this;
            }
            if (!this.isFilterModEnabled()) {
                this.getRegionListField().hide();
            }

            return this;
        },

        /**
         * Is US selected
         *
         * @param element
         * @returns {boolean}
         */
        isUsSelected: function (element) {
            var i;
            for (i = 0; i < element.selectedOptions.length; i += 1) {
                if (element.selectedOptions[i].value === 'US') {
                    return true;
                }
            }
            return false;
        },

        /**
         * Is filter mode enabled
         *
         * @returns {boolean}
         */
        isFilterModEnabled: function () {
            var filterModeValue = parseInt($('tax_avatax_region_filter_mode').value, 10);
            return (filterModeValue === 1 || filterModeValue === 2);
        },

        /**
         * Get region list field
         *
         * @returns {object}
         */
        getRegionListField: function () {
            if (this.regionListField === null) {
                this.regionListField = $('row_tax_avatax_region_filter_list');
            }
            return this.regionListField;
        },

        /**
         * Get country filter mod field
         *
         * @returns {null, object}
         */
        getCountryFilterModField: function () {
            if (this.countryFilterModeField === null) {
                this.countryFilterModeField = $('row_tax_avatax_region_filter_mode');
            }
            return this.countryFilterModeField;
        },

        /**
         * Get country list field
         *
         * @returns {null, object}
         */
        getCountryListField: function () {
            if (this.countryListField === null) {
                this.countryListField = $('tax_avatax_country_filter_list');
            }
            return this.countryListField;
        }

    });
})();

Event.observe(document, 'dom:loaded', function () {
    'use strict';
    new ONEPICA.RegionCustomDepends();
});
