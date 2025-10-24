<?php

/**
 * This is a demonstration module provided by Klevu with no guarantees, active support, or planned updates
 * It should be used as a base to create your own extension implementing the specific functionality
 *  required for your installation, rather than being directly installed as an out-of-the-box solution
 */

declare(strict_types=1);

namespace Vendor\KlevuIndexingCustomEntities\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

// ExtensibleDataInterface required to hook into \Klevu\IndexingApi\Service\EntityIndexingRecordCreatorServiceInterface
interface CustomEntityInterface extends ExtensibleDataInterface
{
    public const FIELD_ENTITY_ID = 'entity_id';
    public const FIELD_POST_TITLE = 'post_title';
    public const FIELD_POST_CONTENT = 'post_content';
    public const FIELD_HANDLE = 'handle';
    public const FIELD_PUBLISHED_AT = 'published_at';

    /**
     * @return int|null
     */
    public function getId(): ?int;
    /**
     * @return int|null
     */
    public function getEntityId(): ?int;

    /**
     * @param int $entityId
     *
     * @return void
     */
    public function setEntityId(int $entityId): void;

    /**
     * @return string
     */
    public function getPostTitle(): string;

    /**
     * @param string $postTitle
     *
     * @return void
     */
    public function setPostTitle(string $postTitle): void;

    /**
     * @return string
     */
    public function getPostContent(): string;

    /**
     * @param string $postContent
     *
     * @return void
     */
    public function setPostContent(string $postContent): void;

    /**
     * @return string
     */
    public function getHandle(): string;

    /**
     * @param string $handle
     *
     * @return void
     */
    public function setHandle(string $handle): void;

    /**
     * @return string
     */
    public function getPublishedAt(): string;

    /**
     * @param string $publishedAt
     *
     * @return void
     */
    public function setPublishedAt(string $publishedAt): void;
}
