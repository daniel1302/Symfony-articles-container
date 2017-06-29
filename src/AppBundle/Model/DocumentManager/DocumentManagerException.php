<?php
namespace AppBundle\Model\DocumentManager;


class DocumentManagerException extends \Exception
{
    const CODE_NON_SERIALIZED       = 10;
    const CODE_INVALID_SERIALIZED   = 11;



    public static function forNonSerializedObject($objectId, \Exception $prev = null): DocumentManagerException
    {
        return new self(
            sprintf("Object ID: %s has not serialized data into self", $objectId),
            self::CODE_NON_SERIALIZED,
            $prev
        );
    }

    public static function foInvalidSerializedObject($objectId, \Exception $prev = null): DocumentManagerException
    {
        return new self(
            sprintf("Object ID: %s has invalid serialized data into self", $objectId),
            self::CODE_INVALID_SERIALIZED,
            $prev
        );
    }
}