<?php

namespace Dtn\Office\Ui\Component\Listing\Columns\Employee;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\UrlInterface;

/**
 * Class PageActions
 */
class Actions extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * Url path
     */
    const EMPLOYEE_URL_PATH_EDIT = 'dtn/employee/edit';
    const EMPLOYEE_URL_PATH_DELETE = 'dtn/employee/delete';

    protected $urlBuilder;

    private $editUrl;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [],
        $editUrl = self::EMPLOYEE_URL_PATH_EDIT
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->editUrl = $editUrl;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            // Get column name
            $fieldName = $this->getData('name');

            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['employee_id'])) {
                    // Add Edit link
                    $item[$fieldName]['edit'] = [
                        'href' => $this->urlBuilder->getUrl($this->editUrl, ['employee_id' => $item['employee_id']]),
                        'label' => __('Edit')
                    ];

                    // Add Delete link
                    $item[$fieldName]['delete'] = [
                        'href' => $this->urlBuilder->getUrl(self::EMPLOYEE_URL_PATH_DELETE, ['employee_id' => $item['employee_id']]),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete ${ $.$data.image }'),
                            'message' => __('Are you sure you wan\'t to delete this record?')
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }
}