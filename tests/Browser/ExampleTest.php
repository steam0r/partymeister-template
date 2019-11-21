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
use Tests\Browser\Pages\CreateCallback;
use Tests\Browser\Pages\CreateEvent;
use Tests\Browser\Pages\CreateEventType;
use Tests\Browser\Pages\CreateGuest;
use Tests\Browser\Pages\CreateMessageGroup;
use Tests\Browser\Pages\CreateSchedule;
use Tests\Browser\Pages\CreateVisitor;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @throws \Throwable
     */

    // public function testCreateEventType()
    // {
    //     $this->browse(function (Browser $browser) {
    //         $browser->loginAs(User::find(2))
    //                 ->visit(new CreateEventType)
    //                 ->enterName('autotest name')
    //                 ->enterWebColor('#cae9f4')
    //                 ->enterSlideColor('#2fa7d6')
    //                 ->screenshot('create_eventtype_test')
    //                 ->clickSaveEventType()
    //                 ->screenshot('create_eventtype_test_saved');

    //     });
    // }

    // public function testCreateGuest()
    // {
    //     $this->browse(function (Browser $browser) {
    //         $browser->loginAs(User::find(2))
    //                 ->visit(new CreateGuest)
    //                 ->enterName('autotest name')
    //                 ->selectCategory(CreateGuest::CATEGORY_TEST)
    //                 ->enterHandle('autotest')
    //                 ->enterCompany('autotest')
    //                 ->enterEmail('autotest')
    //                 ->enterCountry('Germany')
    //                 ->enterTicketCode('123xyz')
    //                 ->enterTicketType('')
    //                 ->enterTicketOrderNo('12345')
    //                 ->enterComment('blabla
    //                 blablabla
    //                 blablablabla')
    //                 ->checkHasBadge()
    //                 ->checkHasArrived()
    //                 ->checkTicketCodeScanned()
    //                 ->screenshot('create_eventtype_test')
    //                 ->clickSaveGuest()
    //                 ->screenshot('create_eventtype_test_saved');

    //     });
    // }

    // public function testCreateMessageGroup()
    // {
    //     $this->browse(function (Browser $browser) {
    //         $browser->loginAs(User::find(2))
    //                 ->visit(new CreateMessageGroup)
    //                 ->enterName('autotest name')
    //                 ->checkPmAdminCheckbox()
    //                 ->screenshot('create_eventtype_test')
    //                 ->clickSaveMessageGroup()
    //                 ->screenshot('create_eventtype_test_saved');

    //     });
    // }

    public function testCreateVisitors()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(2))
                    ->visit(new CreateVisitor)
                    ->enterName('autotest name')
                    ->enterGroup('autotest group')
                    ->enterEmail('autotest email')
                    ->enterPassword('autotestpassword')
                    ->screenshot('create_visitor_test')
                    ->clickSaveVisitor()
                    ->screenshot('create_visitor_test_saved');

        });
    }
}
