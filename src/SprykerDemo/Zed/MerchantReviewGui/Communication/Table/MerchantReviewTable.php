<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\MerchantReviewGui\Communication\Table;

use Generated\Shared\Transfer\LocaleTransfer;
use Orm\Zed\MerchantReview\Persistence\SpyMerchantReview;
use Spryker\Service\UtilDateTime\UtilDateTimeServiceInterface;
use Spryker\Service\UtilSanitize\UtilSanitizeServiceInterface;
use Spryker\Service\UtilText\Model\Url\Url;
use Spryker\Zed\Gui\Communication\Table\AbstractTable;
use Spryker\Zed\Gui\Communication\Table\TableConfiguration;
use SprykerDemo\Zed\MerchantReviewGui\Communication\Form\DeleteMerchantReviewForm;
use SprykerDemo\Zed\MerchantReviewGui\Communication\Form\StatusMerchantReviewForm;
use SprykerDemo\Zed\MerchantReviewGui\Persistence\MerchantReviewGuiRepositoryInterface;

class MerchantReviewTable extends AbstractTable
{
    /**
     * @var \SprykerDemo\Zed\MerchantReviewGui\Persistence\MerchantReviewGuiRepositoryInterface
     */
    protected $merchantReviewGuiPersistenceRepository;

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
     * @param \SprykerDemo\Zed\MerchantReviewGui\Persistence\MerchantReviewGuiRepositoryInterface $merchantReviewGuiPersistenceRepository
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     * @param \Spryker\Service\UtilDateTime\UtilDateTimeServiceInterface $utilDateTimeService
     * @param \Spryker\Service\UtilSanitize\UtilSanitizeServiceInterface $utilSanitizeService
     */
    public function __construct(
        MerchantReviewGuiRepositoryInterface $merchantReviewGuiPersistenceRepository,
        LocaleTransfer $localeTransfer,
        UtilDateTimeServiceInterface $utilDateTimeService,
        UtilSanitizeServiceInterface $utilSanitizeService
    ) {
        $this->merchantReviewGuiPersistenceRepository = $merchantReviewGuiPersistenceRepository;
        $this->localeTransfer = $localeTransfer;
        $this->utilDateTimeService = $utilDateTimeService;
        $this->utilSanitizeService = $utilSanitizeService;

        $this->localeTransfer->requireIdLocale();
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
        $query = $this->merchantReviewGuiPersistenceRepository->getMerchantReviewQuery($this->localeTransfer->getIdLocale());

        $merchantReviewCollection = $this->runQuery($query, $config, true);

        $tableData = [];
        foreach ($merchantReviewCollection as $merchantReviewEntity) {
            $tableData[] = $this->generateItem($merchantReviewEntity);
        }

        return $tableData;
    }

    /**
     * @param \Orm\Zed\MerchantReview\Persistence\SpyMerchantReview $merchantReviewEntity
     *
     * @return array<string, mixed>
     */
    protected function generateItem(SpyMerchantReview $merchantReviewEntity): array
    {
        return [
            MerchantReviewTableConstants::COL_ID_MERCHANT_REVIEW => $merchantReviewEntity->getIdMerchantReview(),
            MerchantReviewTableConstants::COL_CREATED => $this->getCreatedAt($merchantReviewEntity),
            MerchantReviewTableConstants::COL_CUSTOMER_NAME => $this->getCustomerName($merchantReviewEntity),
            MerchantReviewTableConstants::COL_NICK_NAME => $merchantReviewEntity->getNickname(),
            MerchantReviewTableConstants::COL_MERCHANT_NAME => $this->getMerchantName($merchantReviewEntity),
            MerchantReviewTableConstants::COL_RATING => $merchantReviewEntity->getRating(),
            MerchantReviewTableConstants::COL_STATUS => $this->getStatusLabel($merchantReviewEntity->getStatus()),
            MerchantReviewTableConstants::COL_ACTIONS => $this->createActionButtons($merchantReviewEntity),
            MerchantReviewTableConstants::COL_SHOW_DETAILS => $this->createShowDetailsButton(),
            MerchantReviewTableConstants::EXTRA_DETAILS => $this->generateDetails($merchantReviewEntity),
        ];
    }

    /**
     * @param \Orm\Zed\MerchantReview\Persistence\SpyMerchantReview $merchantReviewEntity
     *
     * @return \DateTime|string
     */
    protected function getCreatedAt(SpyMerchantReview $merchantReviewEntity)
    {
        return $this->utilDateTimeService->formatDateTime($merchantReviewEntity->getCreatedAt());
    }

