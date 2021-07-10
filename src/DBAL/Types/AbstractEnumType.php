<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 09/06/2020
 */

declare(strict_types=1);

namespace JeckelLab\AdvancedTypes\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use JeckelLab\AdvancedTypes\Enum\EnumAbstract;

/**
 * Class AbstractEnumType
 * @package JeckelLab\AdvancedTypes\DBAL\Types
 */
abstract class AbstractEnumType extends Type
{
    abstract protected function getEnumClassName(): string;

    abstract protected function getDefaultValue(): EnumAbstract;

    /**
     * @param array            $fieldDeclaration
     * @param AbstractPlatform $platform
     * @return string
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
    }

    /**
     * @param mixed            $value
     * @param AbstractPlatform $platform
     * @return EnumAbstract
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): EnumAbstract
    {
        if (call_user_func([$this->getEnumClassName(), 'hasValue'], $value)) {
            return call_user_func([$this->getEnumClassName(), 'byValue'], $value);
        }
        return $this->getDefaultValue();
    }

    /**
     * @param mixed            $value
     * @param AbstractPlatform $platform
     * @return string
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        $enumClassName = $this->getEnumClassName();
        if ($value instanceof $enumClassName) {
            $value = $value->getValue();
        }
        return $value;
    }
}
