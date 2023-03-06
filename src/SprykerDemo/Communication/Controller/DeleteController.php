<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\MerchantReviewGui\Communication\Controller;

use Generated\Shared\Transfer\MerchantReviewTransfer;
use Spryker\Service\UtilText\Model\Url\Url;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Zed\MerchantReviewGui\Communication\MerchantReviewGuiCommunicationFactory getFactory()
 * @method \Pyz\Zed\MerchantReviewGui\Persistence\MerchantReviewGuiQueryContainerInterface getQueryContainer()
 */
class DeleteController extends AbstractController
{
    public const PARAM_ID = 'id';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction(Request $request)
    {
        $form = $this->getFactory()->getDeleteMerchantReviewForm()->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            $this->addErrorMessage('CSRF token is not valid');

            return $this->redirectResponse(
                Url::generate('/merchant-review-gui')->build()
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
            Url::generate('/merchant-review-gui')->build()
        );
    }
}
