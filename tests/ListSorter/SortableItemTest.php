<?php

namespace ListSorter;

use PHPUnit\Framework\TestCase;

class SortableItemTest extends TestCase
{
    const DUMMY_ALIAS = 'created';
    const DUMMY_ALIAS_2 = 'Modified At';
    const DUMMY_ALIAS_3 = 'modified_at';
    const DUMMY_MODEL = 'user';
    const DUMMY_TITLE = 'Created';
    const DUMMY_COLUMN = 'created_at';

    public function testGetTitle()
    {
        $sortableItem = new SortableItem(self::DUMMY_ALIAS);
        $sortableItem->setTitle(self::DUMMY_TITLE);

        $this->assertEquals(self::DUMMY_TITLE, $sortableItem->getTitle());
    }

    public function testGetColumn()
    {
        $sortableItem = new SortableItem(self::DUMMY_ALIAS);
        $sortableItem->setColumn(self::DUMMY_MODEL);

        $this->assertEquals(self::DUMMY_MODEL, $sortableItem->getColumn());
    }

    public function testGetColumnNotSet()
    {
        $sortableItem = new SortableItem(self::DUMMY_ALIAS);

        $this->assertEquals(self::DUMMY_ALIAS, $sortableItem->getColumn());

        $sortableItem = new SortableItem(self::DUMMY_ALIAS_2);

        $this->assertEquals('modified_at', $sortableItem->getColumn());
    }

    public function testGetTitleNotSet()
    {
        $sortableItem = new SortableItem(self::DUMMY_ALIAS);

        $this->assertEquals(ucwords(self::DUMMY_ALIAS), $sortableItem->getTitle());

        $sortableItem = new SortableItem(self::DUMMY_ALIAS_3);

        $this->assertEquals('Modified At', $sortableItem->getTitle());
    }
}
