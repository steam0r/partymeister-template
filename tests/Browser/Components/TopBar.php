<?php

namespace Tests\Browser\Components;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Component as BaseComponent;

class TopBar extends BaseComponent
{
    /**
     * Get the root selector for the component.
     *
     * @return string
     */
    public function selector()
    {
        return 'header.app-header';
    }

    /**
     * Assert that the browser page contains the component.
     *
     * @param  Browser  $browser
     * @return $this
     */
    public function assert(Browser $browser)
    {
        $browser->assertVisible('')
                ->assertVisible('@navbar-toggle')
                ->assertVisible('@user-menu-toggle');

        return $this;
    }

    /**
     * Get the element shortcuts for the component.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@navbar-toggle' => 'button.navbar-toggler.sidebar-toggler.d-md-down-none',
            '@user-menu-toggle' => 'ul > li > a.nav-link.dropdown-toggle',
        ];
    }

    /**
     * Open Edit Profile page.
     *
     * @param  Browser  $browser
     * @return $this
     */
    public function openProfile(Browser $browser)
    {
        $browser->click('@user-menu-toggle')
                ->clickLink('Profile')
                ->assertPathIs('/backend/profile/edit');

        return $this;
    }

    /**
     * Log out of the application.
     *
     * @param  Browser  $browser
     * @return $this
     */
    public function signOutComponent(Browser $browser)
    {
        $browser->click('@user-menu-toggle')
                ->click('ul > li > div > form > button.dropdown-item')
                ->assertPathIs('/start');

        return $this;
    }
}
