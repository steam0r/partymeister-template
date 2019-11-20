<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class Events extends GridPage
{
    const EVENT_TYPE_COMPETITION = '1';
    const EVENT_TYPE_DEADLINE = '2';
    const EVENT_TYPE_EVENT = '3';
    const EVENT_TYPE_DEMOSHOW = '4';
    const EVENT_TYPE_LIVEACT = '5';
    const EVENT_TYPE_FOOD_DEADLINE = '6';
    const EVENT_TYPE_SEMINAR = '7';
    const EVENT_TYPE_CONCERT = '8';
    const EVENT_TYPE_ORGANIZER_ONLY = '9';
    const EVENT_TYPE_SHUTTLES = '10';
    const EVENT_TYPE_2ND_STAGE = '11';

    const CREATE_BUTTON_TEXT = 'Create event';

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/backend/events';
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
            '@eventTypeDropdown' => '#app > main > div > div > div.card-header > form > select[name=event_type_id]',
        ];
    }

    public function selectEventType(Browser $browser, $destinationOption)
    {
        $browser->select('@eventTypeDropdown', $destinationOption);
    }

    public function clickCreateEvent(Browser $browser)
    {
        $browser->clickCreateButton(self::CREATE_BUTTON_TEXT);
    }
}
