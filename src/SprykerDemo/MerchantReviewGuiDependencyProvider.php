<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\MerchantReviewGui;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

/**
 * @method \Pyz\Zed\MerchantReviewGui\MerchantReviewGuiConfig getConfig()
 */
class MerchantReviewGuiDependencyProvider extends AbstractBundleDependencyProvider
{
    public const FACADE_MERCHANT_REVIEW = 'FACADE_MERCHANT_REVIEW';
    public const FACADE_LOCALE = 'FACADE_LOCALE';
    public const SERVICE_UTIL_SANITIZE = 'SERVICE_UTIL_SANITIZE';
    public const SERVICE_UTIL_DATE_TIME = 'SERVICE_UTIL_DATE_TIME';

    public const QUERY_CONTAINER_MERCHANT_REVIEW = 'QUERY_CONTAINER_MERCHANT_REVIEW';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container)
    {
        $this->addMerchantReviewFacade($container);
        $this->addLocaleFacade($container);
        $this->addUtilSanitizeService($container);
        $this->addUtilDateTimeService($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    protected function addUtilSanitizeService(Container $container)
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
    protected function addUtilDateTimeService(Container $container)
    {
        $container->set(static::SERVICE_UTIL_DATE_TIME, function (Container $container) {
            return $container->getLocator()->utilDateTime()->service();
        });
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container)
    {
        $this->addMerchantReviewQueryContainer($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    protected function addMerchantReviewFacade(Container $container)
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
    protected function addMerchantReviewQueryContainer(Container $container)
    {
        $container->set(static::QUERY_CONTAINER_MERCHANT_REVIEW, function (Container $container) {
            return $container->getLocator()->merchantReview()->queryContainer();
        });
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return void
     */
    protected function addLocaleFacade(Container $container)
    {
        $container->set(static::FACADE_LOCALE, function (Container $container) {
            return $container->getLocator()->locale()->facade();
        });
    }
}
