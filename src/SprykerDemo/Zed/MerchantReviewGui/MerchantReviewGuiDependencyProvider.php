<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\MerchantReviewGui;

use Orm\Zed\MerchantReview\Persistence\SpyMerchantReviewQuery;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class MerchantReviewGuiDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_MERCHANT_REVIEW = 'FACADE_MERCHANT_REVIEW';

    /**
     * @var string
     */
    public const SERVICE_UTIL_SANITIZE = 'SERVICE_UTIL_SANITIZE';

    /**
     * @var string
     */
    public const SERVICE_UTIL_DATE_TIME = 'SERVICE_UTIL_DATE_TIME';

    /**
     * @var string
     */
    public const PROPEL_MERCHANT_REVIEW_QUERY = 'PROPEL_MERCHANT_REVIEW_QUERY';

    /**
     * @var string
     */
    public const FACADE_CUSTOMER = 'FACADE_CUSTOMER';

    /**
     * @var string
     */
    public const FACADE_MERCHANT = 'FACADE_MERCHANT';

    /**
     * @var string
     */
    public const FACADE_TRANSLATOR = 'FACADE_TRANSLATOR';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $this->addMerchantReviewFacade($container);
        $this->addCustomerFacade($container);
        $this->addMerchantFacade($container);
        $this->addUtilSanitizeService($container);
        $this->addUtilDateTimeService($container);
        $this->addMerchantReviewQuery($container);
        $this->addTranslatorFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    protected function addUtilSanitizeService(Container $container): void
    {
        $container->set(static::SERVICE_UTIL_SANITIZE, function (Container $container) {
            return $container->getLocator()->utilSanitize()->service();
        });
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    protected function addUtilDateTimeService(Container $container): void
    {
        $container->set(static::SERVICE_UTIL_DATE_TIME, function (Container $container) {
            return $container->getLocator()->utilDateTime()->service();
        });
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    protected function addMerchantReviewFacade(Container $container): void
    {
        $container->set(static::FACADE_MERCHANT_REVIEW, function (Container $container) {
            return $container->getLocator()->merchantReview()->facade();
        });
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    protected function addMerchantFacade(Container $container): void
    {
        $container->set(static::FACADE_MERCHANT, function (Container $container) {
            return $container->getLocator()->merchant()->facade();
        });
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    protected function addCustomerFacade(Container $container): void
    {
        $container->set(static::FACADE_CUSTOMER, function (Container $container) {
            return $container->getLocator()->customer()->facade();
        });
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    protected function addMerchantReviewQuery(Container $container): void
    {
        $container->set(static::PROPEL_MERCHANT_REVIEW_QUERY, $container->factory(function () {
            return SpyMerchantReviewQuery::create();
        }));
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    protected function addTranslatorFacade(Container $container): void
    {
        $container->set(static::FACADE_TRANSLATOR, function (Container $container) {
            return $container->getLocator()->translator()->facade();
        });
    }
}