    /**
     * @param \Orm\Zed\MerchantReview\Persistence\SpyMerchantReview $merchantReviewEntity
     *
     * @return string
     */
    protected function getCustomerName(SpyMerchantReview $merchantReviewEntity): string
    {
        return sprintf(
            '<a href="%s" target="_blank">%s %s</a>',
            Url::generate('/customer/view', [
                'id-customer' => $merchantReviewEntity->getVirtualColumn(MerchantReviewTableConstants::COL_MERCHANT_REVIEW_GUI_ID_CUSTOMER),
            ]),
            $this->utilSanitizeService->escapeHtml($merchantReviewEntity->getVirtualColumn(MerchantReviewTableConstants::COL_MERCHANT_REVIEW_GUI_FIRST_NAME)),
            $this->utilSanitizeService->escapeHtml($merchantReviewEntity->getVirtualColumn(MerchantReviewTableConstants::COL_MERCHANT_REVIEW_GUI_LAST_NAME)),
        );
    }

    /**
     * @param \Orm\Zed\MerchantReview\Persistence\SpyMerchantReview $merchantReviewEntity
     *
     * @return mixed
     */
    protected function getMerchantName(SpyMerchantReview $merchantReviewEntity)
    {
        return sprintf(
            '<a href="%s" target="_blank">%s</a>',
            Url::generate('/merchant-gui/edit-merchant', [
                'id-merchant' => $merchantReviewEntity->getFkMerchant(),
            ]),
            $this->utilSanitizeService->escapeHtml($merchantReviewEntity->getVirtualColumn(MerchantReviewTableConstants::COL_MERCHANT_NAME)),
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
     * @param \Orm\Zed\MerchantReview\Persistence\SpyMerchantReview $merchantReviewEntity
     *
     * @return string
     */
    protected function createActionButtons(SpyMerchantReview $merchantReviewEntity): string
    {
        $actions = [];

        $actions[] = $this->generateStatusChangeButton($merchantReviewEntity);
        $actions[] = $this->generateRemoveButton(
            Url::generate('/merchant-review-gui/delete', [
                MerchantReviewTableConstants::PARAM_ID => $merchantReviewEntity->getIdMerchantReview(),
            ]),
            'Delete',
            [],
            DeleteMerchantReviewForm::class,
        );

        return implode(' ', $actions);
    }

    /**
     * @param \Orm\Zed\MerchantReview\Persistence\SpyMerchantReview $merchantReviewEntity
     *
     * @return string
     */
    protected function generateStatusChangeButton(SpyMerchantReview $merchantReviewEntity): string
    {
        $buttons = [];
        switch ($merchantReviewEntity->getStatus()) {
            case MerchantReviewTableConstants::COL_MERCHANT_REVIEW_STATUS_REJECTED:
                $buttons[] = $this->generateApproveButton($merchantReviewEntity);

                break;
            case MerchantReviewTableConstants::COL_MERCHANT_REVIEW_STATUS_APPROVED:
                $buttons[] = $this->generateRejectButton($merchantReviewEntity);

                break;
            case MerchantReviewTableConstants::COL_MERCHANT_REVIEW_STATUS_PENDING:
            default:
                $buttons[] = $this->generateApproveButton($merchantReviewEntity);
                $buttons[] = $this->generateRejectButton($merchantReviewEntity);

                break;
        }

        return implode(' ', $buttons);
    }

    /**
     * @param \Orm\Zed\MerchantReview\Persistence\SpyMerchantReview $merchantReviewEntity
     *
     * @return string
     */
    protected function generateApproveButton(SpyMerchantReview $merchantReviewEntity): string
    {
        return $this->generateFormButton(
            Url::generate('/merchant-review-gui/review-status', [
                MerchantReviewTableConstants::PARAM_ID => $merchantReviewEntity->getIdMerchantReview(),
                MerchantReviewTableConstants::PARAM_STATUS => MerchantReviewTableConstants::COL_MERCHANT_REVIEW_STATUS_APPROVED,
            ]),
            'Approve',
            StatusMerchantReviewForm::class,
            [
                static::BUTTON_CLASS => 'btn-outline',
            ],
        );
    }

    /**
     * @param \Orm\Zed\MerchantReview\Persistence\SpyMerchantReview $merchantReviewEntity
     *
     * @return string
     */
    protected function generateRejectButton(SpyMerchantReview $merchantReviewEntity): string
    {
        return $this->generateFormButton(
            Url::generate('/merchant-review-gui/review-status', [
                MerchantReviewTableConstants::PARAM_ID => $merchantReviewEntity->getIdMerchantReview(),
                MerchantReviewTableConstants::PARAM_STATUS => MerchantReviewTableConstants::COL_MERCHANT_REVIEW_STATUS_REJECTED,
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
     * @param \Orm\Zed\MerchantReview\Persistence\SpyMerchantReview $merchantReviewEntity
     *
     * @return string
     */
    protected function generateDetails(SpyMerchantReview $merchantReviewEntity): string
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
            $this->utilSanitizeService->escapeHtml($merchantReviewEntity->getSummary()),
            $this->utilSanitizeService->escapeHtml($merchantReviewEntity->getDescription()),
        );
    }
}
