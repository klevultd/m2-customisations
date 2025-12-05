<?php

/**
 * This is a demonstration module provided by Klevu with no guarantees, active support, or planned updates
 * It should be used as a base to create your own extension implementing the specific functionality
 *  required for your installation, rather than being directly installed as an out-of-the-box solution
 */

declare(strict_types=1);

namespace Vendor\KlevuIndexingCustomAttributes\Pipeline\Transformer;

use Klevu\Pipelines\Exception\Transformation\InvalidInputDataException;
use Klevu\Pipelines\Model\ArgumentIterator;
use Klevu\Pipelines\Transformer\TransformerInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Vendor\KlevuIndexingCustomAttributes\Pipeline\Provider\Argument\Transformer\GetVendorCustomProductAttributeArgumentProvider;

class GetVendorCustomProductAttribute implements TransformerInterface
{
    /**
     * @var GetVendorCustomProductAttributeArgumentProvider
     */
    private readonly GetVendorCustomProductAttributeArgumentProvider $argumentProvider;

    /**
     * @param GetVendorCustomProductAttributeArgumentProvider $argumentProvider
     */
    public function __construct(
        GetVendorCustomProductAttributeArgumentProvider $argumentProvider,
    ) {
        $this->argumentProvider = $argumentProvider;
    }

    /**
     * @param mixed $data
     * @param ArgumentIterator|null $arguments
     * @param \ArrayAccess|null $context
     *
     * @return string|null
     */
    public function transform(
        mixed $data,
        ?ArgumentIterator $arguments = null,
        ?\ArrayAccess $context = null,
    ): string|null {
        if (!($data instanceof ProductInterface)) {
            throw new InvalidInputDataException(
                transformerName: $this::class,
                expectedType: ProductInterface::class,
                arguments: $arguments,
                data: $data,
            );
        }
        // Unused in this demo
        $storeIdValue = $this->argumentProvider->getStoreIdArgumentValue(
            arguments: $arguments,
            extractionPayload: $data,
            extractionContext: $context,
        );

        // Implement whatever data retrieval and setter logic is required here
        return sprintf(
            'Injected from %s',
            __METHOD__,
        );
    }
}