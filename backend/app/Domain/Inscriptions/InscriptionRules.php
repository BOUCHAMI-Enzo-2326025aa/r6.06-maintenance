<?php

declare(strict_types=1);

namespace App\Domain\Inscriptions;

// Ajout d'imports explicites pour les exceptions du domaine.
use App\Domain\Inscriptions\DomainException;
use App\Domain\Inscriptions\InscriptionDenied;

final class InscriptionRules
{
    /**
     * @param int $alreadyRegisteredEventsCount Nombre d'épreuves déjà enregistrées pour ce licencié dans cette compétition.
     */
    public function assertIndividualAllowed(
        Competition $competition,
        Licence $licence,
        Event $event,
        int $alreadyRegisteredEventsCount,
    ): void {
        if (! $competition->isOpen()) {
            throw InscriptionDenied::competitionClosed();
        }

        if (! $licence->validated) {
            throw InscriptionDenied::licenceNotValidated();
        }

        if ($alreadyRegisteredEventsCount >= $competition->maxEventsPerAthlete) {
            throw InscriptionDenied::maxEventsReached($competition->maxEventsPerAthlete);
        }

        if ($event->compatibleCategory !== $licence->category) {
            throw InscriptionDenied::categoryIncompatible();
        }
    }

    /**
     * @param list<Licence> $members
     */
    public function assertRelayAllowed(
        Competition $competition,
        Event $event,
        array $members,
    ): void {
        if (! $competition->isOpen()) {
            throw InscriptionDenied::competitionClosed();
        }

        if (! $event->isTeam()) {
            throw new DomainException("Cette épreuve n'est pas un relais/équipe.");
        }

        $count = count($members);
        if ($count < $event->minTeamSize || $count > $event->maxTeamSize) {
            throw InscriptionDenied::teamSizeInvalid($event->minTeamSize, $event->maxTeamSize);
        }

        $seen = [];
        foreach ($members as $member) {
            if (! $member->validated) {
                throw InscriptionDenied::licenceNotValidated();
            }

            if ($member->category !== $event->compatibleCategory) {
                throw InscriptionDenied::categoryIncompatible();
            }

            if (isset($seen[$member->number])) {
                throw InscriptionDenied::duplicateMember();
            }
            $seen[$member->number] = true;
        }
    }
}
