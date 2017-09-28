<?php

namespace ListSorter;

use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class ListSorterTest extends TestCase
{
    public function testConstruct()
    {
        $request = new Request();

        $sortableItems = [
            'created_at' => new SortableItem('created_at')
        ];

        $listSorter = new ListSorter($request, $sortableItems);

        $this->assertEquals($request, $listSorter->getRequest());
        $this->assertEquals($sortableItems, $listSorter->getSortableItems());
    }
}
