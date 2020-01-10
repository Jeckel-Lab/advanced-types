<?php

/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 20/11/2019
 */

declare(strict_types=1);

namespace JeckelLab\AdvancedTypes\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use JeckelLab\AdvancedTypes\ValueObject\Color;

/**
 * Class ColorType
 * @package JeckelLab\AdvancedTypes\DBAL\Types
 */
class ColorType extends Type
{
    protected const COLOR_TYPE = 'color';

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
     * @return string
     */
    public function getName(): string
    {
        return self::COLOR_TYPE;
    }

    /**
     * @param mixed            $value
     * @param AbstractPlatform $platform
     * @return Color|null
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?Color
    {
        if (null === $value) {
            return null;
        }
        return Color::byHex($value);
    }

    /**
     * @param mixed            $value
     * @param AbstractPlatform $platform
     * @return string|null
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value instanceof Color) {
            return $value->getHex();
        }
        return null;
    }
}
