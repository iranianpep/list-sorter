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

    public function testConstructWithEmptyItems()
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage('Sortable items can not be empty');
        new ListSorter(new Request(), []);
    }

    public function testConstructWithException()
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage('Sortable item alias must be unique');
        new ListSorter(new Request(), $this->getDuplicatedSortableItems());
    }

    public function testConstructWithException2()
    {
        $sortableItems = [
            'title',
            'title',
            'created_at',
        ];

        $this->expectException('Exception');
        $this->expectExceptionMessage('Sortable item alias must be unique');

        new ListSorter(new Request(), $sortableItems);
    }

    public function testConstructWithNonObjects()
    {
        $sortableItems = [
            'title',
            'created_at',
        ];

        $sortableItemsObjects = [
            new SortableItem('title'),
            new SortableItem('created_at'),
        ];

        $listSorter = new ListSorter(new Request(), $sortableItems);
        $this->assertEquals($sortableItemsObjects, $listSorter->getSortableItems());
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

        $this->assertEquals(null, $listSorter->getSelectedSortableItem());

        $listSorter->setDefaultSortBy('title');
        $this->assertEquals($sortableItems[1], $listSorter->getSelectedSortableItem());

        $request->merge([$listSorter->getSortByKey() => 'applicant']);
        $this->assertEquals($sortableItems[0], $listSorter->getSelectedSortableItem());
    }

    public function testGetSortBy()
    {
        $request = new Request();

        $sortableItems = $this->getSortableItemsWithColumn();
        $listSorter = new ListSorter($request, $sortableItems);

        $request->merge([$listSorter->getSortByKey() => 'applicant']);
        $this->assertEquals('applicant.name', $listSorter->getSortBy());
    }

    public function testGetSortByEmpty()
    {
        $request = new Request();

        $sortableItems = $this->getSortableItemsWithColumn();
        $listSorter = new ListSorter($request, $sortableItems);

        $request->merge([$listSorter->getSortByKey() => 'dummy']);
        $this->assertEquals(null, $listSorter->getSortBy());
    }

    public function testGetSortDir()
    {
        $request = new Request();

        $sortableItems = $this->getSortableItemsWithColumn();
        $listSorter = new ListSorter($request, $sortableItems);

        $request->merge([$listSorter->getSortByKey() => 'applicant']);
        $this->assertEquals(null, $listSorter->getSortDir());

        $listSorter->setDefaultSortDir('desc');
        $this->assertEquals('desc', $listSorter->getSortDir());

        ($sortableItems[0])->setSortDir('asc');
        $this->assertEquals('asc', $listSorter->getSortDir());
    }

    public function testGetSortDirEmpty()
    {
        $request = new Request();

        $sortableItems = $this->getSortableItemsWithColumn();
        $listSorter = new ListSorter($request, $sortableItems);

        $request->merge([$listSorter->getSortByKey() => 'dummy']);
        $this->assertEquals(null, $listSorter->getSortDir());
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
