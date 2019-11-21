<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class CreateEvent extends CreatePage
{
    const SCHEDULE_MAIN_SCHEDULE = '1';

    const EVENT_COMPETITIONS = '1';
    const EVENT_DEADLINE = '2';
    const EVENT_EVENT = '3';
    const EVENT_DEMOSHOW = '4';
    const EVENT_LIVE_ACT = '5';
    const EVENT_FOOD_DEADLINE = '6';
    const EVENT_SEMINAR = '7';
    const EVENT_CONCERT = '8';
    const EVENT_ORGANIZER_ONLY = '9';
    const EVENT_SHUTTLES = '10';
    const EVENT_2ND_STAGE = '11';

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/backend/events/create';
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
            '@scheduleDropdown' => '#schedule_id',
            '@eventTypeDropdown' => '#event_type_id',
            '@datetimePicker' => '#starts_at_picker',
            '@visibleDropdown' => '#is_visible',
            '@organizerOnlyDropdown' => '#is_organizer_only',
            '@sortPosition' => '#sort_position',
            '@saveEventButton' => '#app > main > div > form > div > div.card-footer > button.btn-primary',
        ];
    }

    public function selectSchedule (Browser $browser, $scheduleOption) {
        $browser->select('@scheduleDropdown', $scheduleOption);
    }

    public function selectEventType (Browser $browser, $eventTypeOption) {
        $browser->select('@eventTypeDropdown', $eventTypeOption);
    }

    public function setDatetimeToCurrentDatetime(Browser $browser)
    {
        $browser->click('@datetimePicker')
                ->keys('@datetimePicker', '{enter}');
    }

    public function checkVisibleDropdown (Browser $browser) {
        $browser->check('@visibleDropdown');
    }

    public function uncheckVisibleDropdown (Browser $browser) {
        $browser->uncheck('@visibleDropdown');
    }

    public function checkOrganizerOnly (Browser $browser) {
        $browser->check('@organizerOnlyDropdown');
    }

    public function uncheckOrganizerOnly (Browser $browser) {
        $browser->uncheck('@organizerOnlyDropdown');
    }

    public function enterSortPosition (Browser $browser, $sortPosition) {
        $browser->type('@sortPosition', $sortPosition);
    }

    public function clickSaveEvent(Browser $browser)
    {
        $browser->click('@saveEventButton')
                ->assertPathIs('/backend/events'); //add check that item was created
    }
}
