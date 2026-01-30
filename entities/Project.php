<?php 
namespace App\entities;
class Project 
{
    private string $name;
    private string $description;
    private string $start;
    private string $end;
    private int $statusId;
    private int $creatorId;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getStart(): string
    {
        return $this->start;
    }

    public function setStart(string $start): void
    {
        $this->start = $start;
    }

    public function getEnd(): string
    {
        return $this->end;
    }

    public function setEnd(string $end): void
    {
        $this->end = $end;
    }
    public function getStatusId(): int
    {
        return $this->statusId;
    }
    public function setStatusId(int $statusId): void
    {
        $this->statusId = $statusId;
    }
    public function getCreatorId(): int
    {
        return $this->creatorId;
    }
    public function setCreatorId(int $creatorId): void
    {
        $this->creatorId = $creatorId;
    }
}
?>