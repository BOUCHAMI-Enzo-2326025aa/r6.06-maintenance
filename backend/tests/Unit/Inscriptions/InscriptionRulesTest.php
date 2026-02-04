<?php

declare(strict_types=1);

namespace Tests\Unit\Inscriptions;

use App\Domain\Inscriptions\Competition;
use App\Domain\Inscriptions\CompetitionStatus;
use App\Domain\Inscriptions\Event;
use App\Domain\Inscriptions\InscriptionDenied;
use App\Domain\Inscriptions\InscriptionRules;
use App\Domain\Inscriptions\InscriptionType;
use App\Domain\Inscriptions\Licence;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

final class InscriptionRulesTest extends TestCase
{
    #[Test]
    public function inscription_individuelle_autorisee_si_competition_ouverte(): void
    {
        $rules = new InscriptionRules();
        $competition = new Competition(id: 1, status: CompetitionStatus::Open, maxEventsPerAthlete: 2);
        $licence = new Licence(number: 123, validated: true, category: 'M');
        $event = new Event(id: 10, compatibleCategory: 'M', type: InscriptionType::Individuel);

        $rules->assertIndividualAllowed($competition, $licence, $event, alreadyRegisteredEventsCount: 0);

        $this->assertTrue(true);
    }

    #[Test]
    public function refus_si_competition_fermee_individuel(): void
    {
        $this->expectException(InscriptionDenied::class);
        $this->expectExceptionMessage('compétition fermée');

        $rules = new InscriptionRules();
        $competition = new Competition(id: 1, status: CompetitionStatus::Closed, maxEventsPerAthlete: 2);
        $licence = new Licence(number: 123, validated: true, category: 'M');
        $event = new Event(id: 10, compatibleCategory: 'M', type: InscriptionType::Individuel);

        $rules->assertIndividualAllowed($competition, $licence, $event, alreadyRegisteredEventsCount: 0);
    }

    #[Test]
    public function refus_si_licencie_non_valide_individuel(): void
    {
        $this->expectException(InscriptionDenied::class);
        $this->expectExceptionMessage('licencié non validé');

        $rules = new InscriptionRules();
        $competition = new Competition(id: 1, status: CompetitionStatus::Open, maxEventsPerAthlete: 2);
        $licence = new Licence(number: 123, validated: false, category: 'M');
        $event = new Event(id: 10, compatibleCategory: 'M', type: InscriptionType::Individuel);

        $rules->assertIndividualAllowed($competition, $licence, $event, alreadyRegisteredEventsCount: 0);
    }

    #[Test]
    public function respect_du_max_d_epreuves(): void
    {
        $this->expectException(InscriptionDenied::class);
        $this->expectExceptionMessage("maximum d'épreuves atteint");

        $rules = new InscriptionRules();
        $competition = new Competition(id: 1, status: CompetitionStatus::Open, maxEventsPerAthlete: 2);
        $licence = new Licence(number: 123, validated: true, category: 'M');
        $event = new Event(id: 10, compatibleCategory: 'M', type: InscriptionType::Individuel);

        $rules->assertIndividualAllowed($competition, $licence, $event, alreadyRegisteredEventsCount: 2);
    }

    #[Test]
    public function categorie_compatible_avec_epreuve_individuel(): void
    {
        $this->expectException(InscriptionDenied::class);
        $this->expectExceptionMessage('catégorie incompatible');

        $rules = new InscriptionRules();
        $competition = new Competition(id: 1, status: CompetitionStatus::Open, maxEventsPerAthlete: 2);
        $licence = new Licence(number: 123, validated: true, category: 'F');
        $event = new Event(id: 10, compatibleCategory: 'M', type: InscriptionType::Individuel);

        $rules->assertIndividualAllowed($competition, $licence, $event, alreadyRegisteredEventsCount: 0);
    }

    #[Test]
    public function relais_nombre_de_membres_valide(): void
    {
        $rules = new InscriptionRules();
        $competition = new Competition(id: 1, status: CompetitionStatus::Open, maxEventsPerAthlete: 2);
        $event = new Event(id: 99, compatibleCategory: 'M', type: InscriptionType::Relais, minTeamSize: 4, maxTeamSize: 4);

        $members = [
            new Licence(number: 1, validated: true, category: 'M'),
            new Licence(number: 2, validated: true, category: 'M'),
            new Licence(number: 3, validated: true, category: 'M'),
            new Licence(number: 4, validated: true, category: 'M'),
        ];

        $rules->assertRelayAllowed($competition, $event, $members);
        $this->assertTrue(true);
    }

