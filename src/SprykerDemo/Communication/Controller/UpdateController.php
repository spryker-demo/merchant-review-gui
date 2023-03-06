<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\MerchantReviewGui\Communication\Controller;

use Generated\Shared\Transfer\MerchantReviewTransfer;
use Orm\Zed\MerchantReview\Persistence\Map\SpyMerchantReviewTableMap;
use Spryker\Service\UtilText\Model\Url\Url;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Zed\MerchantReviewGui\Communication\MerchantReviewGuiCommunicationFactory getFactory()
 * @method \Pyz\Zed\MerchantReviewGui\Persistence\MerchantReviewGuiQueryContainerInterface getQueryContainer()
 */
class UpdateController extends AbstractController
{
    public const PARAM_ID = 'id';
    protected const ROUTE_TEMPLATES_LIST = '/merchant-review-gui';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function approveAction(Request $request)
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
    public function rejectAction(Request $request)
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
