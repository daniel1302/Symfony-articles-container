<?php
namespace AppBundle\Model\DocumentManager;


use AppBundle\Document\DocumentInterface;

interface DocumentManagerInterface
{
    const KEY_ID    = 'id';
    const KEY_OBJ   = 'object';

    /**
     * Insert document into MongoDB
     *
     * @param DocumentInterface $document
     * @return mixed
     */
    public function insert(DocumentInterface $document) : bool;

    /**
     * Find object in db by id
     *
     * @param string $id
     * @return DocumentInterface|null
     */
    public function find(string $id) : ?DocumentInterface;

    /**
     * @param array $params
     * @param int|null $limit
     * @param int|null $offset
     *
     * @return array
     */
    public function findAll(array $params = [], int $limit = null, int $offset = null) : array;

    /**
     * Cont rows in db
     * @return int
     */
    public function count(): int;

    /**
     * Update document
     *
     * @param DocumentInterface $document
     * @return bool
     */
    public function update(DocumentInterface $document): bool;
}