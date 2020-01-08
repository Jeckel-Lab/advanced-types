<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 05/12/2019
 */

namespace JeckelLab\AdvancedTypes\DBAL\Types;

use JeckelLab\AdvancedTypes\ValueObject\Url;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

/**
 * Class UrlType
 * @package App\Doctrine\Type
 */
class UrlType extends Type
{
    protected const CUSTOM_TYPE = 'url';

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
        return self::CUSTOM_TYPE;
    }

    /**
     * @param mixed            $value
     * @param AbstractPlatform $platform
     * @return Url
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): Url
    {
        return new Url($value);
    }

    /**
     * @param mixed            $value
     * @param AbstractPlatform $platform
     * @return string
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        if ($value instanceof Url) {
            $value = $value->getUrl();
        }
        return $value;
    }
}
