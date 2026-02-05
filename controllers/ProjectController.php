<?php
namespace App\controllers;
use App\entities\Project;
use App\models\ProjectModel;
use App\entities\Task;
use App\entities\Message;

class ProjectController extends Controller
{
    /*=============== dashboard ===============*/
    public function index()
    {
        $projects = new ProjectModel();
        $projects = $projects->getAllProjects();
        $this->render('project/index' , ['projects' => $projects]);
    }

    /*=====================================*/
    /*=============== projet ===============*/
    /*=====================================*/
    public function add()
    {
        if(isset($_POST["name"]) && isset($_POST["description"]) && isset($_POST["start_date"]) && isset($_POST["end_date"]) && isset($_POST["status_id"])){

            if(!empty($_POST["name"]) && !empty($_POST["description"]) && !empty($_POST["start_date"]) && !empty($_POST["end_date"]) && !empty($_POST["status_id"])){
                $project = new Project();
                $project->setName($_POST["name"]);
                $project->setDescription($_POST["description"]);
                $project->setStart($_POST["start_date"]);
                $project->setEnd($_POST["end_date"]);
                $project->setStatusId(intval($_POST["status_id"]));
                $project->setCreatorId($_SESSION["user"]["id"]);

                $projectModel = new ProjectModel();
                $projectModel->add($project);
                header("location: index.php?controller=project");
            }else{
                $error = "Problème lors de l'ajout du projet";
                $statuses = new ProjectModel();
                $statuses = $statuses->getAllStatuses();
                $this->render("project/createproject", ["error" => $error, 'statuses' => $statuses]);
            }
        }else{
            $statuses = new ProjectModel();
            $statuses = $statuses->getAllStatuses();
            $this->render('project/createproject' , ['statuses' => $statuses]);
        }
    }

    public function deleteProject()
    {
        $id = intval($_POST["project_id"]) ?? header("location: index.php?controller=project");
        $projectModel = new ProjectModel();
        $projectModel->delete($id);
        header("location: index.php?controller=project");
        exit();
    }

    public function openProject($id)
    {
        $id = $id["id"];
        $projectModel = new ProjectModel();
        $project = $projectModel->getProject(intval($id));
        $tasks = $projectModel->getProjectTasks(intval($id));
        $collaborateurs = $projectModel->getProjectCollaborators(intval($id));
        $collaborateurs = $collaborateurs ?? [];
        $this->render('project/openProject' , ['project' => $project, 'tasks' => $tasks, "collaborators" => $collaborateurs]);
    }

    public function editDate()
    {
        if(isset($_POST["id_project"]) && isset($_POST["date_type"]) && isset($_POST["date"])){
            if(!empty($_POST["id_project"]) && !empty($_POST["date_type"]) && !empty($_POST["date"])){
                $projectModel = new ProjectModel();
                $projectModel->editProjectDate(intval($_POST["id_project"]), $_POST["date_type"], $_POST["date"]);
            }
        }
        header("location: index.php?controller=project&action=openProject&id=" . intval($_POST["id_project"]));
    }

    public function addCollaborator()
    {
        if(isset($_POST["email"]) && isset($_POST["project_id"])){
            if(!empty($_POST["email"]) && !empty($_POST["project_id"])){
                $projectModel = new ProjectModel();
                $user = $projectModel->getUserFromEmail($_POST["email"]);
                if($user !== false){
                    $userId = $user->id_user;
                    $projectModel->addUserToProject(intval($userId), intval($_POST["project_id"]));
                }
            }
        }
        header("location: index.php?controller=project&action=openProject&id=" . intval($_POST["project_id"]));
    }

    public function removeCollaborator()
    {
        if(isset($_POST["user_id"]) && isset($_POST["project_id"])){
            if(!empty($_POST["user_id"]) && !empty($_POST["project_id"])){
                $projectModel = new ProjectModel();
                $projectModel->removeUserFromProject(intval($_POST["user_id"]), intval($_POST["project_id"]));
            }
        }
        header("location: index.php?controller=project&action=openProject&id=" . intval($_POST["project_id"]));
    }

    public function modifyProject()
    {
        if(isset($_POST["id_project"]) && isset($_POST["name"]) && isset($_POST["description"]) && isset($_POST["start"]) && isset($_POST["end"]) && isset($_POST["id_status"]) && isset($_POST["creator_id"])){
            if(!empty($_POST["id_project"]) && !empty($_POST["name"]) && !empty($_POST["description"]) && !empty($_POST["start"]) && !empty($_POST["end"]) && !empty($_POST["id_status"]) && !empty($_POST["creator_id"])){
                $project = new Project();
                $project->setName($_POST["name"]);
                $project->setDescription($_POST["description"]);
                $project->setStart($_POST["start"]);
                $project->setEnd($_POST["end"]);
                $project->setStatusId($_POST["id_status"]);
                $project->setCreatorId($_POST["creator_id"]);


                $projectModel = new ProjectModel();
                $projectModel->modif($project, intval($_POST["id_project"]));
            }
        }
        header("location: index.php?controller=project&action=openProject&id=" . intval($_POST["id_project"]));
    }

