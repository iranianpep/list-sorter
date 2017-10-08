<?php

declare(strict_types=1);

namespace ListSorter;

use Illuminate\Http\Request;

class ListSorter
{
    const DEFAULT_SORT_BY_KEY = 'by';
    const DEFAULT_SORT_DIR_KEY = 'dir';

    private $request;
    private $sortableItems;
    private $sortByKey;
    private $sortDirKey;
    private $defaultSortBy;
    private $defaultSortDir;

    public function __construct(Request $request, array $sortableItems)
    {
        $this->setRequest($request);
        $this->setSortableItems($sortableItems);
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return array
     */
    public function getSortableItems()
    {
        return $this->sortableItems;
    }

    /**
     * @param array $sortableItems
     *
     * @throws \Exception
     */
    public function setSortableItems(array $sortableItems)
    {
        // validate aliases
        $this->validateSortableItems($sortableItems);

        foreach ($sortableItems as $key => $sortableItem) {
            if (!$sortableItem instanceof SortableItem) {
                $sortableItems[$key] = new SortableItem($sortableItem);
            }
        }

        $this->sortableItems = $sortableItems;
    }

    private function validateSortableItems(array $sortableItems)
    {
        if (empty($sortableItems)) {
            throw new \Exception('Sortable items can not be empty');
        }

        if ($this->areKeysUnique($this->extractKeys($sortableItems)) !== true) {
            throw new \Exception('Sortable item alias must be unique');
        }

        return true;
    }

    private function extractKeys(array $sortableItems)
    {
        $keys = [];
        foreach ($sortableItems as $sortableItem) {
            if (!$sortableItem instanceof SortableItem) {
                $keys[] = $sortableItem;
                continue;
            }

            $keys[] = $sortableItem->getKey();
        }

        return $keys;
    }

    private function areKeysUnique(array $aliases)
    {
        if (count($aliases) === count(array_unique($aliases))) {
            return true;
        }
        return false;
    }

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

    public function setDefaultSortBy($key)
    {
        if (!$this->findSortableItem($key) instanceof SortableItem) {
            throw new \Exception('Invalid sortable item key : '.$key);
        }

        $this->defaultSortBy = $key;
    }

    public function setDefaultSortDir($dir)
    {
        $this->defaultSortDir = $dir;
    }

    public function getDefaultSortDir()
    {
        return $this->defaultSortDir;
    }

    public function getSortBy()
    {
        $selectedSortableItem = $this->getSelectedSortableItem();
        if (!$selectedSortableItem instanceof SortableItem) {
            return;
        }

        return $selectedSortableItem->getSortBy();
    }

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
