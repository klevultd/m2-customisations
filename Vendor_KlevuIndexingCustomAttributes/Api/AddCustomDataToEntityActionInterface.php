<?php

/**
 * This is a demonstration module provided by Klevu with no guarantees, active support, or planned updates
 * It should be used as a base to create your own extension implementing the specific functionality
 *  required for your installation, rather than being directly installed as an out-of-the-box solution
 */

declare(strict_types=1);

namespace Vendor\KlevuIndexingCustomAttributes\Api;

use Magento\Store\Api\Data\StoreInterface;

interface AddCustomDataToEntityActionInterface
{
    /**
     * @param mixed $entity
     *
     * @return bool
     */
    public function canExecute(mixed $entity): bool;

    /**
     * @param object $entity
     * @param StoreInterface|null $store
     *
     * @return void
     */
    public function execute(object $entity, ?StoreInterface $store): void;
}
