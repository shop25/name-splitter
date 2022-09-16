<?php


use PHPUnit\Framework\TestCase;

class SplitterTest extends TestCase
{
    private $splitter;

    public function setUp(): void
    {
        $this->splitter = new \S25\NameSplitter\Splitter();
    }

    public function namesProvider()
    {
        return [
            ["Иванов Иван Иванович", new S25\NameSplitter\NameHolder("Иван", "Иванович", "Иванов")],
            ["Петр Петрович Петров", new S25\NameSplitter\NameHolder("Петр", "Петрович", "Петров")],
            ["Анна Андреевна Ахматова", new S25\NameSplitter\NameHolder("Анна", "Андреевна", "Ахматова")],
            ["Александр Сергеевич Пушкин", new S25\NameSplitter\NameHolder("Александр", "Сергеевич", "Пушкин")],
            ["Иванов Иван", new S25\NameSplitter\NameHolder("Иван", "", "Иванов")],
            ["Петр Петров", new S25\NameSplitter\NameHolder("Петр", "", "Петров")],
            ["Петров", new S25\NameSplitter\NameHolder("", "", "Петров")],
            ["Петр", new S25\NameSplitter\NameHolder("Петр", "", "")],
        ];
    }

    /** @dataProvider namesProvider */
    public function testSplit($name, $expected)
    {
        $this->assertEquals($expected, $this->splitter->split($name));
    }
}
