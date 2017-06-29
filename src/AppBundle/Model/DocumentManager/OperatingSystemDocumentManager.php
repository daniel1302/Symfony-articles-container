<?php
namespace AppBundle\Model\DocumentManager;


use AppBundle\Document\OperatingSystem;

class OperatingSystemDocumentManager extends DocumentManager
{

    /**
     * Return collection name where objects are stored
     * @return string
     */
    public function getCollectionName(): string
    {
        return 'operating_system';
    }

    /**
     * Get class name for deserialize object
     * @return string
     */
    public function getClassName(): string
    {
        return OperatingSystem::class;
    }
}