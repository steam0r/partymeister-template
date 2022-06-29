<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class CreateMessageGroup extends CreatePage
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/backend/message-groups/create';
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
            '@pmAdminCheckbox' => '#users_2',
            '@saveMessageGroupButton' => '#app > main > div > form > div > div.card-footer > button.btn-primary',
        ];
    }

    public function checkPmAdminCheckbox(Browser $browser)
    {
        $browser->check('@pmAdminCheckbox');
    }

    public function uncheckPmAdminCheckbox(Browser $browser)
    {
        $browser->uncheck('@pmAdminCheckbox');
    }

    public function clickSaveMessageGroup(Browser $browser)
    {
        $browser->click('@saveMessageGroupButton')
                ->assertPathIs('/backend/message-groups'); //add check that item was created
    }
}
