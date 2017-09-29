<?php

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

    public function testConstructWithException()
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage('Sortable item alias must be unique');

        new ListSorter(new Request(), $this->getDuplicatedSortableItems());
    }

    public function testConstructWithEmptyItems()
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage('Sortable items must not be empty');

        new ListSorter(new Request(), []);
    }

    public function testConstructWithInvalidItems()
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage('Invalid sortable item');

        new ListSorter(new Request(), ['nonObjectElement']);
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

    public function testGetSortBy()
    {
        $request = new Request();

        $this->assertEquals(null, $this->getListSorter($request)->getSortBy());

        $request->merge(['by' => 'created_at']);
        $this->assertEquals('created_at', $this->getListSorter($request)->getSortBy());
    }

    public function testGetSortDir()
    {
        $request = new Request();

        $listener = $this->getListSorter($request);
        $this->assertEquals(null, $listener->getSortDir());

        $listener->setDefaultSortDir('desc');
        $this->assertEquals('desc', $listener->getSortDir());

        $request->merge(['dir' => 'asc']);
        $this->assertEquals('asc', $listener->getSortDir());
    }

    public function testGetNewSortDir()
    {
        $request = new Request();

        $listener = $this->getListSorter($request);
        $this->assertEquals('asc', $listener->getNewSortDir());

        $request->merge(['dir' => 'asc']);
        $this->assertEquals('desc', $listener->getNewSortDir());
    }

    public function testIsSortable()
    {
        $request = new Request();
        $listSorter = $this->getListSorter($request);

        $this->assertTrue($listSorter->isSortable('created_at'));
        $this->assertFalse($listSorter->isSortable('title'));
    }
}
