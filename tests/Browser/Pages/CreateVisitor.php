<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class CreateVisitor extends CreatePage
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/backend/visitors/create';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url());
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@groupField' => '#group',
            '@emailField' => '#email',
            '@countryCombobox' => '#select2-country_iso_3166_1-container',
            '@countryComboboxInput' => 'body > span > span > span.select2-search.select2-search--dropdown > input',
            '@passwordField' => '#password',
            '@saveVisitorButton' => '#app > main > div > form > div > div.card-footer > button.btn-primary',
        ];
    }

    public function enterGroup(Browser $browser, $fieldString)
    {
        $browser->type('@groupField', $fieldString);
    }

    public function enterEmail(Browser $browser, $fieldString)
    {
        $browser->type('@emailField', $fieldString);
    }

    // public function enterCountry (Browser $browser, $fieldString) {
    //     $browser->click('@countryCombobox')->type('@countryComboboxInput', $fieldString); //FIXME
    // }

    public function enterPassword(Browser $browser, $fieldString)
    {
        $browser->type('@passwordField', $fieldString); // DOESN'T WORK
    }

    public function clickSaveVisitor(Browser $browser)
    {
        $browser->click('@saveVisitorButton')
                ->assertPathIs('/backend/visitors'); //add check that item was created
    }
}
