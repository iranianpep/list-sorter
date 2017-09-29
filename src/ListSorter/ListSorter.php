<?php

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
     */
    public function setSortableItems(array $sortableItems)
    {
        // validate aliases
        if ($this->validateSortableItems($sortableItems) === true) {
            $this->sortableItems = $sortableItems;
        }
    }

    /**
     * @param array $sortableItems
     *
     * @throws \Exception
     *
     * @return bool
     */
    private function validateSortableItems(array $sortableItems)
    {
        if (empty($sortableItems)) {
            throw new \Exception('Sortable items must not be empty');
        }

        if ($this->areAliasesUnique($this->extractAliases($sortableItems)) !== true) {
            throw new \Exception('Sortable item alias must be unique');
        }

        return true;
    }

    /**
     * Extract aliases out of sortable items
     *
     * @param array $sortableItems
     *
     * @return array
     * @throws \Exception
     */
    private function extractAliases(array $sortableItems)
    {
        $aliases = [];
        foreach ($sortableItems as $sortableItem) {
            if (!$sortableItem instanceof SortableItem) {
                throw new \Exception('Invalid sortable item');
            }

            $aliases[] = $sortableItem->getAlias();
        }

        return $aliases;
    }

    /**
     * Check to see whether aliases are unique or not
     *
     * @param array $aliases
     *
     * @return bool
     */
    private function areAliasesUnique(array $aliases)
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
     * @return string
     */
    public function getDefaultSortBy()
    {
        return $this->defaultSortBy;
    }

    /**
     * @param string $defaultSortBy
     */
    public function setDefaultSortBy($defaultSortBy)
    {
        $this->defaultSortBy = $defaultSortBy;
    }

    /**
     * @return string
     */
    public function getDefaultSortDir()
    {
        return $this->defaultSortDir;
    }

    /**
     * @param string $defaultSortDir
     */
    public function setDefaultSortDir($defaultSortDir)
    {
        $this->defaultSortDir = $defaultSortDir;
    }

    /**
     * @return string
     */
    public function getSortDir()
    {
        $sortDir = $this->getRequest()->input($this->getSortDirKey());

        return in_array($sortDir, ['asc', 'desc']) ? $sortDir : $this->getDefaultSortDir();
    }

    /**
     * @return string
     */
    public function getNewSortDir()
    {
        return $this->getSortDir() === 'asc' ? 'desc' : 'asc';
    }

    /**
     * @return string
     */
    public function getSortBy()
    {
        $sortBy = $this->getRequest()->input($this->getSortByKey());

        return in_array($sortBy, array_keys($this->getSortableItems())) ? $sortBy : $this->getDefaultSortBy();
    }
}
