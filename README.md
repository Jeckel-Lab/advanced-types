[![CircleCI](https://circleci.com/gh/Jeckel-Lab/advanced-types.svg?style=svg)](https://circleci.com/gh/Jeckel-Lab/advanced-types) [![Latest Stable Version](https://poser.pugx.org/jeckel-lab/advanced-types/v/stable)](https://packagist.org/packages/jeckel-lab/advanced-types) [![Total Downloads](https://poser.pugx.org/jeckel-lab/advanced-types/downloads)](https://packagist.org/packages/jeckel-lab/advanced-types)

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
use JeckelLab\AdvancedTypes\Collection\CollectionAbstract;

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


# Value Object

## Usage with doctrine

Configure type DBAL:

```yaml
# config/packages/doctrine.yaml

doctrine:
    dbal:
        types:
            color: JeckelLab\AdvancedTypes\DBAL\Types\ColorType
            email: JeckelLab\AdvancedTypes\DBAL\Types\EmailType
            time_duration: JeckelLab\AdvancedTypes\DBAL\Type\sTimeDurationType
            url: JeckelLab\AdvancedTypes\DBAL\Types\UrlType
```

Use it in your entity:

```php
<?php

use Doctrine\ORM\Mapping as ORM;
use JeckelLab\Types\ValueObject\TimeDuration;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TimeEntryRepository")
 */
class TimeEntry
{
    // ...

    /**
     * @ORM\Column(type="time_duration", nullable=true)
     * @var TimeDuration|null
     */
    private $duration;

    // ...
}
```
