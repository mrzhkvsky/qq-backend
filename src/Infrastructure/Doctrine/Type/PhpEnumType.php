<?php
declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use MyCLabs\Enum\Enum;

class PhpEnumType extends Type
{
    protected string $name = 'enum';
    protected string $enumClass = Enum::class;

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): object
    {
        return new $this->enumClass($value);
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getVarcharTypeDeclarationSQL($column);
    }

    public function getName(): string
    {
        return $this->name;
    }
}
