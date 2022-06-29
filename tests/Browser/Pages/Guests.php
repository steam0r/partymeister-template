<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class Guests extends GridPage
{
    const CATEGORY_TEST = '55';
    // const CATEGORY_GENERAL = 'general';
    // const CATEGORY_COMPETITIONS = 'completitions';
    // const CATEGORY_SEMINARS = 'seminars';
    // const CATEGORY_DEADLINES = 'deadlines';
    // const CATEGORY_EVENTS = 'events';
    // const CATEGORY_NIGHTSHUTTLE = 'nightshuttle';
    // const CATEGORY_LOCATION = 'location';
    // const CATEGORY_IOS = 'ios';

    const HAS_ARRIVED_YES = '1';

    const HAS_ARRIVED_NO = '0';

    const CREATE_BUTTON_TEXT = 'Create guest / ticket';

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/backend/guests';
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
            '@categoryDropdown' => '#app > main > div > div > div.card-header > form > select[name=category_id]',
            '@hasArrivedDropdown' => '#app > main > div > div > div.card-header > form > select[name=has_arrived]',
            '@scanTicketsButton' => '#app > main > div > section > h4 > button.scan-tickets',
            '@scanTicketsModal' => '#scan-tickets-modal > div',
            '@scanTicketsModalInput' => '#scan-tickets-form > input[name=ticket_code]',
            '@scanTicketsModalCancelButton' => '#scan-tickets-modal > div > div > div.modal-header > div > button.outline-secondary', //fixme
            '@hasArrivedModal' => '#guest-modal > div',
            '@hasArrivedModalConfirmButton' => ' > div > div.modal-header > div > button.btn-success',
            '@hasArrivedModalCancelButton' => ' > div > div.modal-header > div > button.outline-secondary',
        ];
    }

    //Select search filters

    public function selectCategory(Browser $browser, $categoryOption)
    {
        $browser->select('@categoryDropdown', $categoryOption);
    }

    public function selectHasArrived(Browser $browser, $hasArrivedOption)
    {
        $browser->select('@hasArrivedDropdown', $hasArrivedOption);
    }

    //Click buttons on top

    public function clickCreateGuest(Browser $browser)
    {
        $browser->clickCreateButton(self::CREATE_BUTTON_TEXT);
    }

    public function clickScanTickets(Browser $browser)
    {
        $browser->click('@scanTicketsButton')
                ->whenAvailable('@scanTicketsModal', function ($modal) {
                    $modal->assertSee('Scan tickets');
                });
    }

    // Scan Tickets modal window manipulations

    public function scanValidTicket(Browser $browser, $ticketID)
    {
        $this->clickScanTickets($browser);
        $browser->type('@scanTicketsModalInput', $ticketID)
                ->keys('@scanTicketsModalInput', '{enter}')
                ->waitForText('Ticket code ('.$ticketID.') not found!');
    }

    public function scanInvalidTicket(Browser $browser, $ticketID)
    {
        $this->clickScanTickets($browser);
        $browser->type('@scanTicketsModalInput', $ticketID)
                ->keys('@scanTicketsModalInput', '{enter}')
                ->waitForText('Ticket code ('.$ticketID.') not found!');
    }

    public function cancelScanTickets(Browser $browser)
    {
        $browser->click('@scanTicketsModalCancelButton')
                ->waitUntilMissing('@scanTicketsModal');
    }

    // Grid row manipulations

    public function clickHasArrived(Browser $browser, $elementIndexNumber)
    {
        if (! ($this->getHasArrivedStatus($browser, $elementIndexNumber))) {
            $ticketCode = $this->getTicketCode($browser, $elementIndexNumber);
            if (empty($ticketCode)) {
                $browser->click($this->getHasArrivedButtonPrefix($elementIndexNumber).'.btn-outline-secondary');
                $browser->waitFor($this->getHasArrivedButtonPrefix($elementIndexNumber).'.btn-success');
                echo 'For element '.$elementIndexNumber.': has arrived = no; has ticket code = no';
            } else {
                $browser->click($this->getHasArrivedButtonPrefix($elementIndexNumber).'.btn-outline-secondary')
                        ->whenAvailable('@hasArrivedModal', function ($modal) use ($ticketCode, $elementIndexNumber) {
                            $modal->assertSee('Mark guest as \'arrived\'')
                                    ->assertSee('Is the ticket code '.$ticketCode.' correct?')
                                    ->click('@hasArrivedModalConfirmButton') // DOESN'T WORK!
                                    ->waitUntilMissing('@hasArrivedModal', 5) // DOESN'T WORK!
                                    ->waitFor($this->getHasArrivedButtonPrefix($elementIndexNumber).'.btn-success'); // DOESN'T WORK!
                echo 'For element '.$elementIndexNumber.': has arrived = no; has ticket code = yes';
                        });
            }
        }
    }

    //Helpers

    private function getTicketCode(Browser $browser, $elementIndexNumber)
    {
        return $browser->text('#app > main > div > div.card > div.card-body.table-responsive.no-padding > table > tbody > tr:nth-child('.$elementIndexNumber.') > td:nth-child(5)');
    }

    private function getHasArrivedButtonPrefix($elementIndexNumber)
    {
        return '#app > main > div > div.card > div.card-body.table-responsive.no-padding > table > tbody > tr:nth-child('.$elementIndexNumber.') > td:nth-child(7) > button';
    }

    private function getHasArrivedStatus(Browser $browser, $elementIndexNumber)
    {
        if (is_null($browser->element($this->getHasArrivedButtonPrefix($elementIndexNumber).'.btn-success'))) {
            return false;
        }

        return true;
    }
}
