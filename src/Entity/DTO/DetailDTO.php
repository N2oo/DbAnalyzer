<?php

namespace App\Entity\DTO;

use DateTime;

class DetailDTO
{

    public int $inode;
    public int $other;
    public string $permisions;
    public int $cntlink;
    public string $file_owner;
    public string $filegroup;
    public int $filesize;
    public DateTime $date;
    public DateTime $time;
    public int $other2;
    public string $file_location;
    public string $folder;
    public string $filename;
    public string $file_extension;

    /**
     * @var UserDTO[] $users
     */
    public array $users=  [];
}