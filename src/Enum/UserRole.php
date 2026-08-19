<?php

namespace App\Enum;

enum UserRole: string
{
    case USER = 'ROLE_USER';
    case ADMIN = 'ROLE_ADMIN';

    public function getLabel(): string
    {
        return match($this) {
            self::USER => 'Utilisateur',
            self::ADMIN => 'Administrateur'
        };
    }

    public function getDescription(): string
    {
        return match($this) {
            self::USER => 'Utilisateur standard avec accès limité',
            self::ADMIN => 'Administrateur avec tous les droits'
        };
    }

    public static function getChoices(): array
    {
        $choices = [];
        foreach (self::cases() as $case) {
            $choices[$case->getLabel()] = $case->value;
        }
        return $choices;
    }

    public static function getDefaultRoles(): array
    {
        return [self::USER->value];
    }
}
