<?php
/**
 * author E.Demidov
 */
namespace DjoSmer\CustomOptionSwatch\Config\Reader\Definition;

use Magento\Framework\Module\Dir;
use Magento\Framework\Module\Dir\Reader;

/**
 * Config schema locator interface
 */
class SchemaLocator implements \Magento\Framework\Config\SchemaLocatorInterface
{
    /**
     * Path to corresponding XSD file with validation rules for merged config
     *
     * @var string
     */
    private string $schema;

    /**
     * @param Reader $moduleReader
     */
    public function __construct(Reader $moduleReader)
    {
        $this->schema = $moduleReader->getModuleDir(Dir::MODULE_ETC_DIR, 'DjoSmer_CustomOptionSwatch') . '/' . 'ui_definition.xsd';
    }

    /**
     * @inheritdoc
     */
    public function getSchema(): ?string
    {
        return $this->schema;
    }

    /**
     * @inheritdoc
     */
    public function getPerFileSchema(): ?string
    {
        return null;
    }
}
