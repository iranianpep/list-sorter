<?php
declare(strict_types=1);

namespace ListSorter;

class SortableItem
{
    private $key;
    private $tableAlias;
    private $column;
    private $title;
    private $isSelected;
    private $sortDir;

    public function __construct($key, $column = '', $tableAlias = '')
    {
        $this->setKey($key);
        $this->setTableAlias($tableAlias);
        $this->setColumn($column);
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param $key
     */
    public function setKey($key)
    {
        if (empty($key)) {
            throw new \Exception('Sortable item key can not be empty');
        }

        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getTableAlias()
    {
        return $this->tableAlias;
    }

    /**
     * @param string $tableAlias
     */
    public function setTableAlias($tableAlias)
    {
        $this->tableAlias = $tableAlias;
    }

    /**
     * @return string
     */
    public function getColumn()
    {
        if (empty($this->column)) {
            // fall back option: replace the spaces with under line
            return strtolower(str_replace(' ', '_', $this->getKey()));
        }

        return $this->column;
    }

    /**
     * @param string $column
     */
    public function setColumn($column)
    {
        $this->column = $column;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        if (empty($this->title)) {
            // fall back option: replace under line with space
            return ucwords(str_replace('_', ' ', $this->getKey()));
        }

        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return bool
     */
    public function isSelected()
    {
        return empty($this->isSelected) ? false : true;
    }

    /**
     * @param bool $isSelected
     */
    public function setIsSelected($isSelected)
    {
        $this->isSelected = $isSelected;
    }

    /**
     * @return string
     */
    public function getSortDir()
    {
        return $this->sortDir;
    }

    /**
     * @param string $sortDir
     */
    public function setSortDir($sortDir)
    {
        if (in_array($sortDir, ['asc', 'desc'])) {
            $this->sortDir = $sortDir;
        }
    }

    /**
     * @return string
     */
    public function getNewSortDir()
    {
        return $this->getSortDir() === 'asc' ? 'desc' : 'asc';
    }

    public function getSortBy()
    {
        $table = $this->getTableAlias();

        if (empty($table)) {
            return $this->getColumn();
        }

        return $table.'.'.$this->getColumn();
    }
}
