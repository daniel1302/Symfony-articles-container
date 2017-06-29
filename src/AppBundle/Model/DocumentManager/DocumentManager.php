<?php
namespace AppBundle\Model\DocumentManager;



use AppBundle\Document\DocumentInterface;
use AppBundle\Document\UserActivity;
use MongoDB\Database;
use MongoDB\Model\BSONDocument;
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

    public function update(DocumentInterface $document): bool
    {
        $collection = $this->database->selectCollection($this->getCollectionName());

        $collection->updateOne([
            DocumentManagerInterface::KEY_ID => $document->getId()
        ], [
            '$set' => $this->serializeObject($document)
        ]);

        return true;
    }

    public function insert(DocumentInterface $document): bool
    {
        if (empty($document->getId())) {
            $documentId = md5(microtime(true));

            $document->setId($documentId);
        }

        $collection = $this->database->selectCollection($this->getCollectionName());
        $collection->insertOne($this->serializeObject($document));

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

        if (!is_array($row)) {
            $row = $row->getArrayCopy();
        }

        return $this->deserializeDocument($row);
    }

    public function findAll(array $params = [], int $limit = null, int $offset = null): array
    {
        if ($limit === null) {
            $limit = PHP_INT_MAX;
        }
        if ($offset === null) {
            $offset = 0;
        }

        $collection = $this->database->selectCollection($this->getCollectionName());

        $result = [];
        $cursor = $collection->find($params);
        /** @var BSONDocument $doc */
        foreach ($cursor as $doc) {
            if (--$offset > 0) {
                continue;
            }
            if (--$limit < 0) {
                break;
            }

            $result[] = $this->deserializeDocument($doc->getArrayCopy());
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

    protected function serializeObject(DocumentInterface $document) {


        $serializedJson = $this->serializer->serialize($document, 'json');


        return [
            DocumentManagerInterface::KEY_ID    => $document->getId(),
            DocumentManagerInterface::KEY_OBJ   => $serializedJson
        ];
    }

    public function count(array $params = []): int
    {
        $collection = $this->database->selectCollection($this->getCollectionName());

        $cursor = $collection->find($params);

        $c = 0;
        foreach ($cursor as $item) {
            $c++;
        }

        return $c;
    }
}