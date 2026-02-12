<?php

declare(strict_types=1);

namespace App\Domain\Inscriptions;

/**
 * Règles d'inscription (domaine).
 *
 * Ce service ne persiste rien et ne fait pas d'I/O.
 * Il valide uniquement si une inscription est autorisée, sinon lève une exception métier.
 */
final class InscriptionRules
{
    /**
     * Valide une inscription individuelle.
     *
     * @param int $alreadyRegisteredEventsCount Nombre d'épreuves déjà enregistrées pour ce licencié dans cette compétition.
     *
     * @throws InscriptionDenied Si une règle métier bloque l'inscription.
     * @throws DomainException   Si incohérence d'usage (ex: tenter une inscription individuelle sur une épreuve relais/équipe).
     */
    public function assertIndividualAllowed(
        Competition $competition,
        Licence     $licence,
        Event       $event,
        int         $alreadyRegisteredEventsCount,
    ): void
    {
        if (!$competition->isOpen()) {
            throw InscriptionDenied::competitionClosed();
        }

        if ($event->isTeam()) {
            throw new DomainException("Cette épreuve n'est pas une épreuve individuelle.");
        }

        if (!$licence->validated) {
            throw InscriptionDenied::licenceNotValidated();
        }

        if (trim($licence->category) === '') {
            throw InscriptionDenied::licenceCategoryMissing();
        }

        if ($alreadyRegisteredEventsCount >= $competition->maxEventsPerAthlete) {
            throw InscriptionDenied::maxEventsReached($competition->maxEventsPerAthlete);
        }

        if ($event->compatibleCategory !== $licence->category) {
            throw InscriptionDenied::categoryIncompatible();
        }
    }

    /**
     * Valide une inscription relais/équipe.
     *
     * @param list<Licence> $members Membres de l'équipe (licences), sans doublon, validés et compatibles avec la catégorie de l'épreuve.
     *
     * @throws InscriptionDenied Si une règle métier bloque l'inscription.
     * @throws DomainException   Si incohérence d'usage (ex: appeler relais sur une épreuve individuelle).
     */
    public function assertRelayAllowed(
        Competition $competition,
        Event       $event,
        array       $members,
    ): void
    {
        if (!$competition->isOpen()) {
            throw InscriptionDenied::competitionClosed();
        }

        if (!$event->isTeam()) {
            throw new DomainException("Cette épreuve n'est pas un relais/équipe.");
        }

        $count = count($members);
        if ($count < $event->minTeamSize || $count > $event->maxTeamSize) {
            throw InscriptionDenied::teamSizeInvalid($event->minTeamSize, $event->maxTeamSize);
        }

        $seen = [];
        foreach ($members as $member) {
            if (!$member->validated) {
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
