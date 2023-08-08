<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\MerchantReviewGui\Communication\Controller;

use Spryker\Service\UtilText\Model\Url\Url;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \SprykerDemo\Zed\MerchantReviewGui\Communication\MerchantReviewGuiCommunicationFactory getFactory()
 */
class ReviewStatusController extends AbstractController
{
    /**
     * @var string
     */
    public const PARAM_MERCHANT_REVIEW_ID = 'id-merchant-review';

    /**
     * @var string
     */
    public const PARAM_MERCHANT_REVIEW_STATUS = 'status';

    /**
     * @var string
     */
    protected const URL_REDIRECT_MERCHANT_REVIEW_LIST = '/merchant-review-gui';

    /**
     * @var string
     */
    protected const MESSAGE_ERROR_MERCHANT_REVIEW_STATUS_UPDATE = 'Merchant Review status can\'t be updated.';

    /**
     * @var string
     */
    protected const MESSAGE_SUCCESS_MERCHANT_REVIEW_STATUS_UPDATE = 'Merchant Review #%d status was updated successfully';

    /**
     * @var string
     */
    protected const MESSAGE_ERROR_CSRF_TOKEN_IS_NOT_VALID = 'CSRF token is not valid.';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction(Request $request): RedirectResponse
    {
        $form = $this->getFactory()->getStatusMerchantReviewForm()->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            $this->addErrorMessage(static::MESSAGE_ERROR_CSRF_TOKEN_IS_NOT_VALID);

            return $this->redirectResponse(static::URL_REDIRECT_MERCHANT_REVIEW_LIST);
        }

        $idMerchantReview = $this->castId($request->query->get(static::PARAM_MERCHANT_REVIEW_ID));
        $newMerchantReviewStatus = (string)$request->query->get(static::PARAM_MERCHANT_REVIEW_STATUS) ?: null;

        if (!$idMerchantReview || !$newMerchantReviewStatus) {
            return $this->returnErrorRedirect($request);
        }

        $merchantReviewTransfer = $this->getFactory()->getMerchantReviewFacade()->findMerchantReviewById($idMerchantReview);

        if (!$merchantReviewTransfer) {
            return $this->returnErrorRedirect($request);
        }

        $merchantReviewTransfer
            ->setIdMerchantReview($idMerchantReview)
            ->setStatus($newMerchantReviewStatus);

        $this->getFactory()
            ->getMerchantReviewFacade()
            ->updateMerchantReviewStatus($merchantReviewTransfer);

        $this->addSuccessMessage(static::MESSAGE_SUCCESS_MERCHANT_REVIEW_STATUS_UPDATE, ['%d' => $idMerchantReview]);

        return $this->redirectResponse(Url::generate(static::URL_REDIRECT_MERCHANT_REVIEW_LIST)->build());
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function returnErrorRedirect(Request $request): RedirectResponse
    {
        $this->addErrorMessage(static::MESSAGE_ERROR_MERCHANT_REVIEW_STATUS_UPDATE);

        return $this->redirectResponse($request->headers->get('referer') ?? static::URL_REDIRECT_MERCHANT_REVIEW_LIST);
    }
}
