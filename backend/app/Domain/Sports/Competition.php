<?php

declare(strict_types=1);

namespace App\Domain\Sports;

final class Competition
{
    /** @var list<Event> */
    private array $events;

    /**
     * @param list<Event> $events
     */
    public function __construct(
        public readonly int               $id,
        public readonly int               $championshipId,
        public readonly Name              $name,
        public readonly CompetitionStatus $status = CompetitionStatus::Draft,
        array                             $events = [],
    )
    {
        $this->events = array_values($events);
    }

    /** @return list<Event> */
    public function events(): array
    {
        return $this->events;
    }

    public function canAddEvent(): bool
    {
        return $this->status !== CompetitionStatus::Closed;
    }

    public function withAddedEvent(Event $event): self
    {
        if (!$this->canAddEvent()) {
            throw CompetitionClosed::cannotAddEvent();
        }

        $clone = clone $this;
        $clone->events = [...$this->events, $event];

        return $clone;
    }
}
