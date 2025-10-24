<?php

/**
 * This is a demonstration module provided by Klevu with no guarantees, active support, or planned updates
 * It should be used as a base to create your own extension implementing the specific functionality
 *  required for your installation, rather than being directly installed as an out-of-the-box solution
 */

declare(strict_types=1);

namespace Vendor\KlevuIndexingCustomEntities\Model;

use Magento\Framework\DataObject;
use Vendor\KlevuIndexingCustomEntities\Api\Data\CustomEntityInterface;

class CustomEntity extends DataObject implements CustomEntityInterface
{
    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->getEntityId();
    }

    /**
     * @return int|null
     */
    public function getEntityId(): ?int
    {
        $entityId = $this->getData(static::FIELD_ENTITY_ID);
        if (!is_int($entityId)) {
            $entityId = is_numeric($entityId)
                ? (int)$entityId
                : null;
            $this->setEntityId($entityId);
        }

        return $entityId;
    }

    /**
     * @param int $entityId
     *
     * @return void
     */
    public function setEntityId(int $entityId): void
    {
        $this->setData(static::FIELD_ENTITY_ID, $entityId);
    }

    /**
     * @return string
     */
    public function getPostTitle(): string
    {
        return (string)$this->getData(static::FIELD_POST_TITLE);
    }

    /**
     * @param string $postTitle
     *
     * @return void
     */
    public function setPostTitle(string $postTitle): void
    {
        $this->setData(static::FIELD_POST_TITLE, $postTitle);
    }

    /**
     * @return string
     */
    public function getPostContent(): string
    {
        return (string)$this->getData(static::FIELD_POST_CONTENT);
    }

    /**
     * @param string $postContent
     *
     * @return void
     */
    public function setPostContent(string $postContent): void
    {
        $this->setData(static::FIELD_POST_CONTENT, $postContent);
    }

    /**
     * @return string
     */
    public function getHandle(): string
    {
        return (string)$this->getData(static::FIELD_HANDLE);
    }

    /**
     * @param string $handle
     *
     * @return void
     */
    public function setHandle(string $handle): void
    {
        $this->setData(static::FIELD_HANDLE, $handle);
    }

    /**
     * @return string
     */
    public function getPublishedAt(): string
    {
        return (string)$this->getData(static::FIELD_PUBLISHED_AT);
    }

    /**
     * @param string $publishedAt
     *
     * @return void
     */
    public function setPublishedAt(string $publishedAt): void
    {
        $this->setData(static::FIELD_PUBLISHED_AT, $publishedAt);
    }
}
