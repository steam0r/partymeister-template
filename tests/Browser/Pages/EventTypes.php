<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class EventTypes extends GridPage
{
    const CREATE_BUTTON_TEXT = 'Create event type';

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/backend/event_types';
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
            '@element' => '#selector',
        ];
    }

    public function clickCreateEventType(Browser $browser)
    {
        $browser->clickCreateButton(self::CREATE_BUTTON_TEXT);
    }
}
