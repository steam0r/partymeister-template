<?php

namespace Tests\Browser;

use Motor\Backend\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\Components\TopBar;
use Tests\Browser\Pages\Callbacks;
use Tests\Browser\Pages\Events;
use Tests\Browser\Pages\GridPage;
use Tests\Browser\Pages\Schedules;
use Tests\Browser\Pages\Guests;

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
                    ->visit(new Guests)
                    ->clickHasArrived(1)
                    ->screenshot('has_arrived');

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
