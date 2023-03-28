<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\MerchantReviewGui\Communication\Controller;

use Generated\Shared\Transfer\MerchantReviewTransfer;
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
    public const PARAM_ID = 'id';

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

        $idMerchantReview = $this->castId($request->query->get(static::PARAM_ID));

        $merchantSetTransfer = new MerchantReviewTransfer();
        $merchantSetTransfer->setIdMerchantReview($idMerchantReview);

        $this->getFactory()
            ->getMerchantReviewFacade()
            ->deleteMerchantReview($merchantSetTransfer);

        $this->addSuccessMessage('Merchant Review #%id% deleted successfully.', [
            '%id%' => $merchantSetTransfer->getIdMerchantReview(),
        ]);

        return $this->redirectResponse(
            Url::generate('/merchant-review-gui')->build(),
        );
    }
}
