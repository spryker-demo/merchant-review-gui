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
class DeleteController extends AbstractController
{
    /**
     * @var string
     */
    protected const PARAM_MERCHANT_REVIEW_ID = 'id-merchant-review';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction(Request $request): RedirectResponse
    {
        $form = $this->getFactory()->getDeleteMerchantReviewForm()->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            $this->addErrorMessage('CSRF token is not valid');

            return $this->redirectResponse(
                Url::generate('/merchant-review-gui')->build(),
            );
        }

        $idMerchantReview = $this->castId($request->query->get(static::PARAM_MERCHANT_REVIEW_ID));

        $this->getFactory()
            ->getMerchantReviewFacade()
            ->deleteMerchantReview($idMerchantReview);

        $this->addSuccessMessage('Merchant Review #%id% deleted successfully.', [
            '%id%' => $idMerchantReview,
        ]);

        return $this->redirectResponse(
            Url::generate('/merchant-review-gui')->build(),
        );
    }
}
