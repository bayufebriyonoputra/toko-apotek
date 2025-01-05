<?php
namespace App\Enum;

enum RoleEnum: string
{
    case ADMIN = 'admin';
    case SELLER = 'seller';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::SELLER => 'Seller',
            default => 'Unknown'
        };
    }

    public static function toArray(): array
    {
        return array_map(fn($status) => [
            'values' => $status->value,
            'label' => $status->label()
        ], self::cases());
    }
}
