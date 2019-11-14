[![CircleCI](https://circleci.com/gh/Jeckel-Lab/advanced-types.svg?style=svg)](https://circleci.com/gh/Jeckel-Lab/advanced-types)

# Advanced PHP Types

- **Enum** (based on [marc-mabe/php-enum](https://github.com/marc-mabe/php-enum))
- **Collection**

# Installation

```bash
composer require jeckel-lab/advanced-types
```

# Types

## Enum

See documentation of [marc-mabe/php-enum](https://github.com/marc-mabe/php-enum).

> The only addition is the implementation of `JsonSerializable` interface to serialize enum as it's value.

## Collection

Just extend the `CollectionAbstract` class, and override the constructor like the example bellow.

```php
<?php
use JeckelLab\Types\Collection\CollectionAbstract;

class Clients extends CollectionAbstract
{
    /**
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        parent::__construct(Client::class, $items);
    }

    /**
     * @param int $index
     * @return Client
     */
    public function getItem(int $index): Client
    {
        return parent::getItem($index);
    }
}
```
