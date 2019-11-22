<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class EditGuest extends CreateGuest
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/backend/guests/'.$this->id.'/edit';
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
        return array_merge([
            '@arrivedAt' => '#arrived_at',
        ], parent::elements());
    }

    // public function getArrivedAt(Browser $browser)
    // {
    //     return $browser->text('@arrivedAt'); // DOESN'T WORK
    // }
}
