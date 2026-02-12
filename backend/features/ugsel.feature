# language: fr
Fonctionnalité: Gestion des compétitions UGSEL Web

  Scénario: 1. Connexion à l'interface (Page 1 de la doc)
    Étant donné que je suis sur "/login"
    Quand je remplis "email" avec "prof@stjo.fr"
    Et que je remplis "password" avec "secret123"
    Et que je clique sur "Connexion"
    Alors je devrais être sur "/accueil"

  Scénario: 2. Sélection d'une compétition (Page 3 de la doc)
    Étant donné que je suis sur "/competitions"
    Quand je clique sur "Cross Départemental"
    Alors je devrais voir "Liste des inscrits"

  Scénario: 3. Inscription individuelle et calcul catégorie (Page 4)
    Étant donné que je suis sur la page d'inscription
    Quand je remplis "nom" avec "MARTIN"
    Et que je remplis "prenom" avec "Lucas"
    Et que je remplis "date_naissance" avec "2012-05-10"
    Et que je clique sur "Valider"
    Alors je devrais voir "MARTIN Lucas"
    Et je devrais voir "Benjamin" 

  Scénario: 4. Suppression d'une inscription (Page 6)
    Étant donné que l'élève "MARTIN Lucas" est inscrit
    Quand je clique sur "Supprimer" dans la ligne de "MARTIN Lucas"
    Alors je ne devrais plus voir "MARTIN Lucas"

  Scénario: 5. Inscription d'un Relais-Equipe (Page 7)
    Étant donné que je suis sur l'onglet "Relais-Equipes"
    Quand je remplis "Nom de l'équipe" avec "St-Jo Team 1"
    Et que je clique sur "Ajouter l'équipe"
    Alors je devrais voir "Equipe créée avec succès"

  Scénario: 6. Filtrage des licenciés (Page 13)
    Étant donné que je suis sur la liste des sportifs
    Quand je remplis le champ de filtre "nom" avec "FLO%"
    Et que je clique sur "Valider"
    Alors je devrais voir "FLORENT"
    Mais je ne devrais pas voir "DUPONT"