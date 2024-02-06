<?php

namespace App\Entity\DTO;

use DateTime;

class TableDTO
{
    public string $tabname ="";
    public ?string $owner ="";
    public ?string $dirpath ="";
    public int $tabid;
    public int $rowsize;
    public int $ncols;
    public int $nindexes;
    public int $nrows;
    public DateTime $created;
    public int $version;
    public ?string $tabtype ="";
    public ?string $audpath ="";

    /**
     * @var ColumnDTO[] $columns
     */
    public array $columns = [];

    /**
     * @var DependOnDTO[] $depends_on
     */
    public array $depends_on = [];

    /**
     * @var IndexDTO[] $indexes
     */
    public array $indexes = [];

    /**
     * @var ViewDTO[] $view
     */
    public array $view = [];
    public string $viewsql;

    /**
     * @var DetailDTO[] $details
     */
    public array $details = [];
}