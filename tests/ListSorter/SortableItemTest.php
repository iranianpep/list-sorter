<?php

namespace ListSorter;

use PHPUnit\Framework\TestCase;

class SortableItemTest extends TestCase
{
    const DUMMY_KEY = 'created';
    const DUMMY_KEY_2 = 'Modified At';
    const DUMMY_KEY_3 = 'modified_at';
    const DUMMY_TABLE_ALIAS = 'users';
    const DUMMY_TITLE = 'Created';
    const DUMMY_COLUMN = 'created_at';

    public function testGetTitle()
    {
        $sortableItem = new SortableItem(self::DUMMY_KEY);
        $sortableItem->setTitle(self::DUMMY_TITLE);
        $this->assertEquals(self::DUMMY_TITLE, $sortableItem->getTitle());
    }

    public function testGetColumn()
    {
        $sortableItem = new SortableItem(self::DUMMY_KEY);
        $sortableItem->setColumn(self::DUMMY_COLUMN);
        $this->assertEquals(self::DUMMY_COLUMN, $sortableItem->getColumn());
    }

    public function testGetColumnNotSet()
    {
        $sortableItem = new SortableItem(self::DUMMY_KEY);

        $this->assertEquals(self::DUMMY_KEY, $sortableItem->getColumn());

        $sortableItem = new SortableItem(self::DUMMY_KEY_2);

        $this->assertEquals('modified_at', $sortableItem->getColumn());
    }

    public function testGetTitleNotSet()
    {
        $sortableItem = new SortableItem(self::DUMMY_KEY);

        $this->assertEquals(ucwords(self::DUMMY_KEY), $sortableItem->getTitle());

        $sortableItem = new SortableItem(self::DUMMY_KEY_3);

        $this->assertEquals('Modified At', $sortableItem->getTitle());
    }

    public function testGetTableAlias()
    {
        $sortableItem = new SortableItem(self::DUMMY_KEY);
        $sortableItem->setTableAlias(self::DUMMY_TABLE_ALIAS);

        $this->assertEquals(self::DUMMY_TABLE_ALIAS, $sortableItem->getTableAlias());
    }

    public function testIsSelected()
    {
        $sortableItem = new SortableItem(self::DUMMY_KEY);

        $this->assertEquals(false, $sortableItem->isSelected());

        $sortableItem->setIsSelected(true);

        $this->assertEquals(true, $sortableItem->isSelected());
    }

    public function testGetSortDir()
    {
        $sortableItem = new SortableItem(self::DUMMY_KEY);
        $this->assertEquals(null, $sortableItem->getSortDir());

        $sortableItem->setSortDir('dummy');
        $this->assertEquals(null, $sortableItem->getSortDir());

        $sortableItem->setSortDir('asc');
        $this->assertEquals('asc', $sortableItem->getSortDir());

        $sortableItem->setSortDir('desc');
        $this->assertEquals('desc', $sortableItem->getSortDir());
    }

    public function testGetNewSortDir()
    {
        $sortableItem = new SortableItem(self::DUMMY_KEY);
        $this->assertEquals('asc', $sortableItem->getNewSortDir());

        $sortableItem->setSortDir('asc');
        $this->assertEquals('desc', $sortableItem->getNewSortDir());

        $sortableItem->setSortDir('desc');
        $this->assertEquals('asc', $sortableItem->getNewSortDir());
    }

    public function testGetSortBy()
    {
        $sortableItem = new SortableItem(self::DUMMY_KEY);
        $this->assertEquals(self::DUMMY_KEY, $sortableItem->getSortBy());

        $sortableItem->setTableAlias(self::DUMMY_TABLE_ALIAS);
        $this->assertEquals(self::DUMMY_TABLE_ALIAS.'.'.self::DUMMY_KEY, $sortableItem->getSortBy());
    }

    public function testInvalidKey()
    {
        $this->expectException('\Exception');
        $this->expectExceptionMessage("Sortable item key can not be empty");

        new SortableItem('');
    }
}
