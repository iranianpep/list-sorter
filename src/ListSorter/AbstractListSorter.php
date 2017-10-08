<?php

declare(strict_types=1);

namespace ListSorter;

use Illuminate\Http\Request;

abstract class AbstractListSorter
{
    protected $request;
    protected $sortableItems;

    public function __construct(Request $request, array $sortableItems)
    {
        $this->setRequest($request);
        $this->setSortableItems($sortableItems);
    }

    /**
     * @return string
     */
    abstract public function getSortBy();

    /**
     * @return string
     */
    abstract public function getSortDir();

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

    /**
     * @param array $sortableItems
     *
     * @return bool
     * @throws \Exception
     */
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

    /**
     * @param array $sortableItems
     *
     * @return array
     */
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

    /**
     * @param array $aliases
     *
     * @return bool
     */
    private function areKeysUnique(array $aliases)
    {
        if (count($aliases) === count(array_unique($aliases))) {
            return true;
        }
        return false;
    }
}
