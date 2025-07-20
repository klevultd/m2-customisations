<?php

/**
 * This is a demonstration module provided by Klevu with no guarantees, active support, or planned updates
 * It should be used as a base to create your own extension implementing the specific functionality
 *  required for your installation, rather than being directly installed as an out-of-the-box solution
 */

declare(strict_types=1);

namespace Vendor\KlevuIndexingAttributeDefinitions\Plugin\IndexingProducts\Service\AttributeIndexingRecordCreatorService;

use Klevu\IndexingProducts\Service\AttributeIndexingRecordCreatorService;
use Klevu\PhpSDK\Api\Model\Indexing\AttributeInterface as SdkAttributeInterface;
use Klevu\PhpSDK\Model\Indexing\Attribute as SdkAttribute;
use Klevu\PhpSDK\Model\Indexing\AttributeFactory as SdkAttributeFactory;
use Klevu\PhpSDK\Model\Indexing\DataType;
use Magento\Eav\Api\Data\AttributeInterface;

class UpdateAttributeDefinitionPlugin
{
    /**
     * @var SdkAttributeFactory
     */
    private readonly SdkAttributeFactory $attributeFactory;

    /**
     * @param SdkAttributeFactory $attributeFactory
     */
    public function __construct(
        SdkAttributeFactory $attributeFactory,
    ) {
        $this->attributeFactory = $attributeFactory;
    }

    /**
     * @param AttributeIndexingRecordCreatorService $subject
     * @param SdkAttributeInterface $result
     * @param AttributeInterface $attribute
     * @param string $apiKey
     *
     * @return SdkAttributeInterface
     */
    public function afterExecute(
        AttributeIndexingRecordCreatorService $subject,
        SdkAttributeInterface $result,
        AttributeInterface $attribute,
        string $apiKey, // phpcs:ignore SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
    ): SdkAttributeInterface {
        // This will use the attribute code registered in Magento
        switch ($attribute->getAttributeCode()) {
            case 'foo_bar':
                // Note: we're recreating the result attribute object because the method signature calls for the
                //  SDK Attribute interface, which is readonly even though the most likely implementation
                //  (\Klevu\PhpSDK\Model\Indexing\Attribute) has setters
                $result = $this->attributeFactory->create(
                    data: [
                        // You can change any of the attributes used to register the attribute
                        SdkAttribute::FIELD_ATTRIBUTE_NAME => $result->getAttributeName(),
                        // including the data type
                        SdkAttribute::FIELD_DATATYPE => DataType::NUMBER,
                        // and just set any you don't wish to change to the existing value
                        SdkAttribute::FIELD_LABEL => $result->getLabel(),
                        SdkAttribute::FIELD_SEARCHABLE => false,
                        SdkAttribute::FIELD_FILTERABLE => true,
                        SdkAttribute::FIELD_RETURNABLE => $result->isReturnable(),
                        SdkAttribute::FIELD_ABBREVIATE => $result->isAbbreviate(),
                        SdkAttribute::FIELD_RANGEABLE => true,
                    ],
                );
                break;
        }

        // This will use the attribute code registered with Klevu, which may differ if mapping has been applied
        // @see \Klevu\IndexingProducts\Service\AttributeIndexingRecordCreatorService::getAttributeName
        switch ($result->getAttributeName()) {
            case 'filterable_text_field':
                // Alternatively, you can sniff either the concrete implementation...
                if (!($result instanceof SdkAttribute)) {
                    break; // or create using the attributeFactory as a fallback
                }
                // ...or method implementations, rather than creating an entirely new object
                // While sniffing is more verbose, it does protect you from new attribute properties being
                //  added to the SDK in the future, which may not be recreated correctly without updating your
                //  customisations

                // IMPORTANT: there are no setters for attributeName or dataType as these are readonly in the
                //  Attribute class. If you need to change these, you will need to create a new attribute object (above)

                if (method_exists($result, 'setSearchable')) {
                    $result->setSearchable(true);
                }
                if (method_exists($result, 'setFilterable')) {
                    $result->setFilterable(true);
                }
                if (method_exists($result, 'setReturnable')) {
                    $result->setReturnable(true);
                }
                break;
        }

        return $result;
    }
}
