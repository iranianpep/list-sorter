<?php

namespace ListSorter;

class SortableItem
{
    private $model;
    private $alias;
    private $title;
    private $column;

    public function __construct($alias)
    {
        $this->setAlias($alias);
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
     * @param string $alias
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        if (!isset($this->title)) {
            return $this->getAlias();
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
     * @return string
     */
    public function getColumn()
    {
        if (!isset($this->column)) {
            return $this->getAlias();
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
}
