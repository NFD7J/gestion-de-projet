<?php
namespace App\entities;
class Message
{
    private string $content;
    private string $date;
    private int $userId;
    private int $projectId;

    public function getContent(): string
    {
        return $this->content;
    }
    public function setContent(string $content): void
    {
        $this->content = $content;
    }
    public function getdate(): string
    {
        return $this->date;
    }
    public function setdate(string $date): void
    {
        $this->date = $date;
    }
    public function getUserId(): int
    {
        return $this->userId;
    }
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
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