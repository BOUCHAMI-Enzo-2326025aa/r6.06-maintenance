<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Driver\GoutteDriver;
use Behat\Mink\Session;
use Goutte\Client;

class FeatureContext implements Context
{
    private Session $session;

    public function __construct()
    {
        $this->session = new Session(new GoutteDriver(new Client()));
    }

    /**
     * @Given que je suis sur :url
     */
    public function queJeSuisSur($url)
    {
        $this->session->visit('http://localhost:5173' . $url);
    }

    /**
     * @When je clique sur :button
     */
    public function jeCliqueSur($button)
    {
        $this->session->getPage()->clickLink($button);
    }

    /**
     * @When je remplis :field avec :value
     */
    public function jeRemplis($field, $value)
    {
        $this->session->getPage()->fillField($field, $value);
    }

    /**
     * @When je sélectionne :value
     */
    public function jeSelectionne($value)
    {
        $this->session->getPage()->selectFieldOption('Type de sport', $value);
    }

    /**
     * @Then je vois :text dans la table
     */
    public function jeVoisDansLaTable($text)
    {
        $this->session->getPage()->hasContent($text);
    }

    /**
     * @Then je vois :text avec :text2 dans la table
     */
    public function jeVoisAvecDansLaTable($text, $text2)
    {
        $this->session->getPage()->hasContent($text);
        $this->session->getPage()->hasContent($text2);
    }

    /**
     * @Then je vois une erreur
     */
    public function jeVoisUneErreur()
    {
        $this->session->getPage()->hasContent('Erreur');
    }

    /**
     * @Then je vois une erreur :error
     */
    public function jeVoisUneErreurMessage($error)
    {
        $this->session->getPage()->hasContent($error);
    }

    /**
     * @Then je suis redirigé vers :url
     */
    public function jeSuisRedirigeVers($url)
    {
        $this->session->visit('http://localhost:5173' . $url);
    }
}