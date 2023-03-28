<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\MerchantReviewGui\Communication\Controller;

use Generated\Shared\Transfer\MerchantReviewTransfer;
use Orm\Zed\MerchantReview\Persistence\Map\SpyMerchantReviewTableMap;
use Spryker\Service\UtilText\Model\Url\Url;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \SprykerDemo\Zed\MerchantReviewGui\Communication\MerchantReviewGuiCommunicationFactory getFactory()
 */
class UpdateController extends AbstractController
{
    /**
     * @var string
     */
    public const PARAM_ID = 'id';

    /**
     * @var string
     */
    protected const ROUTE_TEMPLATES_LIST = '/merchant-review-gui';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function approveAction(Request $request): RedirectResponse
    {
        $form = $this->getFactory()->getStatusMerchantReviewForm()->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            $this->addErrorMessage('CSRF token is not valid.');

            return $this->redirectResponse(static::ROUTE_TEMPLATES_LIST);
        }

        $idMerchantReview = $this->castId($request->query->get(static::PARAM_ID));

        $merchantReviewTransfer = new MerchantReviewTransfer();
        $merchantReviewTransfer
            ->setIdMerchantReview($idMerchantReview)
            ->setStatus(SpyMerchantReviewTableMap::COL_STATUS_APPROVED);

        $this->getFactory()
            ->getMerchantReviewFacade()
            ->updateMerchantReviewStatus($merchantReviewTransfer);

        $this->addSuccessMessage('Merchant Review #%d has been approved.', ['%d' => $idMerchantReview]);

        return $this->redirectResponse(Url::generate(static::ROUTE_TEMPLATES_LIST)->build());
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function rejectAction(Request $request): RedirectResponse
    {
        $form = $this->getFactory()->getStatusMerchantReviewForm()->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            $this->addErrorMessage('CSRF token is not valid.');

            return $this->redirectResponse(static::ROUTE_TEMPLATES_LIST);
        }

        $idMerchantReview = $this->castId($request->query->get(static::PARAM_ID));

        $merchantReviewTransfer = new MerchantReviewTransfer();
        $merchantReviewTransfer
            ->setIdMerchantReview($idMerchantReview)
            ->setStatus(SpyMerchantReviewTableMap::COL_STATUS_REJECTED);

        $this->getFactory()
            ->getMerchantReviewFacade()
            ->updateMerchantReviewStatus($merchantReviewTransfer);

        $this->addSuccessMessage('Merchant Review #%d has been rejected.', ['%d' => $idMerchantReview]);

        return $this->redirectResponse(Url::generate(static::ROUTE_TEMPLATES_LIST)->build());
    }
}
