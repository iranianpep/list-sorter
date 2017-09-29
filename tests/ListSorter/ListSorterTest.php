<?php

namespace ListSorter;

use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class ListSorterTest extends TestCase
{
    private function getSortableItems()
    {
        return  [
            'created_at' => new SortableItem('created_at'),
        ];
    }

    private function getListSorter($request)
    {
        return new ListSorter($request, $this->getSortableItems());
    }

    public function testConstruct()
    {
        $request = new Request();

        $listSorter = $this->getListSorter($request);

        $this->assertEquals($request, $listSorter->getRequest());
        $this->assertEquals($this->getSortableItems(), $listSorter->getSortableItems());
    }

    public function testGetSortByKey()
    {
        $request = new Request();

        $listSorter = $this->getListSorter($request);

        $this->assertEquals(ListSorter::DEFAULT_SORT_BY_KEY, $listSorter->getSortByKey());

        $listSorter->setSortByKey('sortBy');

        $this->assertEquals('sortBy', $listSorter->getSortByKey());
    }

    public function testGetSortDirKey()
    {
        $request = new Request();

        $listSorter = $this->getListSorter($request);

        $this->assertEquals(ListSorter::DEFAULT_SORT_DIR_KEY, $listSorter->getSortDirKey());

        $listSorter->setSortDirKey('sortDir');

        $this->assertEquals('sortDir', $listSorter->getSortDirKey());
    }

    public function testGetDefaultSortBy()
    {
        $request = new Request();
        $listSorter = $this->getListSorter($request);

        $listSorter->setDefaultSortBy('created_at');
        $this->assertEquals('created_at', $listSorter->getDefaultSortBy());
    }

    public function testGetDefaultSortDir()
    {
        $request = new Request();
        $listSorter = $this->getListSorter($request);

        $listSorter->setDefaultSortDir('asc');
        $this->assertEquals('asc', $listSorter->getDefaultSortDir());
    }
}
