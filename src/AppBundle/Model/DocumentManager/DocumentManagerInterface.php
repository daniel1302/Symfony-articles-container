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
     * List all objects from db
     *
     * @return array
     */
    public function findAll() : array;
}