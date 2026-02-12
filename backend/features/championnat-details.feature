# language: fr
Fonctionnalité: Détails Championnat
  Scénario: Afficher les détails d'un championnat
    Donné que le championnat "Coupe de France" existe
    Quand je navigue vers sa page de détails
    Alors je vois le titre "Coupe de France"
    Et je vois "Sport: Football"
    Et je vois "Lieu: Paris"

  Scénario: Afficher les compétitions et épreuves
    Donné que le championnat "Wimbledon" existe avec 2 compétitions
    Quand je suis sur sa page de détails
    Alors je vois 2 compétitions
    Et je vois les épreuves de chaque compétition

  Scénario: Revenir à la liste
    Donné que je suis sur la page de détails d'un championnat
    Quand je clique sur "← Retour"
    Alors je suis redirigé vers "/championnats"
