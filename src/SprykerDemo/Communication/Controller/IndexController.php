<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\MerchantReviewGui\Communication\Controller;

use Spryker\Zed\Kernel\Communication\Controller\AbstractController;

/**
 * @method \Pyz\Zed\MerchantReviewGui\Communication\MerchantReviewGuiCommunicationFactory getFactory()
 * @method \Pyz\Zed\MerchantReviewGui\Persistence\MerchantReviewGuiQueryContainerInterface getQueryContainer()
 */
class IndexController extends AbstractController
{
    /**
     * @return array
     */
    public function indexAction()
    {
        $merchantReviewTable = $this
            ->getFactory()
            ->createMerchantReviewTable($this->getCurrentLocale());

        return $this->viewResponse([
            'merchantReviewTable' => $merchantReviewTable->render(),
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function tableAction()
    {
        $merchantTable = $this
            ->getFactory()
            ->createMerchantReviewTable($this->getCurrentLocale());

        return $this->jsonResponse(
            $merchantTable->fetchData()
        );
    }

    /**
     * @return \Generated\Shared\Transfer\LocaleTransfer
     */
    protected function getCurrentLocale()
    {
        return $this->getFactory()
            ->getLocaleFacade()
            ->getCurrentLocale();
    }
}
