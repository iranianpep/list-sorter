<?php

namespace ListSorter;

class SortableItem
{
    private $model;
    private $alias;
    private $column;
    private $title;

    public function __construct($alias, $column = '', $title = '')
    {
        $this->setAlias($alias);
        $this->setColumn($column);
        $this->setTitle($title);
    }

    /**
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param string $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param $alias
     *
     * @throws \Exception
     */
    public function setAlias($alias)
    {
        if (empty($alias)) {
            throw new \Exception('Sortable item alias cannot be empty');
        }

        $this->alias = $alias;
    }

    /**
     * @return string
     */
    public function getColumn()
    {
        if (empty($this->column)) {
            // fall back option: replace the spaces with under line
            return strtolower(str_replace(' ', '_', $this->getAlias()));
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
            return ucwords(str_replace('_', ' ', $this->getColumn()));
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
}
