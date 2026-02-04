<?php

use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\MinkContext;

class FeatureContext extends MinkContext implements Context
{
    /**
     * @When je remplis le filtre avec :valeur
     */
    public function jeRemplisLeFiltreAvec($valeur)
    {
        // On suppose que ton champ de texte a l'ID ou le NAME "filtre"
        $this->fillField('filtre_nom', $valeur);
    }

    /**
     * @When je valide le formulaire
     */
    public function jeValideLeFormulaire()
    {
        $this->pressButton('Valider');
    }

    /**
     * @Then je devrais voir la catégorie :categorie
     */
    public function jeDevraisVoirLaCategorie($categorie)
    {
        $this->assertSession()->pageTextContains($categorie);
    }
}