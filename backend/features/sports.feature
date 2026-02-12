# language: fr
Fonctionnalité: Sports
  Scénario: Créer un sport individuel
    Donné que je suis sur "/sports"
    Quand je clique sur "+ Nouveau Sport"
    Et je remplis "Nom du sport" avec "Athlétisme"
    Et je sélectionne "Individuel"
    Et je clique sur "Enregistrer le sport"
    Alors je vois "Athlétisme" avec "Individuel" dans la table

  Scénario: Créer un sport d'équipe
    Donné que je suis sur "/sports"
    Quand je clique sur "+ Nouveau Sport"
    Et je remplis "Nom du sport" avec "Football"
    Et je sélectionne "Équipe"
    Et je clique sur "Enregistrer le sport"
    Alors je vois "Football" avec "Équipe" dans la table

  Scénario: Erreur si nom vide
    Donné que je suis sur "/sports"
    Quand je clique sur "+ Nouveau Sport"
    Et je clique sur "Enregistrer le sport"
    Alors je vois une erreur
