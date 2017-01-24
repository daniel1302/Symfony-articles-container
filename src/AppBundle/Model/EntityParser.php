<?php
namespace AppBundle\Model;

class EntityParser {
    const   SORT_ASC    = 1,
        SORT_DESC   = 2;

    public static function makeColumnAsRowKey($propertyName, array $data) {
        $result = [];

        $propertyName = ucfirst($propertyName);
        foreach ($data as $entity) {
            if (!method_exists($entity, 'get'.$propertyName)) {
                continue;
            }
            $propertyValue = $entity->{'get'.$propertyName}();
            $result[$propertyValue] = $entity;
        }

        return $result;
    }

    public static function assingToCategories($propertyName, array $data) {
        $result = [];

        $propertyName = ucfirst($propertyName);
        foreach ($data as $entity) {
            if (!method_exists($entity, 'get'.$propertyName)) {
                continue;
            }
            $propertyValue = $entity->{'get'.$propertyName}();

            if (!isset($result[$propertyValue])) {
                $result[$propertyValue] = [];
            }

            $result[$propertyValue][] = $entity;
        }

        return $result;
    }

    public static function getColumnValues($propertyName, array $data) {
        $result = [];
        $propertyName = ucfirst($propertyName);

        foreach ($data as $entity) {
            if (!method_exists($entity, 'get'.$propertyName)) {
                continue;
            }
            $result[] = $entity->{'get'.$propertyName}();
        }

        return $result;
    }

    public static function filter($propertyName, $expectedValue, array $data) {
        $result = [];
        $propertyName = ucfirst($propertyName);

        foreach ($data as $entity) {
            if (!method_exists($entity, 'get'.$propertyName)) {
                continue;
            }

            $propertyValue = $entity->{'get'.$propertyName}();
            if ($propertyValue == $expectedValue) {
                $result[] = $entity;
            }
        }

        return $result;
    }

    public static function sort($propertyName, array $data, $sortType=self::SORT_ASC) {
        $result = [];
        $usedKeys = [];

        $propertyName = ucfirst($propertyName);
        $dataLength = count($data);
        while (count($usedKeys) < $dataLength) {
            $selectedKey = null;
            foreach ($data as $key => $entity) {
                if (!method_exists($entity, 'get'.$propertyName) || in_array($key, $usedKeys)) {
                    continue;
                }

                $currentValue = $entity->{'get'.$propertyName}();
                if ($selectedKey === null) {
                    $selectedKey = $key;
                }

                if ($sortType === self::SORT_DESC) {
                    if ($data[$selectedKey]->{'get'.$propertyName}() < $currentValue) {
                        $selectedKey = $key;
                    }
                } else {
                    if ($data[$selectedKey]->{'get'.$propertyName}() > $currentValue) {
                        $selectedKey = $key;
                    }
                }
            }

            $usedKeys[] = $selectedKey;
            $result[] = $data[$selectedKey];
        }

        return $result;
    }

    public static function sortManual($propertyName, array $data, array $order) {
        $result = [];
        $propertyName = ucfirst($propertyName);
        $usedKeys = [];

        foreach ($order as $expectedValue) {
            foreach ($data as $key => $entity) {
                if (!method_exists($entity, 'get'.$propertyName) || in_array($key, $usedKeys)) {
                    continue;
                }

                $currentValue = $entity->{'get'.$propertyName}();
                if ($currentValue == $expectedValue) {
                    $userKeys[] = $key;
                    $result[] = $entity;
                    continue;
                }
            }
        }

        return $result;
    }

    /**
     * Przygotowuje dane do wykresów słupkowych, format danych:
     * [ 'data' =>
     *      [
     *          ['label' => 'Etykieta', 'value' => 'Wartość', 'percent' => 'wysokośc słupka w procentach'],
     *          ...
     *          ...
     *          ...
     *          ['label' => 'Etykieta', 'value' => 'Wartość', 'percent' => 'wysokośc słupka w procentach']
     *      ],
     *  'params' =>
     *      [
     *          'max' => 'Wartość maxymalna',
     *          'avg' => 'Wartość średnia',
     *          'min' => 'Wartośc minimalna',
     *          'sum' => 'Suma'
     *      ]
     * ]
     *
     * @param array $data
     * @param array $labels
     * @param string $propertyKey
     * @param string $propertyValue
     * @param array $option
     *
     * @return array
     */
    public static function prepareBarChardData(array $data, array $labels, $propertyKey, $propertyValue, array $options = []) {
        $propertyValue = ucfirst($propertyValue);
        $propertyKey = ucfirst($propertyKey);
        $values = [];
        $i = 0;
        foreach ($data as $dataEntity) {
            if (!method_exists($dataEntity, 'get'.$propertyValue) || !method_exists($dataEntity, 'get'.$propertyKey)) {
                continue;
            }
            $key    = $dataEntity->{'get'.$propertyKey}();
            $value  = (int)$dataEntity->{'get'.$propertyValue}();

            $label = (isset($labels[$key]) ? $labels[$key] : $i++);
            $values[$label] = $value;
        }

        $result['params'] = [
            'max'   => (isset($options['max']) ? (int)$options['max'] : max($values)),
            'min'   => (isset($options['min']) ? (int)$options['min'] : min($values)),
            'avg'   => (isset($options['avg']) ? (int)$options['avg'] : Statistic::avg($values)),
            'sum'   => (isset($options['sum']) ? (int)$options['sum'] : array_sum($values))
        ];

        $result['data'] = [];
        foreach ($values as $key => $value) {
            $result['data'][] = [
                'label'     => $key,
                'value'     => $value,
                'percent'   => $value/$result['params']['max']*100
            ];
        }

        return $result;
    }

    public static function sum($proprtyName, array $data) {
        $proprtyName = ucfirst($proprtyName);

        $sum = 0;
        foreach ($data as $dataEntity) {
            if (!method_exists($dataEntity, 'get' . $proprtyName)) {
                continue;
            }

            $sum += (float) $dataEntity->{'get'.$proprtyName}();
        }

        return $sum;
    }
}

