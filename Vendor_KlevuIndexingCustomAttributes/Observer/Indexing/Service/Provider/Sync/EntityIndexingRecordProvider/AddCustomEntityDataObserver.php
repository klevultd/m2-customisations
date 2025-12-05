<?php

/**
 * This is a demonstration module provided by Klevu with no guarantees, active support, or planned updates
 * It should be used as a base to create your own extension implementing the specific functionality
 *  required for your installation, rather than being directly installed as an out-of-the-box solution
 */

declare(strict_types=1);

namespace Vendor\KlevuIndexingCustomAttributes\Observer\Indexing\Service\Provider\Sync\EntityIndexingRecordProvider;

use Klevu\IndexingApi\Model\Source\Actions;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Store\Api\Data\StoreInterface;
use Vendor\KlevuIndexingCustomAttributes\Api\AddCustomDataToEntityActionInterface;

class AddCustomEntityDataObserver implements ObserverInterface
{
    /**
     * @var array<string, AddCustomDataToEntityActionInterface>
     */
    private array $addCustomDataToEntityActions = [];

    /**
     * @param array<string, AddCustomDataToEntityActionInterface|null> $addCustomDataToEntityActions
     */
    public function __construct(
        array $addCustomDataToEntityActions = [],
    ) {
        array_walk($addCustomDataToEntityActions, [$this, 'addCustomDataToEntityAction']);
    }

    /**
     * @param Observer $observer
     *
     * @return void
     */
    public function execute(Observer $observer): void
    {
        $event = $observer->getEvent();

        $action = $event->getData('action');
        if (!in_array($action, [Actions::UPDATE, Actions::ADD], true)) {
            return;
        }

        /** @var StoreInterface|null $store */
        $store = $event->getData('store');

        $entities = $event->getData('entities');
        if (!is_array($entities) || empty($entities)) {
            return;
        }

        foreach ($entities as $entity) {
            $filteredAddCustomDataToEntityActions = array_filter(
                array: $this->addCustomDataToEntityActions,
                callback: static fn (AddCustomDataToEntityActionInterface $addCustomDataToEntityAction): bool => (
                    $addCustomDataToEntityAction->canExecute($entity)
                ),
            );

            foreach ($filteredAddCustomDataToEntityActions as $addCustomDataToEntityAction) {
                $addCustomDataToEntityAction->execute(
                    entity: $entity,
                    store: $store,
                );
            }
        }
    }

    /**
     * @param AddCustomDataToEntityActionInterface|null $addCustomDataToEntityAction
     * @param string $identifier
     *
     * @return void
     */
    private function addCustomDataToEntityAction(
        ?AddCustomDataToEntityActionInterface $addCustomDataToEntityAction,
        string $identifier,
    ): void {
        if (null === $addCustomDataToEntityAction) {
            return;
        }

        $this->addCustomDataToEntityActions[$identifier] = $addCustomDataToEntityAction;
    }
}
