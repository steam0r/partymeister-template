<?php

namespace Tests\Browser;

use Motor\Backend\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\Components\TopBar;
use Tests\Browser\Pages\Callbacks;
use Tests\Browser\Pages\GridPage;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @throws \Throwable
     */

    public function testTest()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(2))
                // ->visit('/backend/dashboard')
                // ->assertSee('Dashboard')
                // ->within(new TopBar, function ($browser) {
                //     $browser->assert()
                //     ->openProfile()
                //     ->signOut();
                // }); 
                ->visit(new Callbacks)
                ->inputSearchTerm('temp')
                ->selectPagination(GridPage::PAGINATION_50)
                // ->selectDestination(Callbacks::DESTINATION_NOWPLAYING)
                ->submitSearch()
                ->assertSee('temp_test')
                ->clickCreateCallback();

        });
    }

    // public function testBasicExample()
    // {
    //     $this->browse(function (Browser $browser) {
    //         $browser->visit('/backend')
    //             ->assertSee('Login');
    //     });
    // }

    // public function testLogin()
    // {
    //     $this->browse(function (Browser $browser) {
    //         $browser->loginAs(User::find(2))
    //             ->visit('/backend/dashboard')
    //             ->assertSee('Dashboard');

    //     });
    // }

    // public function testFrontend()
    // {
    //     $this->browse(function (Browser $browser) {
    //         $browser->visit('/start')
    //             ->assertSee('OUTLINE');
    //     });
    // }
}
