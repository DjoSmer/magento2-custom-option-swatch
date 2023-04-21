<?php
/**
 * author E.Demidov
 */
namespace DjoSmer\CustomOptionSwatch\Component\Form\Element;

use Magento\Framework\File\Size;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\Component\Form\Element\AbstractElement;
use Magento\Ui\Component\Form\Element\DataType\Media\OpenDialogUrl;

class Swatch extends AbstractElement
{
    const NAME = 'swatch';

    public function getComponentName(): string
    {
        return static::NAME;
    }

    /**
     * @var StoreManagerInterface
     */
    private StoreManagerInterface $storeManager;

    /**
     * @var Size
     */
    private Size $fileSize;

    /**
     * @var OpenDialogUrl
     */
    private OpenDialogUrl $openDialogUrl;

    /**
     * @param ContextInterface $context
     * @param StoreManagerInterface $storeManager
     * @param Size $fileSize
     * @param OpenDialogUrl $openDialogUrl
     * @param UiComponentInterface[] $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        StoreManagerInterface $storeManager,
        Size $fileSize,
        OpenDialogUrl $openDialogUrl,
        array $components = [],
        array $data = []
    ) {
        $this->storeManager = $storeManager;
        $this->fileSize = $fileSize;
        $this->openDialogUrl = $openDialogUrl;
        parent::__construct($context, $components, $data);
    }

    public function prepare()
    {
        // dynamically set max file size based on php ini config if not present in XML
        $maxFileSize = min(array_filter([
            $this->getConfiguration()['maxFileSize'] ?? 0,
            $this->fileSize->getMaxFileSize()
        ]));

        $data = array_replace_recursive(
            $this->getData(),
            [
                'config' => [
                    'maxFileSize' => $maxFileSize,
                    'mediaGallery' => [
                        'openDialogUrl' => $this->getContext()->getUrl(
                            $this->openDialogUrl->get(),
                            ['_secure' => true]
                        ),
                        'openDialogTitle' => $this->getConfiguration()['openDialogTitle'] ?? __('Insert Images...'),
                        'initialOpenSubpath' => 'wysiwyg',
                        'mediaPrefix' => '/' . UrlInterface::URL_TYPE_MEDIA,
                        'storeId' => $this->storeManager->getStore()->getId(),
                    ],
                ],
            ]
        );

        $this->setData($data);
        parent::prepare();
    }
}