    /*=====================================*/
    /*=============== tâche ===============*/
    /*=====================================*/
    public function addTask($id)
    {
        if(isset($_POST["description"]) && isset($_POST["id_status"]) && isset($_POST["id_project"])){
            if(!empty($_POST["description"]) && !empty($_POST["id_status"]) && !empty($_POST["id_project"])){
                $task = new Task();
                if(!empty($_POST["start"]) && !empty($_POST["end"])){
                    if(strtotime($_POST["end"]) < strtotime($_POST["start"])){
                        $error = "La date de fin doit être postérieure à la date de début.";
                        $collaborateurs = new ProjectModel();
                        $collaborateurs = $collaborateurs->getProjectCollaborators(intval($id['id']));
                        $this->render('project/addTask', ['collaborateurs' => $collaborateurs, 'error' => $error], ["id" => $id]);
                        exit();
                    }
                    $task->setStart($_POST["start"]);
                    $task->setEnd($_POST["end"]);
                }else{
                    $task->setStart(0);
                    $task->setEnd(0);
                }
                $task->setDescription($_POST["description"]);
                $task->setStatusId(intval($_POST["id_status"]));
                $task->setProjectId(intval($_POST["id_project"]));

                $projectModel = new ProjectModel();
                $projectModel->add_task($task, intval($_POST["id_project"]));

                if(!empty($_POST["users"])){
                    $lastid = $projectModel->getLastId();
                    foreach($_POST["users"] as $userId){
                        $projectModel->addUserToTask(intval($userId), intval($lastid));
                    }
                }
                header("location: index.php?controller=project&action=openProject&id=" . intval($_POST["id_project"]));
            }else{
                $error = "Problème lors de l'ajout de la tâche";
                $collaborateurs = new ProjectModel();
                $collaborateurs = $collaborateurs->getProjectCollaborators(intval($id['id']));
                $this->render('project/addTask', ['collaborateurs' => $collaborateurs, "error" => $error, "id" => $id]);
            }
        }else{
            $collaborateurs = new ProjectModel();
            $collaborateurs = $collaborateurs->getProjectCollaborators(intval($id['id']));
            $this->render('project/addTask', ['collaborateurs' => $collaborateurs, "id" => $id]);
        }
    }

    public function deleteTask($get)
    {
        $id = $get["id"][1];
        $projectModel = new ProjectModel();
        $projectModel->remove_task(intval($id));
        header("location: index.php?controller=project&action=openProject&id=" . intval($get["id"][0]));
    }

    public function editTask($get)
    {
        if(isset($_POST["description"]) && isset($_POST["id_status"]) && isset($_POST["id_project"]) && isset($_POST["id_project"])){
            if(!empty($_POST["description"]) && !empty($_POST["id_status"]) && !empty($_POST["id_project"]) && !empty($_POST["id_task"])){
                $task = new Task();
                if(!empty($_POST["start_date"]) && !empty($_POST["end_date"])){
                    $task->setStart($_POST["start_date"]);
                    $task->setEnd($_POST["end_date"]);
                }else{
                    $task->setStart(0);
                    $task->setEnd(0);
                }
                $task->setDescription($_POST["description"]);
                $task->setStatusId(intval($_POST["id_status"]));
                $task->setProjectId(intval($_POST["id_project"]));

                $projectModel = new ProjectModel();
                $projectModel->updateTask($task, intval($_POST["id_task"]));

                header("location: index.php?controller=project&action=openProject&id=" . intval($_POST["id_project"]));
            }else{
                $error = "Problème lors de la modification de la tâche";
                $projectModel = new ProjectModel();
                $task = $projectModel->getTask(intval($get["id"][1]));
                $userTask = $projectModel->getUsersFromTask(intval($get["id"][1]));
                $this->render('project/editTask', ['task' => $task, 'assignedUsers' => $userTask, 'collaborateurs' => $projectModel->getProjectCollaborators(intval($get["id"][0])), 'error' => $error]);
            }
        }else{
            $projectModel = new ProjectModel();
            $task = $projectModel->getTask(intval($get["id"][1]));
            $userTask = $projectModel->getUsersFromTask(intval($get["id"][1]));
            $this->render('project/editTask', ['task' => $task, 'assignedUsers' => $userTask, 'collaborateurs' => $projectModel->getProjectCollaborators(intval($get["id"][0]))]);
        }
    }

    /*=====================================*/
    /*=============== chat ================*/
    /*=====================================*/
    public function chat($get)
    {
        $id = $get["id"];
        $projectModel = new ProjectModel();

        if(isset($_POST['content']) && !empty($_POST['content'])) {
            $message = new Message();
            $message->setProjectId(intval($id));
            $message->setUserId($_SESSION['user']['id']);
            $message->setContent($_POST['content']);
            $projectModel->addProjectMessage($message);
        }
        $project = $projectModel->getProject(intval($id));
        $messages = $projectModel->getProjectMessages(intval($id));
        $this->render('project/chat', ['project' => $project, 'messages' => $messages]);
    }

    public function deleteMessage($get)
    {
        $id = $get["id"][1];
        $projectModel = new ProjectModel();
        $projectModel->removeMessage(intval($id));
        header("location: index.php?controller=project&action=chat&id=" . intval($get["id"][0]));
    }
}