# language: fr
Fonctionnalité: Inscriptions
  Scénario: Vérification du calcul de catégorie automatique
    Étant donné que je suis sur la page d'inscription
    Quand je remplis "Nom" avec "DUVAL"
    Et que je remplis "Date de naissance" avec "2012-05-15"
    Et que je clique sur "Valider"
    Alors je devrais voir "DUVAL"
    Et je devrais voir "Benjamin"