<?php
namespace App\entities;
class Task
{
    private string $description;
    private string $start;
    private string $end;
    private int $statusId;
    private int $projectId;

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
    public function getProjectId(): int
    {
        return $this->projectId;
    }
    public function setProjectId(int $projectId): void
    {
        $this->projectId = $projectId;
    }
}


?>