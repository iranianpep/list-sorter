<?php

namespace ListSorter;

use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class ListSorterTest extends TestCase
{
    private function getSortableItems()
    {
        return  [
            'created_at' => new SortableItem(),
        ];
    }

    private function getDuplicatedSortableItems()
    {
        return  [
            'title'      => new SortableItem('title'),
            'title'      => new SortableItem('title'),
            'created_at' => new SortableItem('created_at'),
        ];
    }

    private function getSortableItemsWithColumn()
    {
        return  [
            'applicant'  => new SortableItem('name', 'applicant', 'Applicant'),
            'title'      => new SortableItem('title', '', 'Job'),
            'created_at' => new SortableItem('created_at', 'applications', 'Created At'),
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
}
