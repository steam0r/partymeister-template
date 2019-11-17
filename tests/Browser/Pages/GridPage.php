<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class GridPage extends Page
{

    const PAGINATION_25 = '25';
    const PAGINATION_50 = '50';
    const PAGINATION_100 = '100';
    const PAGINATION_200 = '200';

    /**
     * Get the global element shortcuts for the site.
     *
     * @return array
     */
    public static function siteElements()
    {
        $prefix = '#app > main > div > div > div.card-header > form > ';
        return [
            '@searchField' => $prefix.'input[name=search]',
            '@paginationDropdown' => $prefix.'select[name=per_page]',
            '@submitSearchButton' => '#grid-search-button',
        ];
    }

    public function url()
    {
        return '/';
    }

    public function inputSearchTerm(Browser $browser, $searchTerm)
    {
        $browser->type('@searchField', $searchTerm);
    }

    public function selectPagination(Browser $browser, $paginationOption)
    {
        $browser->select('@paginationDropdown', $paginationOption);
    }

    public function submitSearch(Browser $browser)
    {
        $browser->click('@submitSearchButton');
    }

}
