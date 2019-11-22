<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class EditVisitor extends CreateVisitor
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
        return '/backend/visitors/'.$this->id.'/edit';
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
            '@element' => '#selector',
        ], parent::elements());
    }
}
