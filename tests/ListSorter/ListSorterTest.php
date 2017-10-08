<?php

declare(strict_types=1);

namespace ListSorter;

use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class ListSorterTest extends TestCase
{
    private function getSortableItems()
    {
        return  [
            new SortableItem('created_at'),
        ];
    }

    private function getDuplicatedSortableItems()
    {
        return  [
            new SortableItem('title'),
            new SortableItem('title'),
            new SortableItem('created_at'),
        ];
    }

    private function getSortableItemsWithColumn()
    {
        return  [
            new SortableItem('applicant', 'name', 'applicant'),
            new SortableItem('title', 'title', '', 'Job'),
            new SortableItem('created_at', 'created_at', 'applications', 'Created At'),
        ];
    }

    private function getListSorter($request)
    {
        return new ListSorter($request, $this->getSortableItems());
    }

    private function getListSorterWithColumn($request)
    {
        return new ListSorter($request, $this->getSortableItemsWithColumn());
    }

    public function testGetRequest()
    {
        $request = new Request();
        $listSorter = $this->getListSorter($request);
        $this->assertEquals($request, $listSorter->getRequest());
    }

    public function testGetSortableItems()
    {
        $request = new Request();
        $listSorter = $this->getListSorter($request);
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

    public function testGetSelectedSortableItem()
    {
        $request = new Request();

        $sortableItems = $this->getSortableItemsWithColumn();
        $listSorter = new ListSorter($request, $sortableItems);

        $request->merge([$listSorter->getSortByKey() => 'applicant']);
        $this->assertEquals($sortableItems[0], $listSorter->getSelectedSortableItem());
    }

    public function testGetDefaultSortBy()
    {
        $request = new Request();
        $listSorter = $this->getListSorter($request);

        $listSorter->setDefaultSortBy('created_at');
        $this->assertEquals('created_at', $listSorter->getDefaultSortBy());

        $this->expectException('\Exception');
        $this->expectExceptionMessage('Invalid sortable item key : invalid');

        $listSorter->setDefaultSortBy('invalid');
    }

    public function testGetDefaultSortDir()
    {
        $request = new Request();
        $listSorter = $this->getListSorter($request);

        $this->assertEquals(null, $listSorter->getDefaultSortDir());

        $listSorter->setDefaultSortDir('asc');
        $this->assertEquals('asc', $listSorter->getDefaultSortDir());
    }
}
