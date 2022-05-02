<?php

namespace App\Enums;

enum Cities: string {
    case NEW_YORK = 'New York';
    case LONDON = 'London';
    case PARIS = 'Paris';
    case BERLIN = 'Berlin';
    case TOKYO = 'Tokyo';

    public function getValue(): string {
        return $this->value;
    }

    static public function getAll(): array {
        return array_map(fn(Cities $city) => $city->getValue(), Cities::cases());
    }
}