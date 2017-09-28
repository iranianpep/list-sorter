<?php

namespace ListSorter;

use PHPUnit\Framework\TestCase;

class SortableItemTest extends TestCase
{
    const DUMMY_ALIAS = 'created';
    const DUMMY_MODEL = 'user';
    const DUMMY_TITLE = 'Created';
    const DUMMY_COLUMN = 'created_at';

    public function testGetAlias()
    {
        $sortableItem = new SortableItem(self::DUMMY_ALIAS);

        $this->assertEquals(self::DUMMY_ALIAS, $sortableItem->getAlias());
    }

    public function testGetModel()
    {
        $sortableItem = new SortableItem(self::DUMMY_ALIAS);
        $sortableItem->setModel(self::DUMMY_MODEL);

        $this->assertEquals(self::DUMMY_MODEL, $sortableItem->getModel());
    }

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
}
