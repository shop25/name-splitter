<?php

namespace S25\NameSplitter;


class NameHolder
{
    private $firstName;
    private $middleName;
    private $lastName;

    public function __construct(string $firstName, string $middleName, string $lastName)
    {
        $this->firstName = $firstName;
        $this->middleName= $middleName;
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getMiddleName(): string
    {
        return $this->middleName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }
}
