<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\MerchantReviewGui\Communication;

use Generated\Shared\Transfer\LocaleTransfer;
use Pyz\Zed\MerchantReviewGui\Communication\Form\DeleteMerchantReviewForm;
use Pyz\Zed\MerchantReviewGui\Communication\Form\StatusMerchantReviewForm;
use Pyz\Zed\MerchantReviewGui\Communication\Table\MerchantReviewTable;
use Pyz\Zed\MerchantReviewGui\MerchantReviewGuiDependencyProvider;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Symfony\Component\Form\FormInterface;

/**
 * @method \Pyz\Zed\MerchantReviewGui\Persistence\MerchantReviewGuiQueryContainerInterface getQueryContainer()
 * @method \Pyz\Zed\MerchantReviewGui\MerchantReviewGuiConfig getConfig()
 */
class MerchantReviewGuiCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     *
     * @return \Pyz\Zed\MerchantReviewGui\Communication\Table\MerchantReviewTable
     */
    public function createMerchantReviewTable(LocaleTransfer $localeTransfer)
    {
        return new MerchantReviewTable($this->getQueryContainer(), $localeTransfer, $this->getUtilDateTimeService(), $this->getUtilSanitizeServiceInterface());
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getDeleteMerchantReviewForm(): FormInterface
    {
        return $this->getFormFactory()->create(DeleteMerchantReviewForm::class, [], [
            'fields' => [],
        ]);
    }

    /**
     * @return \Spryker\Service\UtilDateTime\UtilDateTimeServiceInterface
     */
    protected function getUtilDateTimeService()
    {
        return $this->getProvidedDependency(MerchantReviewGuiDependencyProvider::SERVICE_UTIL_DATE_TIME);
    }

    /**
     * @return \Spryker\Service\UtilSanitize\UtilSanitizeServiceInterface
     */
    protected function getUtilSanitizeServiceInterface()
    {
        return $this->getProvidedDependency(MerchantReviewGuiDependencyProvider::SERVICE_UTIL_SANITIZE);
    }

    /**
     * @return \Pyz\Zed\MerchantReview\Business\MerchantReviewFacadeInterface
     */
    public function getMerchantReviewFacade()
    {
        return $this->getProvidedDependency(MerchantReviewGuiDependencyProvider::FACADE_MERCHANT_REVIEW);
    }

    /**
     * @return \Spryker\Zed\Locale\Business\LocaleFacadeInterface
     */
    public function getLocaleFacade()
    {
        return $this->getProvidedDependency(MerchantReviewGuiDependencyProvider::FACADE_LOCALE);
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getStatusMerchantReviewForm(): FormInterface
    {
        return $this->getFormFactory()->create(StatusMerchantReviewForm::class);
    }
}
