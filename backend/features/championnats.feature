# language: fr
Fonctionnalité: Championnats
  Scénario: Créer un championnat avec une compétition
    Donné que je suis sur "/championnats"
    Quand je clique sur "+ Créer un Championnat"
    Et je sélectionne "Football"
    Et je remplis "Nom du Championnat" avec "Coupe de France"
    Et je remplis "Compétition #1" avec "Phase 1"
    Et je remplis "Épreuve #1" avec "Finale"
    Et je clique sur "Enregistrer le Championnat complet"
    Alors je vois "Coupe de France" dans la liste

  Scénario: Ajouter plusieurs compétitions
    Donné que je suis sur "/championnats"
    Quand je clique sur "+ Créer un Championnat"
    Et je sélectionne "Tennis"
    Et je remplis "Nom du Championnat" avec "Wimbledon"
    Et j'ajoute 2 compétitions avec épreuves
    Et je clique sur "Enregistrer le Championnat complet"
    Alors je vois "2" dans "Nb compétitions"

  Scénario: Erreur si sport non sélectionné
    Donné que je suis sur "/championnats"
    Quand je clique sur "+ Créer un Championnat"
    Et je clique sur "Enregistrer le Championnat complet"
    Alors je vois une erreur "Choisis un sport"
