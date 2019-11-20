<?php
declare(strict_types=1);
/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 18/11/2019
 */

namespace JeckelLab\Types\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use JeckelLab\Types\ValueObject\TimeDuration;

/**
 * Class TimeDurationType
 * @package App\Doctrine\Type
 */
class TimeDurationType extends Type
{
    protected const TIME_DURATION_TYPE = 'time_duration_type';

    /**
     * @param array            $fieldDeclaration
     * @param AbstractPlatform $platform
     * @return string
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return $platform->getIntegerTypeDeclarationSQL($fieldDeclaration);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::TIME_DURATION_TYPE;
    }

    /**
     * @param mixed            $value
     * @param AbstractPlatform $platform
     * @return TimeDuration
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): TimeDuration
    {
        return new TimeDuration((int) $value);
    }

    /**
     * @param mixed            $value
     * @param AbstractPlatform $platform
     * @return int|null
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?int
    {
        if ($value instanceof TimeDuration) {
            return $value->getValue();
        }
        return null;
    }
}
