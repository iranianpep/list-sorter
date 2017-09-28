<?php

namespace ListSorter;

class ListSorter
{
    private $request;
    private $listSortableItems;
    private $sortByKey = 'by';
    private $sortDirKey = 'dir';
    private $defaultSortBy;
    private $defaultSortDir;

    public function __construct($request, array $listSortableItems)
    {
        $this->setRequest($request);
        $this->setSortableItems($listSortableItems);
    }

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param mixed $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }

    /**
     * @return array
     */
    public function getSortableItems()
    {
        return $this->listSortableItems;
    }

    /**
     * @param array $listSortableItems
     */
    public function setSortableItems(array $listSortableItems)
    {
        $this->listSortableItems = $listSortableItems;
    }

    /**
     * @return string
     */
    public function getSortByKey()
    {
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

    public function getSortDir()
    {
        $sortDir = $this->getRequest()->input($this->getSortDirKey());
        return in_array($sortDir, ['asc', 'desc']) ? $sortDir : $this->getDefaultSortDir();
    }

    public function getNewSortDir()
    {
        return $this->getSortDir() === 'asc' ? 'decs' : 'asc';
    }

    public function getSortBy()
    {
        $sortBy = $this->getRequest()->input($this->getSortByKey());
        return in_array($sortBy, array_keys($this->getSortableItems())) ? $sortBy : $this->getDefaultSortBy();
    }
}
