<?php


namespace App\Model;


class PagingResult
{
    private $items;
    private $rowCount = 0;
    private $numberPerPage = 10;
    private $pageNumber = 1;

    /**
     * PagingResult constructor.
     */
    public function __construct()
    {
    }



    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param mixed $items
     */
    public function setItems($items): void
    {
        $this->items = $items;
    }

    /**
     * @return mixed
     */
    public function getRowCount()
    {
        return $this->rowCount;
    }

    /**
     * @param mixed $rowCount
     */
    public function setRowCount($rowCount): void
    {
        $this->rowCount = $rowCount;
    }

    /**
     * @return int
     */
    public function getNumberPerPage(): int
    {
        return $this->numberPerPage;
    }

    /**
     * @param int $numberPerPage
     */
    public function setNumberPerPage(int $numberPerPage): void
    {
        $this->numberPerPage = $numberPerPage;
    }

    /**
     * @return int
     */
    public function getPageNumber(): int
    {
        return $this->pageNumber;
    }

    /**
     * @param int $pageNumber
     */
    public function setPageNumber(int $pageNumber): void
    {
        $this->pageNumber = $pageNumber;
    }




}
