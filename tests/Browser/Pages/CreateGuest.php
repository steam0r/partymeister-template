<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class CreateGuest extends CreatePage
{
    const CATEGORY_TEST = '55';

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/backend/guests/create';
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
            '@categoryDropdown' => '#category_id',
            '@handleField' => '#handle',
            '@companyField' => '#company',
            '@emailField' => '#email',
            '@countryField' => '#country',
            '@ticketCodeField' => '#ticket_code',
            '@ticketTypeField'=> '#ticket_type',
            '@ticketOrderNoField' => '#ticket_order_number',
            '@commentTextarea' => '#comment',
            '@hasBadgeCheckbox' => '#has_badge',
            '@hasArrivedCheckbox' => '#has_arrived',
            '@ticketCodeScannedCheckbox' => '#ticket_code_scanned',
            '@saveGuestButton' => '#app > main > div > form > div > div.card-footer > button.competition-submit',
        ];
    }

    public function selectCategory (Browser $browser, $categoryOption) {
        $browser->select('@categoryDropdown', $categoryOption);
    }

    public function enterHandle (Browser $browser, $fieldString) {
        $browser->type('@handleField', $fieldString);
    }

    public function enterCompany (Browser $browser, $fieldString) {
        $browser->type('@companyField', $fieldString);
    }

    public function enterEmail (Browser $browser, $fieldString) {
        $browser->type('@emailField', $fieldString);
    }

    public function enterCountry (Browser $browser, $fieldString) {
        $browser->type('@countryField', $fieldString);
    }

    public function enterTicketCode (Browser $browser, $fieldString) {
        $browser->type('@ticketCodeField', $fieldString);
    }

    public function enterTicketType (Browser $browser, $fieldString) {
        $browser->type('@ticketTypeField', $fieldString);
    }

    public function enterTicketOrderNo (Browser $browser, $fieldString) {
        $browser->type('@ticketOrderNoField', $fieldString);
    }

    public function enterComment (Browser $browser, $textareaString) {
        $browser->type('@commentTextarea', $textareaString);
    }

    public function checkHasBadge (Browser $browser) {
        $browser->check('@hasBadgeCheckbox');
    }

    public function uncheckHasBadge (Browser $browser) {
        $browser->uncheck('@hasBadgeCheckbox');
    }

    public function checkHasArrived (Browser $browser) {
        $browser->check('@hasArrivedCheckbox');
    }

    public function uncheckHasArrived (Browser $browser) {
        $browser->uncheck('@hasArrivedCheckbox');
    }

    public function checkTicketCodeScanned (Browser $browser) {
        $browser->check('@ticketCodeScannedCheckbox');
    }

    public function uncheckTicketCodeScanned (Browser $browser) {
        $browser->uncheck('@ticketCodeScannedCheckbox');
    }

    public function clickSaveGuest(Browser $browser)
    {
        $browser->click('@saveGuestButton')
                ->assertPathIs('/backend/guests'); //add check that item was created
    }
}
