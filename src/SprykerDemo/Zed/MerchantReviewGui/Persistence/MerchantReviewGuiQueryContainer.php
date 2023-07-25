<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\MerchantReviewGui\Persistence;

use Orm\Zed\Customer\Persistence\Map\SpyCustomerTableMap;
use Orm\Zed\Merchant\Persistence\Map\SpyMerchantTableMap;
use Orm\Zed\MerchantReview\Persistence\Map\SpyMerchantReviewTableMap;
use Orm\Zed\MerchantReview\Persistence\SpyMerchantReviewQuery;
use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

/**
 * @method \SprykerDemo\Zed\MerchantReviewGui\Persistence\MerchantReviewGuiPersistenceFactory getFactory()
 */
class MerchantReviewGuiQueryContainer extends AbstractQueryContainer implements MerchantReviewGuiQueryContainerInterface
{
    /**
     * @var string
     */
    public const FIELD_MERCHANT_NAME = 'merchant_name';

    /**
     * @var string
     */
    public const FIELD_ID_CUSTOMER = 'id_customer';

    /**
     * @var string
     */
    public const FIELD_CUSTOMER_FIRST_NAME = 'first_name';

    /**
     * @var string
     */
    public const FIELD_CUSTOMER_LAST_NAME = 'last_name';

    /**
     * @var string
     */
    public const FIELD_CREATED = 'created';

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idLocale
     *
     * @return \Orm\Zed\MerchantReview\Persistence\SpyMerchantReviewQuery
     */
    public function queryMerchantReview(int $idLocale): SpyMerchantReviewQuery
    {
        return $this->getFactory()
            ->getMerchantReviewQueryContainer()
            ->queryMerchantReview()
            ->addJoin(SpyMerchantReviewTableMap::COL_CUSTOMER_REFERENCE, SpyCustomerTableMap::COL_CUSTOMER_REFERENCE)
            ->addJoin(SpyMerchantReviewTableMap::COL_FK_MERCHANT, SpyMerchantTableMap::COL_ID_MERCHANT)
            ->withColumn(SpyMerchantReviewTableMap::COL_CREATED_AT, static::FIELD_CREATED)
            ->withColumn(SpyMerchantTableMap::COL_NAME, static::FIELD_MERCHANT_NAME)
            ->withColumn(SpyCustomerTableMap::COL_ID_CUSTOMER, static::FIELD_ID_CUSTOMER)
            ->withColumn(SpyCustomerTableMap::COL_FIRST_NAME, static::FIELD_CUSTOMER_FIRST_NAME)
            ->withColumn(SpyCustomerTableMap::COL_LAST_NAME, static::FIELD_CUSTOMER_LAST_NAME);
    }
}
