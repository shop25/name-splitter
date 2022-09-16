Пример использования

```php
<?php
$splitter = new \S25\NameSplitter\Splitter();
$nameHolder = $splitter->split("Иванов Иван Иванович");
var_dump($nameHolder->getFirstName(), $nameHolder->getMiddleName(), $nameHolder->getLastName());
?>
```
