<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\MerchantReviewGui\Persistence;

use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;
use SprykerDemo\Zed\MerchantReview\Persistence\MerchantReviewQueryContainerInterface;
use SprykerDemo\Zed\MerchantReviewGui\MerchantReviewGuiDependencyProvider;

/**
 * @method \SprykerDemo\Zed\MerchantReviewGui\Persistence\MerchantReviewGuiQueryContainerInterface getQueryContainer()
 */
class MerchantReviewGuiPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \SprykerDemo\Zed\MerchantReview\Persistence\MerchantReviewQueryContainerInterface
     */
    public function getMerchantReviewQueryContainer(): MerchantReviewQueryContainerInterface
    {
        return $this->getProvidedDependency(MerchantReviewGuiDependencyProvider::QUERY_CONTAINER_MERCHANT_REVIEW);
    }
}
