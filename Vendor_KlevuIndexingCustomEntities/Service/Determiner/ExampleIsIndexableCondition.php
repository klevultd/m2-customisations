<?php

/**
 * This is a demonstration module provided by Klevu with no guarantees, active support, or planned updates
 * It should be used as a base to create your own extension implementing the specific functionality
 *  required for your installation, rather than being directly installed as an out-of-the-box solution
 */

declare(strict_types=1);

namespace Vendor\KlevuIndexingCustomEntities\Service\Determiner;

use Klevu\IndexingApi\Service\Determiner\IsIndexableConditionInterface;
use Magento\Cms\Api\Data\PageInterface;
use Magento\Framework\Api\ExtensibleDataInterface;
use Magento\Store\Api\Data\StoreInterface;

class ExampleIsIndexableCondition implements IsIndexableConditionInterface
{
    /**
     * @param PageInterface|ExtensibleDataInterface $entity
     * @param StoreInterface $store
     * @param string $entitySubtype
     *
     * @return bool
     */
    public function execute(
        PageInterface|ExtensibleDataInterface $entity,
        StoreInterface $store,
        string $entitySubtype = '',
    ): bool {
        // Add your own logic here

        return true;
    }
}
