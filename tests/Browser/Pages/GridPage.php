<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class GridPage extends Page
{
    const PAGINATION_25 = '25';

    const PAGINATION_50 = '50';

    const PAGINATION_100 = '100';

    const PAGINATION_200 = '200';

    const GRID_ROW_PREFIX = '#app > main > div > div > div.card-body.table-responsive.no-padding > table > tbody > ';

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

    public function editElement(Browser $browser, $elementIndexNumber)
    {
        $browser->click($this->getButtonPrefixByElementIndex($elementIndexNumber).'a.btn.btn-warning.btn-sm')
                // ->assertPathIs('dgegegeg')
;
    }

    public function duplicateElement(Browser $browser, $elementIndexNumber)
    {
        $browser->click($this->getButtonPrefixByElementIndex($elementIndexNumber).'a.btn.btn-info.btn-sm')
                // ->assertPathIs('sfgsgwrgwg')
;
    }

    public function deleteElement(Browser $browser, $elementIndexNumber)
    {
        $elementName = $this->getElementName($browser, $elementIndexNumber);
        $browser->click($this->getButtonPrefixByElementIndex($elementIndexNumber).'form > button.delete-record')
                ->acceptDialog()
                ->assertDontSee($elementName);
    }

    public function tryDeleteElementNotConfirmDialog(Browser $browser, $elementIndexNumber)
    {
        $elementName = $this->getElementName($browser, $elementIndexNumber);
        $browser->click($this->getButtonPrefixByElementIndex($elementIndexNumber).'form > button.delete-record')
                ->dismissDialog()
                ->assertSee($elementName);
    }

    private function getButtonPrefixByElementIndex($elementIndexNumber)
    {
        return self::GRID_ROW_PREFIX.'tr:nth-child('.$elementIndexNumber.') > td.action-column > ';
    }

    private function getElementName(Browser $browser, $elementIndexNumber)
    {
        if ($elementIndexNumber == 1) {
            return $browser->text(self::GRID_ROW_PREFIX.'tr:first-child > td:nth-child(1)');
        } else {
            return $browser->text(self::GRID_ROW_PREFIX.'tr:nth-child('.$elementIndexNumber.') > td:nth-child(1)');
        }
    }

    public function clickCreateButton(Browser $browser, $linkText)
    {
        $browser->clickLink($linkText)
                ->assertPathIs($this->url().'/create');
    }
}
