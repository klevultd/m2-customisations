<?php

/**
 * This is a demonstration module provided by Klevu with no guarantees, active support, or planned updates
 * It should be used as a base to create your own extension implementing the specific functionality
 *  required for your installation, rather than being directly installed as an out-of-the-box solution
 */

declare(strict_types=1);

namespace Vendor\KlevuIndexingCustomEntities\Service\Provider;

use Klevu\Configuration\Service\Provider\ScopeConfigProviderInterface;
use Klevu\IndexingApi\Service\Provider\EntityProviderInterface;
use Magento\Store\Api\Data\StoreInterface;
use Psr\Log\LoggerInterface;
use Vendor\KlevuIndexingCustomEntities\Api\Data\CustomEntityInterface;
use Vendor\KlevuIndexingCustomEntities\Api\Data\CustomEntityInterfaceFactory;

class CustomEntityProvider implements EntityProviderInterface
{
    /**
     * @var LoggerInterface
     */
    private readonly LoggerInterface $logger;
    /**
     * @var ScopeConfigProviderInterface
     */
    private readonly ScopeConfigProviderInterface $syncEnabledProvider;
    /**
     * @var CustomEntityInterfaceFactory
     */
    private readonly CustomEntityInterfaceFactory $customEntityFactory;
    /**
     * @var int
     */
    private readonly int $batchSize;

    /**
     * @param LoggerInterface $logger
     * @param ScopeConfigProviderInterface $syncEnabledProvider
     * @param CustomEntityInterfaceFactory $customEntityFactory
     * @param int $batchSize
     */
    public function __construct(
        LoggerInterface $logger,
        ScopeConfigProviderInterface $syncEnabledProvider,
        CustomEntityInterfaceFactory $customEntityFactory,
        int $batchSize = 5,
    ) {
        $this->logger = $logger;
        $this->syncEnabledProvider = $syncEnabledProvider;
        $this->customEntityFactory = $customEntityFactory;
        $this->batchSize = $batchSize;
    }

    /**
     * @param StoreInterface|null $store
     * @param int[]|null $entityIds
     *
     * @return \Generator<CustomEntityInterface[]>|null
     */
    public function get(
        ?StoreInterface $store = null,
        ?array $entityIds = [],
    ): ?\Generator {
        // Included to support disabling sync via configuration
        if (!$this->syncEnabledProvider->get()) {
            return null;
        }

        $currentEntityId = 0;
        while (true) {
            // We're using placeholder logic in this example module
            // You should retrieve this with a batchable method of retrieving your entities
            //  for example, paginating through a repository or collection
            // Remember to account for store id filters if passed
            $customEntitiesBatch = $this->getCustomEntitiesBatch(
                store: $store,
                entityIds: $entityIds,
                pageSize: $this->batchSize,
                currentEntityId: $currentEntityId + 1,
            );
            if (!$customEntitiesBatch) {
                break;
            }

            yield $customEntitiesBatch;

            $lastEntity = end($customEntitiesBatch);
            $currentEntityId = $lastEntity->getEntityId();

            if (null === $this->batchSize || count($customEntitiesBatch) < $this->batchSize) {
                break;
            }
        }
    }

    /**
     * @return string|null
     */
    public function getEntitySubtype(): ?string
    {
        return 'custom_entity_subtype';
    }

    /**
     * @param StoreInterface|null $store
     * @param array|null $entityIds
     * @param int|null $pageSize
     * @param int $currentEntityId
     *
     * @return CustomEntityInterface[]
     */
    private function getCustomEntitiesBatch(
        ?StoreInterface $store,
        ?array $entityIds,
        ?int $pageSize = null,
        int $currentEntityId = 1,
    ): array {
        $allEntityIds = [
            1, 2, 4, 5, 10, 12, 13, 14, 15, 26, 27, 28, 29, 42, 48, 51,
        ];
        if ($entityIds) { // This is intentionally truthy, even though null is permitted
            $allEntityIds = array_values(
                array: array_intersect($allEntityIds, $entityIds),
            );
        }
        $batchEntityIds = array_slice(
            array: array_filter(
                array: $allEntityIds,
                callback: static fn (int $entityId) => $entityId >= $currentEntityId,
            ),
            offset: 0,
            length: $pageSize,
        );

        $customEntitiesBatch = [];
        foreach ($batchEntityIds as $entityId) {
            $customEntity = $this->customEntityFactory->create();
            $customEntity->setEntityId($entityId);
            $customEntity->setPostTitle(
                postTitle: sprintf('Sample Post Title (%s)', $entityId),
            );
            $customEntity->setPostContent(
                postContent: sprintf('This is the content for Sample Post Title (%s)', $entityId),
            );
            $customEntity->setHandle(
                handle: sprintf('sample-post-title-%s', $entityId),
            );
            $customEntity->setPublishedAt(
                publishedAt: (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
            );

            $customEntitiesBatch[$entityId] = $customEntity;
        }

        return $customEntitiesBatch;
    }
}
