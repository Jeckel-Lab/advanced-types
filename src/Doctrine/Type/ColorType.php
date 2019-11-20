<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 20/11/2019
 */

namespace JeckelLab\Types\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use JeckelLab\Types\ValueObject\Color;

/**
 * Class ColorType
 * @package JeckelLab\Types\Doctrine\Type
 */
class ColorType extends Type
{
    protected const COLOR_TYPE = 'color_type';

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
     * @return Color
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): Color
    {
        return Color::byHex($value);
    }

    /**
     * @param mixed            $value
     * @param AbstractPlatform $platform
     * @return int|null
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?int
    {
        if ($value instanceof Color) {
            return $value->getValue();
        }
        return null;
    }
}
