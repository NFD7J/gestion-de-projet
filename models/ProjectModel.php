<?php 
namespace App\models;

use Exception;
use App\entities\Project;
use App\core\Dbconnect;
use App\entities\Task;
use App\entities\Message;

class ProjectModel extends Dbconnect
{
    /*=====================================================*/
    /*===================== projet ========================*/
    /*=====================================================*/
    public function add(Project $project)
    {
        $this->request = $this->connection->prepare("INSERT INTO project (name,description,start_date,end_date,id_status,creator_id) VALUES (:name, :description, :start, :end, :status_id, :creator_id)");
        $this->request->bindValue(':name', $project->getName());
        $this->request->bindValue(':description', $project->getDescription());
        $this->request->bindValue(':start', $project->getStart());
        $this->request->bindValue(':end', $project->getEnd());
        $this->request->bindValue(':status_id', $project->getStatusId());
        $this->request->bindValue(':creator_id', $project->getCreatorId());
        $this->executeTryCatch();

        $lastid = $this->connection->lastInsertId();
        $this->add_user($project->getCreatorId(), intval($lastid));
    }

    public function delete(int $id)
    {
        $this->request = $this->connection->prepare("DELETE FROM project WHERE id = :id");
        $this->request->bindValue(':id', $id);
        $this->executeTryCatch();
    }

    public function modif(Project $project, int $id)
    {
        $this->request = $this->connection->prepare("UPDATE project SET name = :name, description = :description, start_date = :start, end_date = :end, id_status = :status_id, creator_id = :creator_id WHERE id_project = :id");
        $this->request->bindValue(':name', $project->getName());
        $this->request->bindValue(':description', $project->getDescription());
        $this->request->bindValue(':start', $project->getStart());
        $this->request->bindValue(':end', $project->getEnd());
        $this->request->bindValue(':status_id', $project->getStatusId());
        $this->request->bindValue(':creator_id', $project->getCreatorId());
        $this->request->bindValue(':id', $id);
        $this->executeTryCatch();
    }

    public function add_user(int $userId, int $projectId)
    {
        $this->request = $this->connection->prepare("INSERT INTO contient (id_user, id_project) VALUES (:user_id, :project_id)");
        $this->request->bindValue(':user_id', $userId);
        $this->request->bindValue(':project_id', $projectId);
        $this->executeTryCatch();
    }

    public function remove_user(int $userId, int $projectId)
    {
        $this->request = $this->connection->prepare("DELETE FROM contient WHERE id_user = :user_id AND id_project = :project_id");
        $this->request->bindValue(':user_id', $userId);
        $this->request->bindValue(':project_id', $projectId);
        $this->executeTryCatch();
    }

    public function editProjectDate(int $projectId, string $dateType, string $dateValue)
    {
        if ($dateType === 'start_date') {
            $this->request = $this->connection->prepare("UPDATE project SET start_date = :date_value WHERE id_project = :project_id");
        } elseif ($dateType === 'end_date') {
            $this->request = $this->connection->prepare("UPDATE project SET end_date = :date_value WHERE id_project = :project_id");
        }
        $this->request->bindValue(':date_value', $dateValue);
        $this->request->bindValue(':project_id', $projectId);
        $this->executeTryCatch();
    }

    public function getAllProjects()
    {
        $this->request = $this->connection->prepare("SELECT p.*, COUNT(c.id_user) as participant_count FROM project p JOIN contient c ON p.id_project = c.id_project WHERE c.id_user = :user_id GROUP BY p.id_project");
        $this->request->bindValue(':user_id', $_SESSION["user"]["id"]);
        $this->request->execute();
        return $this->request->fetchAll();
    }

    public function getProject(int $id)
    {
        $this->request = $this->connection->prepare("SELECT p.*, s.libelle as libelle FROM project p JOIN status s ON p.id_status = s.id_status WHERE id_project = :id");
        $this->request->bindValue(':id', $id);
        $this->request->execute();
        return $this->request->fetch();
    }

    public function getProjectTasks(int $projectId)
    {
        $this->request = $this->connection->prepare("SELECT * FROM task WHERE id_project = :project_id");
        $this->request->bindValue(':project_id', $projectId);
        $this->request->execute();
        return $this->request->fetchAll();
    }


    public function getProjectCollaborators(int $projectId)
    {
        $this->request = $this->connection->prepare("SELECT u.* FROM user u JOIN contient c ON u.id_user = c.id_user WHERE c.id_project = :project_id");
        $this->request->bindValue(':project_id', $projectId);
        $this->request->execute();
        return $this->request->fetchAll();
    }

