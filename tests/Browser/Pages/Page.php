<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;
use Tests\Browser\Components\TopBar;

class Page extends BasePage
{
    /**
     * Get the global element shortcuts for the site.
     *
     * @return array
     */
    public static function siteElements()
    {
    }

    public function url()
    {
        return '/';
    }

    public function signOut(Browser $browser)
    {
        $browser->within(new TopBar, function ($browser) {
            $browser->signOut();
        });

        return $this;
    }
}
