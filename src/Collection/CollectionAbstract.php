<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 14/11/2019
 */

namespace JeckelLab\Types\Collection;

use JeckelLab\Types\Collection\Exception\InvalidTypeException;
use JeckelLab\Types\Collection\Exception\OutOfRangeException;
use ArrayIterator;

/**
 * Class CollectionAbstract
 * @package JeckelLab\Types\Collection
 */
abstract class CollectionAbstract implements CollectionInterface
{
    // Based on http://aheimlich.dreamhosters.com/generic-collections/Collection.phps

    /**
     * @var string
     */
    protected $itemClassName;

    /**
     * @var array
     */
    protected $items = [];

    /**
     * Creates a new typed collection.
     * @param string $itemClassName string representing the class name of the valid type for the items.
     * @param array $items array with all the objects to be added. They must be of the class $itemClassName.
     * @throws InvalidTypeException
     */
    public function __construct(string $itemClassName, array $items = [])
    {
        $this->itemClassName = $itemClassName;
        foreach ($items as $item) {
            if (! $item instanceof $itemClassName) {
                throw new InvalidTypeException(sprintf(
                    'Invalid type, expected %s but got %s',
                    $itemClassName,
                    get_class($item)
                ));
            }
            $this->items[] = $item;
        }
    }

    /**
     * @return string
     */
    public function getItemClassName(): string
    {
        return $this->itemClassName;
    }

    /**
     * @param int $index
     * @return mixed
     */
    public function getItem(int $index)
    {
        if (! $this->indexExists($index)) {
            throw new OutOfRangeException('Index: ' . $index);
        }
        return $this->items[$index];
    }

    /**
     * @param int|null $index
     * @param          $item
     */
    public function setItem(?int $index, $item): void
    {
        if (! $item instanceof $this->itemClassName) {
            throw new InvalidTypeException(sprintf(
                'Invalid type, expected %s but got %s',
                $this->itemClassName,
                get_class($item)
            ));
        }
        if (null === $index) {
            $this->items[] = $item;
            return;
        }
        $this->items[$index] = $item;
    }

    /**
     * @param int $index
     */
    public function unsetItem(int $index): void
    {
        if (! $this->indexExists($index)) {
            throw new OutOfRangeException('Index: ' . $index);
        }

        unset($this->items[$index]);
    }

    /**
     * @param int $index
     * @return bool
     */
    public function indexExists(int $index): bool
    {
        return isset($this->items[$index]);
    }

    //---------------------------------------------------------------------//
    // Implementations                                                     //
    //---------------------------------------------------------------------//

    /**
     * Returns the count of items in the collection.
     * Implements countable.
     * @return integer
     */
    public function count() : int
    {
        return count($this->items);
    }

    /**
     * Returns an iterator
     * Implements IteratorAggregate
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value): void
    {
        $this->setItem($offset, $value);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset): void
    {
        $this->unsetItem($offset);
    }

    /**
     * get an offset's value
     * Implements ArrayAccess
     * @see get
     * @param integer $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->getItem($offset);
    }

    /**
     * Determine if offset exists
     * Implements ArrayAccess
     * @see exists
     * @param integer $offset
     * @return boolean
     */
    public function offsetExists($offset) : bool
    {
        return $this->indexExists($offset);
    }
}
