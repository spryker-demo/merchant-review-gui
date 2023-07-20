<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\MerchantReviewGui\Communication\Table;

use DateTime;
use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\MerchantCriteriaTransfer;
use Generated\Shared\Transfer\MerchantReviewTransfer;
use Spryker\Service\UtilDateTime\UtilDateTimeServiceInterface;
use Spryker\Service\UtilSanitize\UtilSanitizeServiceInterface;
use Spryker\Service\UtilText\Model\Url\Url;
use Spryker\Zed\Customer\Business\CustomerFacadeInterface;
use Spryker\Zed\Gui\Communication\Table\AbstractTable;
use Spryker\Zed\Gui\Communication\Table\TableConfiguration;
use Spryker\Zed\Merchant\Business\MerchantFacadeInterface;
use SprykerDemo\Zed\MerchantReview\Business\MerchantReviewFacadeInterface;
use SprykerDemo\Zed\MerchantReviewGui\Communication\Form\DeleteMerchantReviewForm;
use SprykerDemo\Zed\MerchantReviewGui\Communication\Form\StatusMerchantReviewForm;

class MerchantReviewTable extends AbstractTable
{
    /**
     * @var \Generated\Shared\Transfer\LocaleTransfer
     */
    protected LocaleTransfer $localeTransfer;

    /**
     * @var \Spryker\Service\UtilDateTime\UtilDateTimeServiceInterface
     */
    protected UtilDateTimeServiceInterface $utilDateTimeService;

    /**
     * @var \Spryker\Service\UtilSanitize\UtilSanitizeServiceInterface
     */
    protected UtilSanitizeServiceInterface $utilSanitizeService;

    /**
     * @var \SprykerDemo\Zed\MerchantReview\Business\MerchantReviewFacadeInterface
     */
    protected MerchantReviewFacadeInterface $merchantReviewFacade;

    /**
     * @var \Spryker\Zed\Customer\Business\CustomerFacadeInterface
     */
    protected CustomerFacadeInterface $customerFacade;

    /**
     * @var \Spryker\Zed\Merchant\Business\MerchantFacadeInterface
     */
    protected MerchantFacadeInterface $merchantFacade;

