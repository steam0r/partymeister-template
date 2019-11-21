<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class CreateSchedule extends CreatePage
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/backend/schedules/create';
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
            '@saveScheduleButton' => '#app > main > div > form > div > div.card-footer > button.btn-primary',
        ];
    }

    public function clickSaveSchedule(Browser $browser)
    {
        $browser->click('@saveScheduleButton')
                ->assertPathIs('/backend/schedules'); //add check that item was created
    }
}
