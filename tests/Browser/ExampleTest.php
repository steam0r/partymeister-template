<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Motor\Backend\Models\User;
use Tests\Browser\Pages\CreateCallback;
use Tests\Browser\Pages\CreateEvent;
use Tests\Browser\Pages\CreateEventType;
use Tests\Browser\Pages\CreateGuest;
use Tests\Browser\Pages\CreateMessageGroup;
use Tests\Browser\Pages\CreateVisitor;
use Tests\Browser\Pages\DuplicateEvent;
use Tests\Browser\Pages\EditCallback;
use Tests\Browser\Pages\EditEventType;
use Tests\Browser\Pages\EditGuest;
use Tests\Browser\Pages\EditMessageGroup;
use Tests\Browser\Pages\EditSchedule;
use Tests\DuskTestCase;

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

    // public function testCreateVisitors()
    // {
    //     $this->browse(function (Browser $browser) {
    //         $browser->loginAs(User::find(2))
    //                 ->visit(new CreateVisitor)
    //                 ->enterName('autotest name')
    //                 ->enterGroup('autotest group')
    //                 ->enterEmail('autotest email')
    //                 ->enterPassword('autotestpassword')
    //                 ->screenshot('create_visitor_test')
    //                 ->clickSaveVisitor()
    //                 ->screenshot('create_visitor_test_saved');

    //     });
    // }

    // public function testEditCallback()
    // {
    //     $this->browse(function (Browser $browser) {
    //         $browser->loginAs(User::find(2))
    //                 ->visit(new EditCallback(9))
    //                 ->enterName('autotest 3')
    //                 ->selectDestination(CreateCallback::DESTINATION_IOS)
    //                 ->screenshot('test');

    //     });
    // }

    // public function testEditSchedule()
    // {
    //     $this->browse(function (Browser $browser) {
    //         $browser->loginAs(User::find(2))
    //                 ->visit(new EditSchedule(2))
    //                 ->enterName('autotest 3')
    //                 ->screenshot('test')
    //                 ->clickSaveSchedule()
    //                 ->screenshot('test2');

    //     });
    // }

    // public function testDuplicateEvent()
    // {
    //     $this->browse(function (Browser $browser) {
    //         $browser->loginAs(User::find(2))
    //                 ->visit(new DuplicateEvent(1))
    //                 ->enterName('duplicate test')
    //                 ->selectEventType(CreateEvent::EVENT_CONCERT)
    //                 ->screenshot('test')
    //                 ->clickSaveEvent()
    //                 ->screenshot('test2');

    //     });
    // }

    // public function testEditEventType()
    // {
    //     $this->browse(function (Browser $browser) {
    //         $browser->loginAs(User::find(2))
    //                 ->visit(new EditEventType(14))
    //                 ->enterName('edit test')
    //                 ->enterWebColor('#ed9ae9')
    //                 ->screenshot('test')
    //                 ->clickSaveEventType()
    //                 ->screenshot('test2');

    //     });
    // }

    // public function testEditGuest()
    // {
    //     $this->browse(function (Browser $browser) {
    //         $browser->loginAs(User::find(2))
    //                 ->visit(new EditGuest(1))
    //                 ->enterName('edit test name')
    //                 ->enterHandle('edit test handle')
    //                 ->screenshot('test');
    //                 var_dump($browser->text('@arrivedAt'));
    //                 $browser->clickSaveGuest()
    //                 ->screenshot('test2');

    //     });
    // }

    // public function testEditVisitor()
    // {
    //     $this->browse(function (Browser $browser) {
    //         $browser->loginAs(User::find(2))
    //                 ->visit(new EditGuest(1))
    //                 ->enterName('edit test name')
    //                 ->enterHandle('edit test handle')
    //                 ->screenshot('test');
    //                 var_dump($browser->text('@arrivedAt'));
    //                 $browser->clickSaveGuest()
    //                 ->screenshot('test2');

    //     });
    // }

    public function testEditMessageGroup()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(2))
                    ->visit(new EditMessageGroup(2))
                    ->enterName('edit test name')
                    ->uncheckPmAdminCheckbox()
                    ->screenshot('test')
                    ->clickSaveMessageGroup()
                    ->screenshot('test2');
        });
    }
}