    #[Test]
    public function relais_refus_si_nombre_membres_invalide(): void
    {
        $this->expectException(InscriptionDenied::class);
        $this->expectExceptionMessage('nombre de membres invalide');

        $rules = new InscriptionRules();
        $competition = new Competition(id: 1, status: CompetitionStatus::Open, maxEventsPerAthlete: 2);
        $event = new Event(id: 99, compatibleCategory: 'M', type: InscriptionType::Relais, minTeamSize: 4, maxTeamSize: 4);

        $members = [
            new Licence(number: 1, validated: true, category: 'M'),
            new Licence(number: 2, validated: true, category: 'M'),
            new Licence(number: 3, validated: true, category: 'M'),
        ];

        $rules->assertRelayAllowed($competition, $event, $members);
    }

    #[Test]
    public function relais_pas_de_doublon(): void
    {
        $this->expectException(InscriptionDenied::class);
        $this->expectExceptionMessage('doublon');

        $rules = new InscriptionRules();
        $competition = new Competition(id: 1, status: CompetitionStatus::Open, maxEventsPerAthlete: 2);
        $event = new Event(id: 99, compatibleCategory: 'M', type: InscriptionType::Relais, minTeamSize: 2, maxTeamSize: 4);

        $members = [
            new Licence(number: 1, validated: true, category: 'M'),
            new Licence(number: 1, validated: true, category: 'M'),
        ];

        $rules->assertRelayAllowed($competition, $event, $members);
    }

    #[Test]
    public function relais_categorie_compatible(): void
    {
        $this->expectException(InscriptionDenied::class);
        $this->expectExceptionMessage('catégorie incompatible');

        $rules = new InscriptionRules();
        $competition = new Competition(id: 1, status: CompetitionStatus::Open, maxEventsPerAthlete: 2);
        $event = new Event(id: 99, compatibleCategory: 'M', type: InscriptionType::Relais, minTeamSize: 2, maxTeamSize: 4);

        $members = [
            new Licence(number: 1, validated: true, category: 'F'),
            new Licence(number: 2, validated: true, category: 'M'),
        ];

        $rules->assertRelayAllowed($competition, $event, $members);
    }

    #[Test]
    public function relais_inscription_bloquee_si_competition_fermee(): void
    {
        $this->expectException(InscriptionDenied::class);
        $this->expectExceptionMessage('compétition fermée');

        $rules = new InscriptionRules();
        $competition = new Competition(id: 1, status: CompetitionStatus::Closed, maxEventsPerAthlete: 2);
        $event = new Event(id: 99, compatibleCategory: 'M', type: InscriptionType::Relais, minTeamSize: 2, maxTeamSize: 4);

        $members = [
            new Licence(number: 1, validated: true, category: 'M'),
            new Licence(number: 2, validated: true, category: 'M'),
        ];

        $rules->assertRelayAllowed($competition, $event, $members);
    }

    #[Test]
    public function individuel_autorise_si_deja_inscrit_a_max_moins_un(): void
    {
        $rules = new InscriptionRules();
        $competition = new Competition(id: 1, status: CompetitionStatus::Open, maxEventsPerAthlete: 2);
        $licence = new Licence(number: 123, validated: true, category: 'M');
        $event = new Event(id: 10, compatibleCategory: 'M', type: InscriptionType::Individuel);

        // frontière : max-1 => autorisé
        $rules->assertIndividualAllowed($competition, $licence, $event, alreadyRegisteredEventsCount: 1);

        $this->assertTrue(true);
    }

    #[Test]
    public function relais_refus_si_un_membre_n_est_pas_valide(): void
    {
        $this->expectException(InscriptionDenied::class);
        $this->expectExceptionMessage('licencié non validé');

        $rules = new InscriptionRules();
        $competition = new Competition(id: 1, status: CompetitionStatus::Open, maxEventsPerAthlete: 2);
        $event = new Event(id: 99, compatibleCategory: 'M', type: InscriptionType::Relais, minTeamSize: 2, maxTeamSize: 4);

        $members = [
            new Licence(number: 1, validated: true, category: 'M'),
            new Licence(number: 2, validated: false, category: 'M'),
        ];

        $rules->assertRelayAllowed($competition, $event, $members);
    }

    #[Test]
    public function relais_refus_si_epreuve_pas_de_type_relais(): void
    {
        $this->expectException(\App\Domain\Inscriptions\DomainException::class);
        $this->expectExceptionMessage("n'est pas un relais/équipe");

        $rules = new InscriptionRules();
        $competition = new Competition(id: 1, status: CompetitionStatus::Open, maxEventsPerAthlete: 2);
        $event = new Event(id: 10, compatibleCategory: 'M', type: InscriptionType::Individuel);

        $members = [
            new Licence(number: 1, validated: true, category: 'M'),
            new Licence(number: 2, validated: true, category: 'M'),
        ];

        $rules->assertRelayAllowed($competition, $event, $members);
    }
}
