<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\MerchantReviewGui\Communication\Table;

use Orm\Zed\Customer\Persistence\Map\SpyCustomerTableMap;
use Orm\Zed\MerchantReview\Persistence\Map\SpyMerchantReviewTableMap;
use Pyz\Zed\MerchantReviewGui\Communication\Controller\UpdateController;
use Pyz\Zed\MerchantReviewGui\Persistence\MerchantReviewGuiQueryContainer;
use Spryker\Zed\Gui\Communication\Table\TableConfiguration;

/**
 * Declares global environment configuration keys. Do not use it for other class constants.
 */
interface MerchantReviewTableConstants
{
    public const TABLE_IDENTIFIER = 'merchant-review-table';

    public const SORT_DESC = TableConfiguration::SORT_DESC;

    public const PARAM_ID = UpdateController::PARAM_ID;

    public const COL_ID_MERCHANT_REVIEW = 'id_merchant_review';
    public const COL_CREATED = MerchantReviewGuiQueryContainer::FIELD_CREATED;
    public const COL_CUSTOMER_NAME = 'customer_name';
    public const COL_NICK_NAME = 'nickname';
    public const COL_MERCHANT_NAME = MerchantReviewGuiQueryContainer::FIELD_MERCHANT_NAME;
    public const COL_RATING = 'rating';
    public const COL_STATUS = 'status';
    public const COL_ACTIONS = 'actions';
    public const COL_SHOW_DETAILS = 'show_details';
    public const COL_CUSTOMER_FIRST_NAME = SpyCustomerTableMap::COL_FIRST_NAME;
    public const COL_CUSTOMER_LAST_NAME = SpyCustomerTableMap::COL_LAST_NAME;
    public const COL_MERCHANT_REVIEW_STATUS_REJECTED = SpyMerchantReviewTableMap::COL_STATUS_REJECTED;
    public const COL_MERCHANT_REVIEW_STATUS_APPROVED = SpyMerchantReviewTableMap::COL_STATUS_APPROVED;
    public const COL_MERCHANT_REVIEW_STATUS_PENDING = SpyMerchantReviewTableMap::COL_STATUS_PENDING;
    public const COL_MERCHANT_REVIEW_GUI_ID_CUSTOMER = MerchantReviewGuiQueryContainer::FIELD_ID_CUSTOMER;
    public const COL_MERCHANT_REVIEW_GUI_FIRST_NAME = MerchantReviewGuiQueryContainer::FIELD_CUSTOMER_FIRST_NAME;
    public const COL_MERCHANT_REVIEW_GUI_LAST_NAME = MerchantReviewGuiQueryContainer::FIELD_CUSTOMER_LAST_NAME;
    public const EXTRA_DETAILS = 'details';
}