    /*=====================================================*/
    /*===================== Tâches ========================*/
    /*=====================================================*/
    public function add_task(Task $task, int $projectId)
    {
        $this->request = $this->connection->prepare("INSERT INTO task (id_project,description,start_date,end_date,id_status) VALUES (:project_id, :description, :start, :end, :status_id)");
        $this->request->bindValue(':project_id', $projectId);
        $this->request->bindValue(':description', $task->getDescription());
        $this->request->bindValue(':start', $task->getStart());
        $this->request->bindValue(':end', $task->getEnd());
        $this->request->bindValue(':status_id', $task->getStatusId());
        $this->executeTryCatch();
    }

     public function updateTask(Task $task, int $taskId)
    {
        $this->request = $this->connection->prepare("UPDATE task SET description = :description, start_date = :start, end_date = :end, id_status = :status_id WHERE id_task = :task_id");
        $this->request->bindValue(':description', $task->getDescription());
        $this->request->bindValue(':start', $task->getStart());
        $this->request->bindValue(':end', $task->getEnd());
        $this->request->bindValue(':status_id', $task->getStatusId());
        $this->request->bindValue(':task_id', $taskId);
        $this->executeTryCatch();
    }

    public function remove_task(int $taskId)
    {
        $this->request = $this->connection->prepare("DELETE FROM task WHERE id_task = :task_id");
        $this->request->bindValue(':task_id', $taskId);
        $this->executeTryCatch();
    }

    public function addUserToTask(int $userId, int $taskId)
    {
        $this->request = $this->connection->prepare("INSERT INTO execute (id_user, id_task) VALUES (:user_id, :task_id)");
        $this->request->bindValue(':user_id', $userId);
        $this->request->bindValue(':task_id', $taskId);
        $this->executeTryCatch();
    }

    public function addUserToProject(int $userId, int $projectId)
    {
        $this->request = $this->connection->prepare("INSERT INTO contient (id_user, id_project) VALUES (:user_id, :project_id)");
        $this->request->bindValue(':user_id', $userId);
        $this->request->bindValue(':project_id', $projectId);
        $this->executeTryCatch();
    }

    public function removeUserFromProject(int $userId, int $projectId)
    {
        $this->request = $this->connection->prepare("DELETE FROM contient WHERE id_user = :user_id AND id_project = :project_id");
        $this->request->bindValue(':user_id', $userId);
        $this->request->bindValue(':project_id', $projectId);
        $this->executeTryCatch();
    }

    public function getUserFromEmail(string $email)
    {
        $this->request = $this->connection->prepare("SELECT * FROM user WHERE email = :email");
        $this->request->bindValue(':email', $email);
        $this->request->execute();
        return $this->request->fetch();
    }

    public function getUsersFromTask(int $taskId)
    {
        $this->request = $this->connection->prepare("SELECT u.* FROM user u JOIN execute e ON u.id_user = e.id_user WHERE e.id_task = :task_id");
        $this->request->bindValue(':task_id', $taskId);
        $this->request->execute();
        return $this->request->fetchAll();
    }

    public function getTask(int $taskId)
    {
        $this->request = $this->connection->prepare("SELECT * FROM task WHERE id_task = :task_id");
        $this->request->bindValue(':task_id', $taskId);
        $this->request->execute();
        return $this->request->fetch();
    }

    public function getAllStatuses()
    {
        $this->request = $this->connection->prepare("SELECT * FROM status");
        $this->request->execute();
        return $this->request->fetchAll();
    }

    /*=====================================================*/
    /*======================messages ======================*/
    /*=====================================================*/
    public function getProjectMessages(int $projectId)
    {
        $this->request = $this->connection->prepare("SELECT m.*, u.nom FROM message m JOIN user u ON m.id_user = u.id_user WHERE m.id_project = :project_id ORDER BY m.date ASC");
        $this->request->bindValue(':project_id', $projectId);
        $this->request->execute();
        return $this->request->fetchAll();
    }

    public function addProjectMessage(Message $message)
    {
        $this->request = $this->connection->prepare("INSERT INTO message (id_project, id_user, content) VALUES (:project_id, :user_id, :content)");
        $this->request->bindValue(':project_id', $message->getProjectId());
        $this->request->bindValue(':user_id', $message->getUserId());
        $this->request->bindValue(':content', $message->getContent());
        $this->executeTryCatch();
    }

    public function removeMessage(int $messageId)
    {
        $this->request = $this->connection->prepare("DELETE FROM message WHERE id_message = :message_id");
        $this->request->bindValue(':message_id', $messageId);
        $this->executeTryCatch();
    }

    //exécuter la requête avec gestion des erreurs
    private function executeTryCatch()
    {
        try{
            $this->request->execute();
        }catch(Exception $e){
            die("Erreur : ".$e->getMessage());
        }
        $this->request->closeCursor();
    }

    public function getLastId()
    {
        return $this->connection->lastInsertId();
    }
}
?>