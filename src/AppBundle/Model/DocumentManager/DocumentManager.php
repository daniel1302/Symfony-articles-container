<?php
namespace AppBundle\Model\DocumentManager;



use AppBundle\Document\DocumentInterface;
use MongoDB\Database;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

abstract class DocumentManager implements DocumentManagerInterface
{
    /**
     * @var Database
     */
    private $database;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * Return collection name where objects are stored
     * @return string
     */
    abstract public function getCollectionName(): string;

    /**
     * Get class name for deserialize object
     * @return string
     */
    abstract public function getClassName(): string;

    public function __construct(Database $mongoDbManager)
    {
        $this->database = $mongoDbManager;


        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $this->serializer = new Serializer($normalizers, $encoders);
    }

    public function insert(DocumentInterface $document): bool
    {
        $documentId = md5(microtime(true));


        $document->setId($documentId);

        $serializedJson = $this->serializer->serialize($document, 'json');

        $collection = $this->database->selectCollection($this->getCollectionName());
        $collection->insertOne([
            DocumentManagerInterface::KEY_ID    => $documentId,
            DocumentManagerInterface::KEY_OBJ   => $serializedJson
        ]);

        return true;
    }

    public function find(string $id): ?DocumentInterface
    {
        $collection = $this->database->selectCollection($this->getCollectionName());
        $row = $collection->findOne([
            DocumentManagerInterface::KEY_ID => $id
        ]);

        if (empty($row)) {
            return null;
        }



        return $this->deserializeDocument($row);
    }

    public function findAll(): array
    {
        $collection = $this->database->selectCollection($this->getCollectionName());

        $result = [];
        $cursor = $collection->find();

        foreach ($cursor as $doc) {
            $result[] = $this->deserializeDocument($doc);
        }

        return $result;
    }

    protected function deserializeDocument(array $document): DocumentInterface
    {
        if (!isset($document[DocumentManagerInterface::KEY_OBJ])) {
            throw DocumentManagerException::forNonSerializedObject($document[DocumentManagerInterface::KEY_ID]);
        }

        $serializedJson = $document[DocumentManagerInterface::KEY_OBJ];

        $documentObject = $this->serializer->deserialize($serializedJson, $this->getClassName(), 'json');

        return $documentObject;
    }
}