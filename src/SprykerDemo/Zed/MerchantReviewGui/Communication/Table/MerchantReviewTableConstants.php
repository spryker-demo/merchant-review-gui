<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\MerchantReviewGui\Communication\Table;

use Orm\Zed\Customer\Persistence\Map\SpyCustomerTableMap;
use Orm\Zed\MerchantReview\Persistence\Map\SpyMerchantReviewTableMap;
use Spryker\Zed\Gui\Communication\Table\TableConfiguration;

/**
 * Declares global environment configuration keys. Do not use it for other class constants.
 */
interface MerchantReviewTableConstants
{
    /**
     * @var string
     */
    public const TABLE_IDENTIFIER = 'merchant-review-table';

    /**
     * @var string
     */
    public const SORT_DESC = TableConfiguration::SORT_DESC;

    /**
     * @var string
     */
    public const PARAM_ID = 'id-merchant-review';

    /**
     * @var string
     */
    public const PARAM_STATUS = 'status';

    /**
     * @var string
     */
    public const COL_ID_MERCHANT_REVIEW = 'id_merchant_review';

    /**
     * @var string
     */
    public const COL_CREATED = 'created';

    /**
     * @var string
     */
    public const COL_CUSTOMER_NAME = 'customer_name';

    /**
     * @var string
     */
    public const COL_NICK_NAME = 'nickname';

    /**
     * @var string
     */
    public const COL_MERCHANT_NAME = 'merchant_name';

    /**
     * @var string
     */
    public const COL_RATING = 'rating';

    /**
     * @var string
     */
    public const COL_STATUS = 'status';

    /**
     * @var string
     */
    public const COL_ACTIONS = 'actions';

    /**
     * @var string
     */
    public const COL_SHOW_DETAILS = 'show_details';

    /**
     * @var string
     */
    public const COL_CUSTOMER_FIRST_NAME = SpyCustomerTableMap::COL_FIRST_NAME;

    /**
     * @var string
     */
    public const COL_CUSTOMER_LAST_NAME = SpyCustomerTableMap::COL_LAST_NAME;

    /**
     * @var string
     */
    public const COL_MERCHANT_REVIEW_STATUS_REJECTED = SpyMerchantReviewTableMap::COL_STATUS_REJECTED;

    /**
     * @var string
     */
    public const COL_MERCHANT_REVIEW_STATUS_APPROVED = SpyMerchantReviewTableMap::COL_STATUS_APPROVED;

    /**
     * @var string
     */
    public const COL_MERCHANT_REVIEW_STATUS_PENDING = SpyMerchantReviewTableMap::COL_STATUS_PENDING;

    /**
     * @var string
     */
    public const COL_MERCHANT_REVIEW_GUI_ID_CUSTOMER = 'id_customer';

    /**
     * @var string
     */
    public const COL_MERCHANT_REVIEW_GUI_FIRST_NAME = 'first_name';

    /**
     * @var string
     */
    public const COL_MERCHANT_REVIEW_GUI_LAST_NAME = 'last_name';

    /**
     * @var string
     */
    public const COL_EXTRA_DETAILS = 'details';
}
