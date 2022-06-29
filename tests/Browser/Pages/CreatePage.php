<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class CreatePage extends Page //not ready yet
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/';
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
    public static function siteElements()
    {
        return [
            '@nameField' => '#name',
        ];
    }

    public function clickBackButton(Browser $browser, Page $targetPage)
    {
        $browser->clickLink('back')
                ->assertPathIs($targetPage->url());
    }

    public function enterName(Browser $browser, $nameString)
    {
        $browser->type('@nameField', $nameString);
    }

    // public function clickSaveButton(Browser $browser)
    // {
    //     $browser->clickLink('@backButton')
    //             ->assertPathIs($this->url().'/create'); //fixme
    // }
}