    /**
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     * @param \Spryker\Service\UtilDateTime\UtilDateTimeServiceInterface $utilDateTimeService
     * @param \Spryker\Service\UtilSanitize\UtilSanitizeServiceInterface $utilSanitizeService
     * @param \SprykerDemo\Zed\MerchantReview\Business\MerchantReviewFacadeInterface $merchantReviewFacade
     * @param \Spryker\Zed\Customer\Business\CustomerFacadeInterface $customerFacade
     * @param \Spryker\Zed\Merchant\Business\MerchantFacadeInterface $merchantFacade
     */
    public function __construct(
        LocaleTransfer $localeTransfer,
        UtilDateTimeServiceInterface $utilDateTimeService,
        UtilSanitizeServiceInterface $utilSanitizeService,
        MerchantReviewFacadeInterface $merchantReviewFacade,
        CustomerFacadeInterface $customerFacade,
        MerchantFacadeInterface $merchantFacade
    ) {
        $this->localeTransfer = $localeTransfer;
        $this->utilDateTimeService = $utilDateTimeService;
        $this->utilSanitizeService = $utilSanitizeService;

        $this->localeTransfer->requireIdLocale();
        $this->merchantReviewFacade = $merchantReviewFacade;
        $this->customerFacade = $customerFacade;
        $this->merchantFacade = $merchantFacade;
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return \Spryker\Zed\Gui\Communication\Table\TableConfiguration
     */
    protected function configure(TableConfiguration $config): TableConfiguration
    {
        $this->setTableIdentifier(MerchantReviewTableConstants::TABLE_IDENTIFIER);

        $config->setHeader([
            MerchantReviewTableConstants::COL_SHOW_DETAILS => '',
            MerchantReviewTableConstants::COL_ID_MERCHANT_REVIEW => 'ID',
            MerchantReviewTableConstants::COL_CREATED => 'Date',
            MerchantReviewTableConstants::COL_CUSTOMER_NAME => 'Customer',
            MerchantReviewTableConstants::COL_NICK_NAME => 'Nickname',
            MerchantReviewTableConstants::COL_MERCHANT_NAME => 'Merchant name',
            MerchantReviewTableConstants::COL_RATING => 'Rating',
            MerchantReviewTableConstants::COL_STATUS => 'Status',
            MerchantReviewTableConstants::COL_ACTIONS => 'Actions',
        ]);

        $config->setRawColumns([
            MerchantReviewTableConstants::COL_SHOW_DETAILS,
            MerchantReviewTableConstants::COL_STATUS,
            MerchantReviewTableConstants::COL_ACTIONS,
            MerchantReviewTableConstants::COL_CUSTOMER_NAME,
            MerchantReviewTableConstants::COL_MERCHANT_NAME,
            MerchantReviewTableConstants::EXTRA_DETAILS,
        ]);

        $config->setSearchable([
            MerchantReviewTableConstants::COL_NICK_NAME,
            MerchantReviewTableConstants::COL_CUSTOMER_FIRST_NAME,
            MerchantReviewTableConstants::COL_CUSTOMER_LAST_NAME,
        ]);

        $config->setSortable([
            MerchantReviewTableConstants::COL_ID_MERCHANT_REVIEW,
            MerchantReviewTableConstants::COL_CREATED,
            MerchantReviewTableConstants::COL_NICK_NAME,
            MerchantReviewTableConstants::COL_MERCHANT_NAME,
            MerchantReviewTableConstants::COL_RATING,
            MerchantReviewTableConstants::COL_STATUS,
        ]);

        $config->setExtraColumns([
            MerchantReviewTableConstants::EXTRA_DETAILS,
        ]);

        $config->setDefaultSortField(
            MerchantReviewTableConstants::COL_ID_MERCHANT_REVIEW,
            MerchantReviewTableConstants::SORT_DESC,
        );
        $config->setStateSave(false);

        return $config;
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return array<int, array<string, mixed>>
     */
    protected function prepareData(TableConfiguration $config): array
    {
        $merchantReviewCollection = $this->merchantReviewFacade->getMerchantReviews();

        $tableData = [];
        foreach ($merchantReviewCollection->getReviews() as $merchantReviewEntity) {
            $tableData[] = $this->generateItem($merchantReviewEntity);
        }

        return $tableData;
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantReviewTransfer $merchantReviewTransfer
     *
     * @return array<string, mixed>
     */
    protected function generateItem(MerchantReviewTransfer $merchantReviewTransfer): array
    {
        return [
            MerchantReviewTableConstants::COL_ID_MERCHANT_REVIEW => $merchantReviewTransfer->getIdMerchantReview(),
            MerchantReviewTableConstants::COL_CREATED => $this->getCreatedAt($merchantReviewTransfer),
            MerchantReviewTableConstants::COL_CUSTOMER_NAME => $this->getCustomerName($merchantReviewTransfer),
            MerchantReviewTableConstants::COL_NICK_NAME => $merchantReviewTransfer->getNickname(),
            MerchantReviewTableConstants::COL_MERCHANT_NAME => $this->getMerchantName($merchantReviewTransfer),
            MerchantReviewTableConstants::COL_RATING => $merchantReviewTransfer->getRating(),
            MerchantReviewTableConstants::COL_STATUS => $this->getStatusLabel($merchantReviewTransfer->getStatus()),
            MerchantReviewTableConstants::COL_ACTIONS => $this->createActionButtons($merchantReviewTransfer),
            MerchantReviewTableConstants::COL_SHOW_DETAILS => $this->createShowDetailsButton(),
            MerchantReviewTableConstants::EXTRA_DETAILS => $this->generateDetails($merchantReviewTransfer),
        ];
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantReviewTransfer $merchantReviewTransfer
     *
     * @return \DateTime|string
     */
    protected function getCreatedAt(MerchantReviewTransfer $merchantReviewTransfer): DateTime|string
    {
        $createdAt = $merchantReviewTransfer->getCreatedAt();

        if (!$createdAt) {
            return '';
        }

        return $this->utilDateTimeService->formatDateTime($createdAt);
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantReviewTransfer $merchantReviewTransfer
     *
     * @return string
     */
    protected function getCustomerName(MerchantReviewTransfer $merchantReviewTransfer): string
    {
        $customerReference = $merchantReviewTransfer->getCustomerReference();

        if (!$customerReference) {
            return '';
        }

        $customerTransfer = $this->customerFacade
            ->findCustomerByReference($customerReference)
            ->getCustomerTransfer();

        if (!$customerTransfer) {
            return '';
        }

        return sprintf(
            '<a href="%s" target="_blank">%s %s</a>',
            Url::generate('/customer/view', [
                'id-customer' => $customerTransfer->getIdCustomer(),
            ]),
            $this->utilSanitizeService->escapeHtml(
                $customerTransfer->getFirstName() ?? '',
            ),
            $this->utilSanitizeService->escapeHtml(
                $customerTransfer->getLastName() ?? '',
            ),
        );
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantReviewTransfer $merchantReviewTransfer
     *
     * @return string
     */
    protected function getMerchantName(MerchantReviewTransfer $merchantReviewTransfer): mixed
    {
        $merchantTransfer = $this->merchantFacade
            ->findOne(
                (new MerchantCriteriaTransfer())
                    ->setIdMerchant($merchantReviewTransfer->getFkMerchant()),
            );

        if (!$merchantTransfer) {
            return '';
        }

        return sprintf(
            '<a href="%s" target="_blank">%s</a>',
            Url::generate('/merchant-gui/edit-merchant', [
                'id-merchant' => $merchantReviewTransfer->getFkMerchant(),
            ]),
            $this->utilSanitizeService->escapeHtml(
                $merchantTransfer->getName() ?? '',
            ),
        );
    }

    /**
     * @param string|null $status
     *
     * @return string
     */
    protected function getStatusLabel(?string $status): string
    {
        return match ($status) {
            MerchantReviewTableConstants::COL_MERCHANT_REVIEW_STATUS_REJECTED => $this->generateLabel(
                'Rejected',
                'label-danger',
            ),
            MerchantReviewTableConstants::COL_MERCHANT_REVIEW_STATUS_APPROVED => $this->generateLabel(
                'Approved',
                'label-success',
            ),
            default => $this->generateLabel('Pending', 'label-secondary'),
        };
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantReviewTransfer $merchantReviewTransfer
     *
     * @return string
     */
    protected function createActionButtons(MerchantReviewTransfer $merchantReviewTransfer): string
    {
        $actions = [];

        $actions[] = $this->generateStatusChangeButton($merchantReviewTransfer);
        $actions[] = $this->generateRemoveButton(
            Url::generate('/merchant-review-gui/delete', [
                MerchantReviewTableConstants::PARAM_ID => $merchantReviewTransfer->getIdMerchantReview(),
            ]),
            'Delete',
            [],
            DeleteMerchantReviewForm::class,
        );

        return implode(' ', $actions);
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantReviewTransfer $merchantReviewTransfer
     *
     * @return string
     */
    protected function generateStatusChangeButton(MerchantReviewTransfer $merchantReviewTransfer): string
    {
        $buttons = [];
        switch ($merchantReviewTransfer->getStatus()) {
            case MerchantReviewTableConstants::COL_MERCHANT_REVIEW_STATUS_REJECTED:
                $buttons[] = $this->generateApproveButton($merchantReviewTransfer);

                break;
            case MerchantReviewTableConstants::COL_MERCHANT_REVIEW_STATUS_APPROVED:
                $buttons[] = $this->generateRejectButton($merchantReviewTransfer);

                break;
            case MerchantReviewTableConstants::COL_MERCHANT_REVIEW_STATUS_PENDING:
            default:
                $buttons[] = $this->generateApproveButton($merchantReviewTransfer);
                $buttons[] = $this->generateRejectButton($merchantReviewTransfer);

                break;
        }

        return implode(' ', $buttons);
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantReviewTransfer $merchantReviewTransfer
     *
     * @return string
     */
    protected function generateApproveButton(MerchantReviewTransfer $merchantReviewTransfer): string
    {
        return $this->generateFormButton(
            Url::generate('/merchant-review-gui/update/approve', [
                MerchantReviewTableConstants::PARAM_ID => $merchantReviewTransfer->getIdMerchantReview(),
            ]),
            'Approve',
            StatusMerchantReviewForm::class,
            [
                static::BUTTON_CLASS => 'btn-outline',
            ],
        );
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantReviewTransfer $merchantReviewTransfer
     *
     * @return string
     */
    protected function generateRejectButton(MerchantReviewTransfer $merchantReviewTransfer): string
    {
        return $this->generateFormButton(
            Url::generate('/merchant-review-gui/update/reject', [
                MerchantReviewTableConstants::PARAM_ID => $merchantReviewTransfer->getIdMerchantReview(),
            ]),
            'Reject',
            StatusMerchantReviewForm::class,
            [
                static::BUTTON_CLASS => 'btn-view',
            ],
        );
    }

    /**
     * @return string
     */
    protected function createShowDetailsButton(): string
    {
        return '<i class="fa fa-chevron-down"></i>';
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantReviewTransfer $merchantReviewTransfer
     *
     * @return string
     */
    protected function generateDetails(MerchantReviewTransfer $merchantReviewTransfer): string
    {
        return sprintf(
            '<table class="details">
                <tr>
                    <th>Summary</th>
                    <td>%s</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>%s</td>
                </tr>
            </table>',
            $this->utilSanitizeService->escapeHtml($merchantReviewTransfer->getSummary() ?? ''),
            $this->utilSanitizeService->escapeHtml($merchantReviewTransfer->getDescription() ?? ''),
        );
    }
}
