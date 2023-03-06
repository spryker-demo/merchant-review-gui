<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\MerchantReviewGui\Communication\Table;

use Generated\Shared\Transfer\LocaleTransfer;
use Orm\Zed\MerchantReview\Persistence\SpyMerchantReview;
use Pyz\Zed\MerchantReviewGui\Communication\Form\DeleteMerchantReviewForm;
use Pyz\Zed\MerchantReviewGui\Communication\Form\StatusMerchantReviewForm;
use Pyz\Zed\MerchantReviewGui\Persistence\MerchantReviewGuiQueryContainerInterface;
use Spryker\Service\UtilDateTime\UtilDateTimeServiceInterface;
use Spryker\Service\UtilSanitize\UtilSanitizeServiceInterface;
use Spryker\Service\UtilText\Model\Url\Url;
use Spryker\Zed\Gui\Communication\Table\AbstractTable;
use Spryker\Zed\Gui\Communication\Table\TableConfiguration;

class MerchantReviewTable extends AbstractTable
{
    /**
     * @var \Pyz\Zed\MerchantReviewGui\Persistence\MerchantReviewGuiQueryContainerInterface
     */
    protected $merchantReviewGuiQueryContainer;

    /**
     * @var \Generated\Shared\Transfer\LocaleTransfer
     */
    protected $localeTransfer;

    /**
     * @var \Spryker\Service\UtilDateTime\UtilDateTimeServiceInterface
     */
    protected $utilDateTimeService;

    /**
     * @var \Spryker\Service\UtilSanitize\UtilSanitizeServiceInterface
     */
    protected $utilSanitizeService;

    /**
     * @param \Pyz\Zed\MerchantReviewGui\Persistence\MerchantReviewGuiQueryContainerInterface $merchantReviewGuiQueryContainer
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     * @param \Spryker\Service\UtilDateTime\UtilDateTimeServiceInterface $utilDateTimeService
     * @param \Spryker\Service\UtilSanitize\UtilSanitizeServiceInterface $utilSanitizeService
     */
    public function __construct(
        MerchantReviewGuiQueryContainerInterface $merchantReviewGuiQueryContainer,
        LocaleTransfer $localeTransfer,
        UtilDateTimeServiceInterface $utilDateTimeService,
        UtilSanitizeServiceInterface $utilSanitizeService
    ) {
        $this->merchantReviewGuiQueryContainer = $merchantReviewGuiQueryContainer;
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
    protected function configure(TableConfiguration $config)
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

        $config->setDefaultSortField(MerchantReviewTableConstants::COL_ID_MERCHANT_REVIEW, MerchantReviewTableConstants::SORT_DESC);
        $config->setStateSave(false);

        return $config;
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return array
     */
    protected function prepareData(TableConfiguration $config)
    {
        $query = $this->merchantReviewGuiQueryContainer->queryMerchantReview($this->localeTransfer->getIdLocale());

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
     * @return array
     */
    protected function generateItem(SpyMerchantReview $merchantReviewEntity)
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
     * @param string $status
     *
     * @return string
     */
    protected function getStatusLabel($status)
    {
        switch ($status) {
            case MerchantReviewTableConstants::COL_MERCHANT_REVIEW_STATUS_REJECTED:
                return $this->generateLabel('Rejected', 'label-danger');
            case MerchantReviewTableConstants::COL_MERCHANT_REVIEW_STATUS_APPROVED:
                return $this->generateLabel('Approved', 'label-success');
            case MerchantReviewTableConstants::COL_MERCHANT_REVIEW_STATUS_PENDING:
            default:
                return $this->generateLabel('Pending', 'label-secondary');
        }
    }

    /**
     * @return string
     */
    protected function createShowDetailsButton()
    {
        return '<i class="fa fa-chevron-down"></i>';
    }

    /**
     * @param \Orm\Zed\MerchantReview\Persistence\SpyMerchantReview $merchantReviewEntity
     *
     * @return string
     */
    protected function createActionButtons(SpyMerchantReview $merchantReviewEntity)
    {
        $actions = [];

        $actions[] = $this->generateStatusChangeButton($merchantReviewEntity);
        $actions[] = $this->generateRemoveButton(
            Url::generate('/merchant-review-gui/delete', [
                MerchantReviewTableConstants::PARAM_ID => $merchantReviewEntity->getIdMerchantReview(),
            ]),
            'Delete',
            [],
            DeleteMerchantReviewForm::class
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
            Url::generate('/merchant-review-gui/update/approve', [
                MerchantReviewTableConstants::PARAM_ID => $merchantReviewEntity->getIdMerchantReview(),
            ]),
            'Approve',
            StatusMerchantReviewForm::class,
            [
                static::BUTTON_CLASS => 'btn-outline',
            ]
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
            Url::generate('/merchant-review-gui/update/reject', [
                MerchantReviewTableConstants::PARAM_ID => $merchantReviewEntity->getIdMerchantReview(),
            ]),
            'Reject',
            StatusMerchantReviewForm::class,
            [
                static::BUTTON_CLASS => 'btn-view',
            ]
        );
    }

    /**
     * @param \Orm\Zed\MerchantReview\Persistence\SpyMerchantReview $merchantReviewEntity
     *
     * @return string
     */
    protected function generateDetails(SpyMerchantReview $merchantReviewEntity)
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
            $this->utilSanitizeService->escapeHtml($merchantReviewEntity->getDescription())
        );
    }

    /**
     * @param \Orm\Zed\MerchantReview\Persistence\SpyMerchantReview $merchantReviewEntity
     *
     * @return string
     */
    protected function getCustomerName(SpyMerchantReview $merchantReviewEntity)
    {
        return sprintf(
            '<a href="%s" target="_blank">%s %s</a>',
            Url::generate('/customer/view', [
                'id-customer' => $merchantReviewEntity->getVirtualColumn(MerchantReviewTableConstants::COL_MERCHANT_REVIEW_GUI_ID_CUSTOMER),
            ]),
            $this->utilSanitizeService->escapeHtml($merchantReviewEntity->getVirtualColumn(MerchantReviewTableConstants::COL_MERCHANT_REVIEW_GUI_FIRST_NAME)),
            $this->utilSanitizeService->escapeHtml($merchantReviewEntity->getVirtualColumn(MerchantReviewTableConstants::COL_MERCHANT_REVIEW_GUI_LAST_NAME))
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
            $this->utilSanitizeService->escapeHtml($merchantReviewEntity->getVirtualColumn(MerchantReviewTableConstants::COL_MERCHANT_NAME))
        );
    }

    /**
     * @param \Orm\Zed\MerchantReview\Persistence\SpyMerchantReview $merchantReviewEntity
     *
     * @return string|\DateTime
     */
    protected function getCreatedAt(SpyMerchantReview $merchantReviewEntity)
    {
        return $this->utilDateTimeService->formatDateTime($merchantReviewEntity->getCreatedAt());
    }
}
