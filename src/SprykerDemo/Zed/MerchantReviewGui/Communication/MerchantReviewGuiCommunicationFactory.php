<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\MerchantReviewGui\Communication;

use Orm\Zed\MerchantReview\Persistence\SpyMerchantReviewQuery;
use Spryker\Service\UtilDateTime\UtilDateTimeServiceInterface;
use Spryker\Service\UtilSanitize\UtilSanitizeServiceInterface;
use Spryker\Zed\Customer\Business\CustomerFacadeInterface;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Spryker\Zed\Locale\Business\LocaleFacadeInterface;
use Spryker\Zed\Merchant\Business\MerchantFacadeInterface;
use Spryker\Zed\Translator\Business\TranslatorFacadeInterface;
use SprykerDemo\Zed\MerchantReview\Business\MerchantReviewFacadeInterface;
use SprykerDemo\Zed\MerchantReviewGui\Communication\Form\DeleteMerchantReviewForm;
use SprykerDemo\Zed\MerchantReviewGui\Communication\Form\StatusMerchantReviewForm;
use SprykerDemo\Zed\MerchantReviewGui\Communication\Table\MerchantReviewTable;
use SprykerDemo\Zed\MerchantReviewGui\MerchantReviewGuiDependencyProvider;
use Symfony\Component\Form\FormInterface;

class MerchantReviewGuiCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \SprykerDemo\Zed\MerchantReviewGui\Communication\Table\MerchantReviewTable
     */
    public function createMerchantReviewTable(): MerchantReviewTable
    {
        return new MerchantReviewTable(
            $this->getMerchantReviewQuery(),
            $this->getUtilDateTimeService(),
            $this->getUtilSanitizeServiceInterface(),
            $this->getTranslatorFacade(),
            $this->getLocaleFacade(),
        );
    }

    /**
     * @return \Spryker\Service\UtilDateTime\UtilDateTimeServiceInterface
     */
    protected function getUtilDateTimeService(): UtilDateTimeServiceInterface
    {
        return $this->getProvidedDependency(MerchantReviewGuiDependencyProvider::SERVICE_UTIL_DATE_TIME);
    }

    /**
     * @return \Orm\Zed\MerchantReview\Persistence\SpyMerchantReviewQuery
     */
    public function getMerchantReviewQuery(): SpyMerchantReviewQuery
    {
        return $this->getProvidedDependency(MerchantReviewGuiDependencyProvider::PROPEL_MERCHANT_REVIEW_QUERY);
    }

    /**
     * @return \Spryker\Service\UtilSanitize\UtilSanitizeServiceInterface
     */
    protected function getUtilSanitizeServiceInterface(): UtilSanitizeServiceInterface
    {
        return $this->getProvidedDependency(MerchantReviewGuiDependencyProvider::SERVICE_UTIL_SANITIZE);
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getDeleteMerchantReviewForm(): FormInterface
    {
        return $this->getFormFactory()->create(DeleteMerchantReviewForm::class, [], ['fields' => []]);
    }

    /**
     * @return \SprykerDemo\Zed\MerchantReview\Business\MerchantReviewFacadeInterface
     */
    public function getMerchantReviewFacade(): MerchantReviewFacadeInterface
    {
        return $this->getProvidedDependency(MerchantReviewGuiDependencyProvider::FACADE_MERCHANT_REVIEW);
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getStatusMerchantReviewForm(): FormInterface
    {
        return $this->getFormFactory()->create(StatusMerchantReviewForm::class);
    }

    /**
     * @return \Spryker\Zed\Customer\Business\CustomerFacadeInterface
     */
    public function getCustomerFacade(): CustomerFacadeInterface
    {
        return $this->getProvidedDependency(MerchantReviewGuiDependencyProvider::FACADE_CUSTOMER);
    }

    /**
     * @return \Spryker\Zed\Merchant\Business\MerchantFacadeInterface
     */
    public function getMerchantFacade(): MerchantFacadeInterface
    {
        return $this->getProvidedDependency(MerchantReviewGuiDependencyProvider::FACADE_MERCHANT);
    }

    /**
     * @return \Spryker\Zed\Translator\Business\TranslatorFacadeInterface
     */
    public function getTranslatorFacade(): TranslatorFacadeInterface
    {
        return $this->getProvidedDependency(MerchantReviewGuiDependencyProvider::FACADE_TRANSLATOR);
    }

    /**
     * @return \Spryker\Zed\Locale\Business\LocaleFacadeInterface
     */
    public function getLocaleFacade(): LocaleFacadeInterface
    {
        return $this->getProvidedDependency(MerchantReviewGuiDependencyProvider::FACADE_LOCALE);
    }
}
