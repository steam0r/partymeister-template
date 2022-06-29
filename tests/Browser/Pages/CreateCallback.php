<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class CreateCallback extends CreatePage
{
    const ACTION_NOTIFICATION = 'notification';

    const ACTION_LIVE = 'live';

    const ACTION_LIVE_WITH_NOTIFICATION = 'live_with_notification';

    const DESTINATION_ORGA = 'orga';

    const DESTINATION_NOWPLAYING = 'nowplaying';

    const DESTINATION_GENERAL = 'general';

    const DESTINATION_COMPETITIONS = 'competitions';

    const DESTINATION_SEMINARS = 'seminars';

    const DESTINATION_DEADLINES = 'deadlines';

    const DESTINATION_EVENTS = 'events';

    const DESTINATION_NIGHTSHUTTLE = 'nightshuttle';

    const DESTINATION_LOCATION = 'location';

    const DESTINATION_IOS = 'ios';

    const DESTINATION_ANDROID = 'android';

    const DESTINATION_TESTING = 'testing';

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/backend/callbacks/create';
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
            '@actionDropdown'=> '#action',
            '@destinationDropdown' => '#destination',
            '@titleField' => '#title',
            '@bodyField' => '#body',
            '@linkField' => '#link',
            '@hasFiredCheckbox' => '#has_fired',
            '@isTimedCheckbox' => '#is_timed',
            '@embargoUntilPicker' => '#embargo_until_picker', //fixme. component erstellen
            '@saveCallbackButton' => '#app > main > div > form > div:nth-child(4) > div.card-footer > button.competition-submit',
        ];
    }

    public function selectAction(Browser $browser, $actionOption)
    {
        $browser->select('@actionDropdown', $actionOption);
    }

    public function selectDestination(Browser $browser, $destinationOption)
    {
        $browser->select('@destinationDropdown', $destinationOption);
    }

    public function enterTitle(Browser $browser, $titleString)
    {
        $browser->type('@titleField', $titleString);
    }

    public function enterBody(Browser $browser, $bodyString)
    {
        $browser->type('@bodyField', $bodyString);
    }

    public function enterLink(Browser $browser, $fieldString)
    {
        $browser->type('@linkField', $fieldString);
    }

    public function checkHasFired(Browser $browser)
    {
        $browser->check('@hasFiredCheckbox');
    }

    public function uncheckHasFired(Browser $browser)
    {
        $browser->uncheck('@hasFiredCheckbox');
    }

    public function checkIsTimed(Browser $browser)
    {
        $browser->check('@isTimedCheckbox');
    }

    public function uncheckIsTimed(Browser $browser)
    {
        $browser->uncheck('@isTimedCheckbox');
    }

    public function setEmbargoToCurrentDatetime(Browser $browser)
    {
        $browser->click('@embargoUntilPicker');
    }

    public function clickSaveCallback(Browser $browser)
    {
        $browser->click('@saveCallbackButton')
                ->assertPathIs('/backend/callbacks'); //add check that item was created
    }
}
