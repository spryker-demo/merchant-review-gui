<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\MerchantReviewGui;

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
    public const FACADE_LOCALE = 'FACADE_LOCALE';

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
    public const QUERY_CONTAINER_MERCHANT_REVIEW = 'QUERY_CONTAINER_MERCHANT_REVIEW';

    /**
     * @var string
     */
    public const FACADE_CUSTOMER = 'FACADE_CUSTOMER';

    /**
     * @var string
     */
    public const FACADE_MERCHANT = 'FACADE_MERCHANT';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $this->addMerchantReviewFacade($container);
        $this->addLocaleFacade($container);
        $this->addCustomerFacade($container);
        $this->addMerchantFacade($container);
        $this->addUtilSanitizeService($container);
        $this->addUtilDateTimeService($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container): Container
    {
        $this->addMerchantReviewQueryContainer($container);

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
    protected function addLocaleFacade(Container $container): void
    {
        $container->set(static::FACADE_LOCALE, function (Container $container) {
            return $container->getLocator()->locale()->facade();
        });
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    protected function addMerchantReviewQueryContainer(Container $container): void
    {
        $container->set(static::QUERY_CONTAINER_MERCHANT_REVIEW, function (Container $container) {
            return $container->getLocator()->merchantReview()->queryContainer();
        });
    }
}
