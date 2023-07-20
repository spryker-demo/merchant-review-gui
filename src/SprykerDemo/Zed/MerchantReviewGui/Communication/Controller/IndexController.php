<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\MerchantReviewGui\Communication\Controller;

use Generated\Shared\Transfer\LocaleTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @method \SprykerDemo\Zed\MerchantReviewGui\Communication\MerchantReviewGuiCommunicationFactory getFactory()
 */
class IndexController extends AbstractController
{
    /**
     * @return array<mixed>
     */
    public function indexAction(): array
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
    public function tableAction(): JsonResponse
    {
        $merchantTable = $this
            ->getFactory()
            ->createMerchantReviewTable($this->getCurrentLocale());

        return $this->jsonResponse(
            $merchantTable->fetchData(),
        );
    }

    /**
     * @return \Generated\Shared\Transfer\LocaleTransfer
     */
    protected function getCurrentLocale(): LocaleTransfer
    {
        return $this->getFactory()
            ->getLocaleFacade()
            ->getCurrentLocale();
    }
}
