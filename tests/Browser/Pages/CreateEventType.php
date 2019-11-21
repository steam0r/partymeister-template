<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class CreateEventType extends CreatePage
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/backend/event_types/create';
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
            '@webColorInput' => '#app > main > div > form > div > div.card-body > div:nth-child(2) > div > input', //fixme
            '@slideColorInput' => '#app > main > div > form > div > div.card-body > div:nth-child(3) > div > input', //fixme
            '@saveEventTypeButton' => '#app > main > div > form > div > div.card-footer > button.btn-primary'
        ];
    }

    public function enterWebColor(Browser $browser, $hexColorCode)
    {
        $browser->type('@webColorInput', $hexColorCode)
                ->keys('@webColorInput', '{enter}');
    }

    public function enterSlideColor(Browser $browser, $hexColorCode)
    {
        $browser->type('@slideColorInput', $hexColorCode)
                ->keys('@slideColorInput', '{enter}');
    }

    public function clickSaveEventType(Browser $browser)
    {
        $browser->click('@saveEventTypeButton')
                ->assertPathIs('/backend/event_types'); //add check that item was created
    }
}
