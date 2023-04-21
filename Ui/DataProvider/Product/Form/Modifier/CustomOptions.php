<?php
/**
 * Copyright (c) InGraph, 2023
 * author E.Demidov
 */

namespace DjoSmer\CustomOptionSwatch\Ui\DataProvider\Product\Form\Modifier;

use DjoSmer\CustomOptionSwatch\Component\Form\Element\Swatch;
use Magento\Ui\Component\Form\Element\Checkbox;
use Magento\Ui\Component\Form\Element\DataType\Text;
use Magento\Ui\Component\Form\Field;

class CustomOptions extends \Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\CustomOptions
{
    public const FIELD_SWATCH_NAME = 'swatch';
    public const FIELD_CHECKED_NAME = 'checked';
    public const FIELD_GROUP_NAME = 'group';

    protected function getCommonContainerConfig($sortOrder): array
    {
        $config = parent::getCommonContainerConfig($sortOrder);
        $config['children'][static::FIELD_GROUP_NAME] = $this->getTitleFieldConfig(35, [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => __('Group'),
                        'dataScope' => static::FIELD_GROUP_NAME,
                        'validation' => [
                            'required-entry' => false
                        ]
                    ],
                ],
            ],
        ]);
        return $config;
    }

    protected function getSelectTypeGridConfig($sortOrder): array
    {
        $fieldConfig = parent::getSelectTypeGridConfig($sortOrder);
        $fieldConfig['children']['record']['children'][static::FIELD_CHECKED_NAME] = $this->getCheckedFieldConfig(5);
        $fieldConfig['children']['record']['children'][static::FIELD_SWATCH_NAME] = $this->getSwatchFieldConfig(7);

        return $fieldConfig;
    }

    protected function getSwatchFieldConfig(int $sortOrder): array
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => __('Swatch'),
                        'componentType' => Field::NAME,
                        'formElement' => Swatch::NAME,
                        'dataScope' => static::FIELD_SWATCH_NAME,
                        'dataType' => Text::NAME,
                        'sortOrder' => $sortOrder,
                    ],
                ],
            ],
        ];
    }

    protected function getCheckedFieldConfig(int $sortOrder): array
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => __('Checked'),
                        'componentType' => Field::NAME,
                        'formElement' => Checkbox::NAME,
                        'dataScope' => static::FIELD_CHECKED_NAME,
                        'dataType' => Text::NAME,
                        'sortOrder' => $sortOrder,
                        'value' => '0',
                        'valueMap' => [
                            'true' => '1',
                            'false' => '0'
                        ],
                    ],
                ],
            ],
        ];
    }
}
