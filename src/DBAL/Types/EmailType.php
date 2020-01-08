<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 05/12/2019
 */

namespace JeckelLab\AdvancedTypes\DBAL\Types;

use JeckelLab\AdvancedTypes\ValueObject\Email;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

/**
 * Class UrlType
 * @package App\Doctrine\Type
 */
class EmailType extends Type
{
    protected const CUSTOM_TYPE = 'email';

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
     * @return Email
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): Email
    {
        return new Email($value);
    }

    /**
     * @param mixed            $value
     * @param AbstractPlatform $platform
     * @return string|null
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value instanceof Email) {
            return $value->getEmail();
        }
        return null;
    }
}
