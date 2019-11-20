<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class Schedules extends GridPage
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/backend/schedules';
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

    public function clickCreateSchedule(Browser $browser)
    {
        $browser->clickLink('Create schedule')
                ->assertPathIs('/backend/schedules/create111');
    }
}
