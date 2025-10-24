<?php

/**
 * Copyright © Klevu Oy. All rights reserved. See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace Vendor\KlevuIndexingCustomEntities\Service;

use Klevu\Indexing\Exception\InvalidIndexingRecordDataTypeException;
use Klevu\Indexing\Model\EntityIndexingRecordFactory;
use Klevu\IndexingApi\Model\EntityIndexingRecordInterface;
use Klevu\IndexingApi\Model\Source\Actions;
use Klevu\IndexingApi\Service\EntityIndexingRecordCreatorServiceInterface;
use Magento\Cms\Api\Data\PageInterface;
use Magento\Framework\Api\ExtensibleDataInterface;
use Vendor\KlevuIndexingCustomEntities\Api\Data\CustomEntityInterface;

class EntityIndexingRecordCreatorService implements EntityIndexingRecordCreatorServiceInterface
{
    /**
     * @var EntityIndexingRecordFactory
     */
    private readonly EntityIndexingRecordFactory $entityIndexingRecordFactory;

    /**
     * @param EntityIndexingRecordFactory $entityIndexingRecordFactory
     */
    public function __construct(EntityIndexingRecordFactory $entityIndexingRecordFactory)
    {
        $this->entityIndexingRecordFactory = $entityIndexingRecordFactory;
    }

    /**
     * @param int $recordId
     * @param Actions $action
     * @param PageInterface|ExtensibleDataInterface $entity
     * @param PageInterface|ExtensibleDataInterface|null $parent
     *
     * @return EntityIndexingRecordInterface
     */
    public function execute(
        int $recordId,
        Actions $action,
        PageInterface|ExtensibleDataInterface $entity,
        // phpcs:ignore SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
        PageInterface|ExtensibleDataInterface|null $parent = null,
    ): EntityIndexingRecordInterface {
        if (!($entity instanceof CustomEntityInterface)) {
            throw new InvalidIndexingRecordDataTypeException(
                sprintf(
                    '"entity" provided to %s, must be instance of %s',
                    self::class,
                    CustomEntityInterface::class,
                ),
            );
        }
        if ($parent && !($parent instanceof CustomEntityInterface)) {
            throw new InvalidIndexingRecordDataTypeException(
                sprintf(
                    '"parent" provided to %s, must be instance of %s or null',
                    self::class,
                    CustomEntityInterface::class,
                ),
            );
        }

        return $this->entityIndexingRecordFactory->create([
            'recordId' => $recordId,
            'entity' => $entity,
            'parent' => null,
            'action' => $action,
        ]);
    }
}
