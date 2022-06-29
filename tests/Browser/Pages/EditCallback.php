<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class EditCallback extends CreateCallback
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
        return '/backend/callbacks/'.$this->id.'/edit';
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
            '@payload' => '#payload',
            '@hash' => '#hash',
        ], parent::elements());
    }

    public function getPayload(Browser $browser)
    {
        $browser->text('@payload');
    }

    public function getHash(Browser $browser)
    {
        $browser->text('@hash');
    }
}
