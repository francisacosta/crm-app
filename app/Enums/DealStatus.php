<?php

namespace App\Enums;

enum DealStatus: string
{
    case Prospecting = 'prospecting';
    case Qualification = 'qualification';
    case Negotiation = 'negotiation';
    case Won = 'won';
    case Lost = 'lost';


    /**
     * Get all string values for random selection or mapping.
     *
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_map(fn (DealStatus $c) => $c->value, self::cases());
    }

    /**
     * Return an associative array suitable for form select options.
     * Keys are the enum values and values are human-friendly labels.
     *
     * @return array<string, string>
     */
    public static function asSelect(): array
    {
        $cases = self::cases();

        return array_combine(
            array_map(fn (DealStatus $c) => $c->value, $cases),
            array_map(fn (DealStatus $c) => $c->name, $cases)
        );
    }
}
