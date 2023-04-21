<?php

namespace DjoSmer\CustomOptionSwatch\Block\Product\View;

use Magento\Catalog\Model\Product\Option;

class Options extends \Magento\Catalog\Block\Product\View\Options
{

    /**
     * Get option html block
     *
     * @param Option $option
     * @return string
     */
    public function getOptionHtml(Option $option): string
    {
        $type = $this->getGroupOfOption($option->getType());
        $renderer = $this->getChildBlock($type);

        if (!$renderer) {
            return '';
        }

        $renderer->setProduct($this->getProduct())->setOption($option);

        return $this->getChildHtml($type, false);
    }

    public function getGroupsOfOption(): array
    {
        $groups = $this->_registry->registry('groups_custom_option');
        if (!$groups) {
            if ($this->_registry->registry('current_product')) {
                $this->_product = $this->_registry->registry('current_product');
            } else {
                throw new \LogicException('Product is not defined');
            }

            $options = $this->decorateArray($this->getOptions());
            $groups = [];
            foreach ($options as $option) {
                $group = $option->getData('group');
                if (!isset($groups[$group])) {
                    $groups[$group] = [];
                }
                $groups[$group][] = $option;
            }
        }



        return $groups;
    }
}
