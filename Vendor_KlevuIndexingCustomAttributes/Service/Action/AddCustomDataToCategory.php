<?php

/**
 * This is a demonstration module provided by Klevu with no guarantees, active support, or planned updates
 * It should be used as a base to create your own extension implementing the specific functionality
 *  required for your installation, rather than being directly installed as an out-of-the-box solution
 */

declare(strict_types=1);

namespace Vendor\KlevuIndexingCustomAttributes\Service\Action;

use Magento\Catalog\Api\Data\CategoryInterface;
use Magento\Framework\DataObject;
use Magento\Store\Api\Data\StoreInterface;
use Vendor\KlevuIndexingCustomAttributes\Api\AddCustomDataToEntityActionInterface;

class AddCustomDataToCategory implements AddCustomDataToEntityActionInterface
{
    /**
     * @param mixed $entity
     *
     * @return bool
     */
    public function canExecute(mixed $entity): bool
    {
        return $entity instanceof CategoryInterface
            && $entity instanceof DataObject;
    }

    /**
     * @param object $entity
     * @param StoreInterface|null $store
     *
     * @return void
     * @throws \Random\RandomException
     */
    public function execute(
        object $entity,
        ?StoreInterface $store,
    ): void {
        if (!($entity instanceof DataObject)) {
            return;
        }

        $entity->setData(
            key: 'vendor_custom_category_attribute',
            value: (string)(random_int(1, 1000) / 10),
        );
    }
}
