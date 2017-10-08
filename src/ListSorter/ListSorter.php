<?php

declare(strict_types=1);

namespace ListSorter;

use Illuminate\Http\Request;

class ListSorter extends AbstractListSorter
{
    const DEFAULT_SORT_BY_KEY = 'by';
    const DEFAULT_SORT_DIR_KEY = 'dir';

    private $sortByKey;
    private $sortDirKey;
    private $defaultSortBy;
    private $defaultSortDir;

    /**
     * @return string
     */
    public function getSortByKey()
    {
        if (!isset($this->sortByKey)) {
            return self::DEFAULT_SORT_BY_KEY;
        }

        return $this->sortByKey;
    }

    /**
     * @param string $sortByKey
     */
    public function setSortByKey($sortByKey)
    {
        $this->sortByKey = $sortByKey;
    }

    /**
     * @return string
     */
    public function getSortDirKey()
    {
        if (!isset($this->sortDirKey)) {
            return self::DEFAULT_SORT_DIR_KEY;
        }

        return $this->sortDirKey;
    }

    /**
     * @param string $sortDirKey
     */
    public function setSortDirKey($sortDirKey)
    {
        $this->sortDirKey = $sortDirKey;
    }

    /**
     * @param $key
     *
     * @return bool|SortableItem
     */
    private function findSortableItem($key)
    {
        foreach ($this->getSortableItems() as $sortableItem) {
            if ($sortableItem->getKey() === $key) {
                return $sortableItem;
            }
        }

        return false;
    }

    /**
     * @return bool|SortableItem|void
     */
    public function getSelectedSortableItem()
    {
        $key = $this->getRequest()->input($this->getSortByKey());
        $sortableItem = $this->findSortableItem($key);

        if (empty($sortableItem)) {
            $sortableItem = $this->findSortableItem($this->getDefaultSortBy());
        }

        if (!$sortableItem instanceof SortableItem) {
            return;
        }

        $dir = $this->getRequest()->input($this->getSortDirKey());
        $sortableItem->setSortDir($dir);
        $sortableItem->setIsSelected(true);

        return $sortableItem;
    }

    /**
     * @return string
     */
    public function getDefaultSortBy()
    {
        return $this->defaultSortBy;
    }

    /**
     * @param $key
     *
     * @throws \Exception
     */
    public function setDefaultSortBy($key)
    {
        if (!$this->findSortableItem($key) instanceof SortableItem) {
            throw new \Exception('Invalid sortable item key : '.$key);
        }

        $this->defaultSortBy = $key;
    }

    /**
     * @param $dir
     */
    public function setDefaultSortDir($dir)
    {
        $this->defaultSortDir = $dir;
    }

    /**
     * @return string
     */
    public function getDefaultSortDir()
    {
        return $this->defaultSortDir;
    }

    /**
     * @return string|void
     */
    public function getSortBy()
    {
        $selectedSortableItem = $this->getSelectedSortableItem();
        if (!$selectedSortableItem instanceof SortableItem) {
            return;
        }

        return $selectedSortableItem->getSortBy();
    }

    /**
     * @return string|void
     */
    public function getSortDir()
    {
        $selectedSortableItem = $this->getSelectedSortableItem();
        if (!$selectedSortableItem instanceof SortableItem) {
            return;
        }

        $sortDir = $selectedSortableItem->getSortDir();

        if (empty($sortDir)) {
            return $this->getDefaultSortDir();
        }

        return $sortDir;
    }
}
