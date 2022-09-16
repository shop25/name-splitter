<?php

namespace S25\NameSplitter;

class Splitter
{
    private const TABLE_NAMES = 'names';
    private const TABLE_SURNAMES = 'surnames';

    private $connection;

    public function __construct()
    {
        $this->connection = new \SQLite3(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'names.sqlite');
    }

    public function split(string $fullname): NameHolder
    {
        $namesRows = $this->findNamesLike($fullname, self::TABLE_NAMES);
        $surnamesRows = $this->findNamesLike($fullname, self::TABLE_SURNAMES);

        $name = $this->getTopResult($namesRows);
        $surname = $this->getTopResult($surnamesRows);

        $middlename = $this->getMiddleName($fullname, $name, $surname);

        return new NameHolder($name, $middlename, $surname);
    }

    private function getMiddleName(string $fullname, string $name, string $surname): string
    {
        $middlename = $fullname;

        foreach ([$name, $surname] as $part) {
            if ($part !== '') {
                $middlename = preg_replace("#{$part}($|\s)#", "", trim($middlename));
            }
        }


        return trim($middlename);
    }

    private function getTopResult($rows): string
    {
        $names = [];

        while ($row = $rows->fetchArray()) {
            $names[$row['freq']] = $row['name'];
        }

        rsort($names);

        return end($names) ?? '';
    }

    private function findNamesLike(string $fullname, string $tableName)
    {
        return $this->connection->query(
            sprintf('SELECT * FROM %s WHERE name in (%s);', $tableName, \SQLite3::escapeString($this->fullnameToParams($fullname)))
        );
    }

    private function fullnameToParams(string $fullname): string
    {
        $params = [];

        $parts = explode(' ',  trim($fullname));

        foreach ($parts as $part) {
            $params[] = sprintf('"%s"', $part);
        }

        return implode(', ', $params);
    }
}
