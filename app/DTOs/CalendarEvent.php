<?php

namespace App\DTOs;

readonly class CalendarEvent
{
    public function __construct(
        public int $localizador,
        public string $title,
        public string $start,
        public string $end,
        public string $color,
        public array $extendedProps = [],
    ) {}

    public function toArray(): array
    {
        return [
            'localizador' => $this->localizador,
            'title' => $this->title,
            'start' => $this->start,
            'end' => $this->end,
            'color' => $this->color,
        ];
    }
}