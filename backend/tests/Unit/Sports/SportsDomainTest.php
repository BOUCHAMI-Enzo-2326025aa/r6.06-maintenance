<?php

declare(strict_types=1);

namespace Tests\Unit\Sports;

use App\Domain\Sports\Championship;
use App\Domain\Sports\Competition;
use App\Domain\Sports\CompetitionClosed;
use App\Domain\Sports\CompetitionStatus;
use App\Domain\Sports\Event;
use App\Domain\Sports\InvalidName;
use App\Domain\Sports\Name;
use App\Domain\Sports\Sport;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class SportsDomainTest extends TestCase
{
    #[Test]
    public function name_ne_peut_pas_etre_vide(): void
    {
        $this->expectException(InvalidName::class);
        new Name('   ', 'Sport');
    }

    #[Test]
    public function creer_un_sport_avec_un_nom_normalise(): void
    {
        $sport = new Sport(id: 1, name: new Name('  Triathlon  ', 'Sport'));
        $this->assertSame('Triathlon', (string)$sport->name);
    }

    #[Test]
    public function championnat_reference_un_sport(): void
    {
        $championship = new Championship(id: 10, sportId: 1, name: new Name('Triathlon', 'Championnat'));
        $this->assertSame(1, $championship->sportId);
    }

    #[Test]
    public function competition_peut_ajouter_des_epreuves_si_pas_fermee(): void
    {
        $competition = new Competition(
            id: 100,
            championshipId: 10,
            name: new Name('District', 'Compétition'),
            status: CompetitionStatus::Open,
        );

        $competition2 = $competition->withAddedEvent(new Event(id: 1, name: new Name('Nage', 'Épreuve'), order: 1));
        $competition3 = $competition2->withAddedEvent(new Event(id: 2, name: new Name('Vélo', 'Épreuve'), order: 2));

        $this->assertCount(0, $competition->events());
        $this->assertCount(1, $competition2->events());
        $this->assertCount(2, $competition3->events());
    }

    #[Test]
    public function competition_fermee_interdit_d_ajouter_une_epreuve(): void
    {
        $this->expectException(CompetitionClosed::class);

        $competition = new Competition(
            id: 100,
            championshipId: 10,
            name: new Name('District', 'Compétition'),
            status: CompetitionStatus::Closed,
        );

        $competition->withAddedEvent(new Event(id: 1, name: new Name('Course', 'Épreuve'), order: 1));
    }
}
