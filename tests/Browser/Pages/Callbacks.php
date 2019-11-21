<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class Callbacks extends GridPage
{
    const DESTINATION_ORGA = 'orga';
    const DESTINATION_NOWPLAYING = 'nowplaying';
    const DESTINATION_GENERAL = 'general';
    const DESTINATION_COMPETITIONS = 'competitions';
    const DESTINATION_SEMINARS = 'seminars';
    const DESTINATION_DEADLINES = 'deadlines';
    const DESTINATION_EVENTS = 'events';
    const DESTINATION_NIGHTSHUTTLE = 'nightshuttle';
    const DESTINATION_LOCATION = 'location';
    const DESTINATION_IOS = 'ios';
    const DESTINATION_ANDROID = 'android';
    const DESTINATION_TESTING = 'testing';

    const CREATE_BUTTON_TEXT = 'Create callback';

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/backend/callbacks';
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
            '@destinationDropdown' => '#app > main > div > div > div.card-header > form > select[name=destination]',
        ];
    }

    public function selectDestination(Browser $browser, $destinationOption)
    {
        $browser->select('@destinationDropdown', $destinationOption);
    }

    public function clickCreateCallback(Browser $browser)
    {
        $browser->clickCreateButton(self::CREATE_BUTTON_TEXT);
    }

}
