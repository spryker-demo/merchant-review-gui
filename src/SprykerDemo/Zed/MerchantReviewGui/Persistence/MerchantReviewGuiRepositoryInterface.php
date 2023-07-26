<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\MerchantReviewGui\Persistence;

use Orm\Zed\MerchantReview\Persistence\SpyMerchantReviewQuery;

interface MerchantReviewGuiRepositoryInterface
{
    /**
     * @param int $idLocale
     *
     * @return \Orm\Zed\MerchantReview\Persistence\SpyMerchantReviewQuery
     */
    public function getMerchantReviewQuery(int $idLocale): SpyMerchantReviewQuery;
}
