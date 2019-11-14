<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 14/11/2019
 */

namespace JeckelLab\Types\Collection;

use ArrayAccess;
use Countable;
use IteratorAggregate;

/**
 * Interface CollectionInterface
 * @package JeckelLab\Types\Collection
 */
interface CollectionInterface extends Countable, IteratorAggregate, ArrayAccess
{
    /**
     * @return string
     */
    public function getItemClassName(): string;

    /**
     * @param int $index
     * @return mixed
     */
    public function getItem(int $index);
}
