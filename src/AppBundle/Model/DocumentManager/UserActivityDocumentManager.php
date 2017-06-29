<?php
namespace AppBundle\Model\DocumentManager;


use AppBundle\Document\UserActivity;

class UserActivityDocumentManager extends DocumentManager
{

    /**
     * Return collection name where objects are stored
     * @return string
     */
    public function getCollectionName(): string
    {
        return 'user_activity';
    }

    /**
     * Get class name for deserialize object
     * @return string
     */
    public function getClassName(): string
    {
        return UserActivity::class;
    }
}