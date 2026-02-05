<?php $title = $project->name ?>
<?php 
$interval = strtotime($project->end_date) - strtotime($project->start_date);
$max = strtotime($project->end_date);
$min = strtotime($project->start_date);
$now = time();
if($project->end_date =='0000-00-00' || $project->start_date == '0000-00-00') {
    $progression = 0;
} else {
    $progression = ($now - $min) / ($max - $min) * 100;
    if($progression < 0) {
        $progression = 0;
    } elseif ($progression > 100) {
        $progression = 100;
    }
}
?>
<!-- sidebar collaborateurs -->
<aside class="project-sidebar">

    <!-- Bouton ajouter un collaborateur -->
    <div class="sidebar-header">
        <h3>👥 Collaborateurs</h3>

        <a href="#" id="openUserModal"
        class="btn-add-collab"
        title="Ajouter un collaborateur">
            +
        </a>
    </div>
    <a href="index.php?controller=project&action=chat&id=<?= $project->id_project ?>" class="btn-chat">💬 Discussion</a>

    <!-- Liste des collaborateurs -->
    <ul class="collaborators">
        <?php foreach ($collaborators as $collaborator): ?>
            <li class="collaborator" data-user-id="<?= $collaborator->id_user ?>">
                <span class="avatar">
                    <?= strtoupper(substr($collaborator->nom, 0, 1)) ?>
                </span>
                <span><?= $collaborator->nom ?></span>
            </li>
        <?php endforeach; ?>
    </ul>
</aside>

<!-- Contenu principal du projet -->
<section class="project-page">

    <!-- Header projet -->
    <div class="project-header">
        <div>
            <h1 class="title"><?= $project->name ?></h1>
            <p class="project-desc"><?= $project->description ?></p>
        </div>

        <div class="project-actions">
            <a href="index.php?controller=project&action=addTask&id=<?= $project->id_project ?>" class="btn-outline">+ Ajouter une tâche</a>
            <?php if($project->creator_id == $_SESSION['user']["id"]): ?>
                <a href="" class="btn-danger" id="btnDeleteProject">supprimer Projet</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Infos projet -->
    <div class="project-info">
        <div class="info-box info-date" style="cursor: pointer;" data-date-type="start_date" data-current-date="<?= $project->start_date ?>">
            <span>Date début</span>
            <strong><?= $project->start_date ?></strong>
        </div>

        <div class="info-box info-date" style="cursor: pointer;" data-date-type="end_date" data-current-date="<?= $project->end_date ?>">
            <span>Date fin</span>
            <strong><?= $project->end_date ?></strong>
        </div>

        <div class="info-box">
            <span>Statut : </span><br>
            <strong class="status active"><?= $project->libelle ?></strong>
        </div>

        <div class="info-box">
            <span>Progression</span>
            <div class="progress">
                <div class="progress-bar" style="width: <?= $progression ?>%"></div>
            </div>
        </div>
    </div>

    <!-- Board Kanban -->
    <div class="kanban">

        <!-- Colonne -->
        <div class="column">
            <h3>📌 À faire</h3>

            <?php foreach ($tasks as $task):?> 
                <?php if ($task->id_status == 1): ?>
                    <div class="task" data-task-id="<?= $task->id_task ?>">
                        <h4><?= $task->description ?></h4>
                        <small>Start : <?= $task->start_date ?></small><br>
                    </div>
                <?php endif;?>
            <?php endforeach; ?>
        </div>

        <!-- Colonne -->
        <div class="column">
            <h3>⚙️ En cours</h3>

            <?php foreach ($tasks as $task):?> 
                <?php if ($task->id_status == 2): ?>
                    <div class="task" data-task-id="<?= $task->id_task ?>">
                        <h4><?= $task->description ?></h4>
                        <small>Deadline : <?= $task->end_date ?></small>
                    </div>
                <?php endif;?>
            <?php endforeach; ?>
        </div>

        <!-- Colonne -->
        <div class="column">
            <h3>✅ Terminé</h3>

            <?php foreach ($tasks as $task):?> 
                <?php if ($task->id_status == 3): ?>
                    <div class="task" data-task-id="<?= $task->id_task ?>">
                        <h4><?= $task->description ?></h4>
                        <small>Start : <?= $task->start_date ?></small><br>
                        <small>End : <?= $task->end_date ?></small>
                    </div>
                <?php endif;?>
            <?php endforeach; ?>
        </div>

    </div>

    <!-- Historique / activité -->
    <div class="activity">
        <h3>🕒 Activité récente</h3>

        <ul>
            <li>Sarah a terminé "Initialisation Git"</li>
            <li>Tom a rejoint le projet</li>
            <li>Alice a créé une tâche</li>
        </ul>
    </div>
</section>

<!-- popup ajouter un collaborateur -->
<div id="userModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h3>Ajouter un collaborateur</h3>

        <form action="index.php?controller=project&action=addCollaborator" method="POST" class="user-form">
            <label for="email">Email du collaborateur</label>
            <input type="email" id="email" name="email" placeholder="exemple@domaine.com" required>
            <input type="hidden" name="project_id" value="<?= $project->id_project ?>">
            <div class="form-actions">
                <button type="submit" class="btn-primary">Ajouter</button>
                <button type="button" class="btn-outline" id="cancelModal">Annuler</button>
            </div>
        </form>
    </div>
</div>

<!-- popup supprimer un collaborateur -->
<div id="deleteUserModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h3>Supprimer le collaborateur</h3>
        <p>Êtes-vous sûr de vouloir supprimer ce collaborateur du projet ?</p>

        <form id="deleteUserForm" method="POST" action="index.php?controller=project&action=removeCollaborator">
            <input type="hidden" name="user_id" id="deleteUserId">
            <input type="hidden" name="project_id" value="<?= $project->id_project ?>">
            <div class="form-actions">
                <button type="submit" class="btn-danger">Oui, supprimer</button>
                <button type="button" class="btn-outline" id="cancelDelete">Annuler</button>
            </div>
        </form>
    </div>
</div>

<!-- Menu contextuel pour les tâches -->
<ul id="contextMenu" class="context-menu">
    <li><a data-base-href="index.php?controller=project&action=editTask&id[]=<?= $project->id_project ?>&id[]=" href="#">✏️ Éditer</a></li>
    <li><a data-base-href="index.php?controller=project&action=deleteTask&id[]=<?= $project->id_project ?>&id[]=" href="#">🗑️ Supprimer</a></li>
    <li><a data-base-href="index.php?controller=project&action=Task&id[]=<?= $project->id_project ?>&id[]=" href="#">ℹ️ Détails</a></li>
</ul>

<!-- popup modif dates -->
<div id="dateModal" class="modal-overlay">

    <div class="modal-date">
        <h3>📅 Modifier la date</h3>

        <form action="index.php?controller=project&action=editDate" method="POST" id="dateForm">
            <input type="hidden" name="id_project" id="modalProjectId" value="<?= $project->id_project ?>">
            <input type="hidden" name="date_type" id="dateType">

            <label>Nouvelle date</label>
            <input type="date" name="date" required>

            <div class="modal-actions">
                <button type="submit" class="btn-primary">Enregistrer</button>
                <button type="button" class="btn-outline" id="closeModal">Annuler</button>
            </div>
        </form>
    </div>

</div>

<!-- Modal pour modifier le projet -->
<div id="projectModal" class="project-modal-overlay" style="display:none;">

    <div class="modal-project">
        <h3>✏️ Modifier le projet</h3>

        <form action="index.php?controller=project&action=modifyProject" method="POST" id="projectForm">
            <input type="hidden" name="id_project" id="modalProjectId" value="<?= $project->id_project ?>">
            <input type="hidden" name="id_status" id="modalStatusId" value="<?= $project->id_status ?>">
            <input type="hidden" name="start" id="modalStart" value="<?= $project->start_date ?>">
            <input type="hidden" name="end" id="modalEnd" value="<?= $project->end_date ?>">
            <input type="hidden" name="creator_id" id="modalCreatorId" value="<?= $project->creator_id ?>">

            <label for="modalTitle">Titre du projet</label>
            <input type="text" name="name" id="modalTitle" value="<?= $project->name ?>" required>

            <label for="modalDesc">Description</label>
            <textarea name="description" id="modalDesc" rows="4" required><?= $project->description ?></textarea>

            <div class="modal-actions">
                <button type="submit" class="btn-primary">Enregistrer</button>
                <button type="button" class="btn-outline" id="closeProjectModal">Annuler</button>
            </div>
        </form>
    </div>

</div>

<!-- modal pour supprimer le projet -->
<div id="deleteProjectModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h3>Supprimer le projet</h3>
        <p>Êtes-vous sûr de vouloir supprimer ce projet ?</p>

        <form id="deleteProjectForm" method="POST" action="index.php?controller=project&action=deleteProject">
            <input type="hidden" name="project_id" value="<?= $project->id_project ?>">
            <div class="form-actions">
                <button type="submit" class="btn-danger">Oui, supprimer</button>
                <button type="button" class="btn-outline" id="cancelDelete">Annuler</button>
            </div>
        </form>
    </div>
</div>

<!-- Styles  -->
<style>
    .project-page {
        padding: 40px 0 40px 40px;
        max-width: 1050px;
        width: 1000px;
        margin: auto;
        font-family: system-ui, sans-serif;
    }

    /* Header */
    .project-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        margin-bottom: 25px;
        max-width: 100%;
    }

    .project-header > div{
        min-width: 0;
        max-width: 60%;
    }

    .project-desc {
        color: #666;
        margin-top: 5px;
        max-width: 90%;
        white-space: normal;
        word-wrap: break-word;
        overflow-wrap: break-word;
    }

    .project-actions{
        margin-bottom: 1em;
        display: flex;
        gap: 10px;
        min-width: 40%;
    }

    /* Buttons */
    .btn-primary {
        background: #2563eb;
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 600;
        transition: 0.2s;
        text-decoration: none;
    }

    .btn-primary:hover {
        background: #1e4fd6;
    }

    .btn-danger {
        background: #dc2626;
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 600;
        transition: 0.2s;
        text-decoration: none;
    }

    .btn-danger:hover {
        background: #b91c1c;
    }

    .btn-outline {
        background: white;
        border: 2px solid #2563eb;
        color: #2563eb;
        padding: 10px 18px;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 600;
        transition: 0.2s;
        text-decoration: none;
    }

    .btn-outline:hover {
        background: #2563eb;
        color: white;
    }

    .btn-chat {
        width: fit-content;
        position: relative;
        display: block;
        background: #10b981;
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 600;
        transition: 0.2s;
        text-decoration: none;
    }

    .btn-chat:hover {
        background: #0f766e;
    }

    /* Infos */
    .project-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 35px;
    }

    .info-box {
        background: #f9fafb;
        padding: 15px;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
    }

    /* Status */
    .status.active {
        color: #2563eb;
    }

    /* Progress */
    .progress {
        background: #e5e7eb;
        height: 8px;
        border-radius: 20px;
        margin-top: 6px;
    }

    .progress-bar {
        height: 100%;
        background: #2563eb;
        border-radius: 20px;
    }

    /* Kanban */
    .kanban {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .column {
        background: #f9fafb;
        padding: 15px;
        border-radius: 14px;
        border: 1px solid #e5e7eb;
    }

    .column h3 {
        margin-bottom: 12px;
    }

    /* Tasks */
    .task {
        background: white;
        padding: 12px;
        border-radius: 12px;
        margin-bottom: 12px;
        border: 1px solid #e5e7eb;
        transition: 0.15s;
        cursor: pointer;
    }

    .task:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.06);
    }

    .task.done {
        opacity: 0.6;
        text-decoration: line-through;
    }

    /* Activity */
    .activity ul {
        margin-top: 10px;
        padding-left: 20px;
    }

    .activity li {
        margin-bottom: 8px;
        color: #444;
    }

    /* Sidebar */
    .project-sidebar {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 20px;
        height: fit-content;
        position: absolute;
        top: 96px;
        left: 1em;
    }

    .project-sidebar h3 {
        margin-bottom: 15px;
        font-size: 18px;
    }

    /* Collaborateurs */
    .collaborators {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .collaborator {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 6px;
        border-radius: 10px;
        cursor: pointer;
        transition: 0.2s;
    }

    .collaborator:hover {
        background: #e5e7eb;
    }

    /* Avatar */
    .avatar {
        width: 36px;
        height: 36px;
        background: #2563eb;
        color: white;
        font-weight: 600;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Header sidebar */
    .sidebar-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 5px;
        margin-bottom: 15px;
    }
    .sidebar-header h3 {
        margin: 0;
    }

    /* Bouton + */
    .btn-add-collab {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #2563eb;
        color: white;
        font-size: 22px;
        font-weight: 600;
        text-align: center;
        line-height: 32px;
        text-decoration: none;
        transition: 0.2s;
    }

    .btn-add-collab:hover {
        background: #1e4fd6;
    }

    /* Modal */
    .modal {
        display: none; /* caché par défaut */
        position: fixed;
        z-index: 1000;
        left: 0; top: 0;
        width: 100%; height: 100%;
        background-color: rgba(0,0,0,0.5);
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background: #f9fafb;
        padding: 25px;
        border-radius: 16px;
        border: 1px solid #e5e7eb;
        max-width: 400px;
        width: 90%;
        position: relative;
    }

    /* Close button */
    .close {
        position: absolute;
        right: 15px;
        top: 10px;
        font-size: 24px;
        font-weight: bold;
        cursor: pointer;
    }

    /* Form inside modal */
    .user-form .form-actions {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .user-form .form-actions button {
        flex: 1;
    }

    .context-menu {
        position: absolute;
        display: none; /* caché par défaut */
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        list-style: none;
        padding: 10px 0;
        z-index: 1000;
        min-width: 150px;
    }

    .context-menu li {
        padding: 8px 15px;
        cursor: pointer;
        transition: 0.2s;
    }

    .context-menu li:hover {
        background-color: #2563eb;
        color: white;
    }

    .context-menu li a {
        text-decoration: none;
        color: inherit;
        display: block;
        width: 100%;
    }

    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.4);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 2000;
    }

    .modal-date {
        background: white;
        padding: 25px;
        border-radius: 16px;
        width: 320px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }

    .modal-date h3 {
        margin-bottom: 15px;
    }

    .modal-date input[type="date"] {
        width: 100%;
        padding: 10px;
        border-radius: 10px;
        border: 1px solid #d1d5db;
        margin-bottom: 20px;
    }

    .modal-actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
    }

    .title:hover{
        color: #807f7f;
        cursor: pointer;
    }
/**/ 
    .project-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .modal-project {
        background: white;
        padding: 25px;
        border-radius: 14px;
        width: 90%;
        max-width: 500px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.2);
    }

    .modal-project label {
        display: block;
        margin-top: 12px;
        font-weight: 600;
    }

    .modal-project input, .modal-project textarea {
        width: 100%;
        padding: 8px 10px;
        margin-top: 5px;
        border-radius: 8px;
        border: 1px solid #d1d5db;
    }

    .modal-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 15px;
    }

    /* Responsive */
    @media (max-width: 500px) {
        .modal-content {
            padding: 20px;
        }
    }

    @media (max-width: 768px) {
        .project-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .project-actions {
            width: 100%;
            flex-direction: column;
        }

        .project-actions a {
            width: 100%;
            text-align: center;
        }
    }

</style>
<script>
/////////// Gestion de la popup ajouter un collaborateur
const userModal = document.getElementById("userModal");
    const openBtn = document.getElementById("openUserModal");
    const closeBtn = document.querySelector(".modal .close");
    const cancelBtn = document.getElementById("cancelModal");

    // Ouvrir la popup
    openBtn.addEventListener("click", () => {
        userModal.style.display = "flex";
    });

    // Fermer la popup
    closeBtn.addEventListener("click", () => {
        userModal.style.display = "none";
    });
    cancelBtn.addEventListener("click", () => {
        userModal.style.display = "none";
    });

    // Fermer si clic à l'extérieur du contenu
    window.addEventListener("click", (e) => {
        if(e.target === userModal){
            userModal.style.display = "none";
        }
    });

////////// Gestion de la suppression d'un collaborateur
const deleteModal = document.getElementById("deleteUserModal");
    const deleteForm = document.getElementById("deleteUserForm");
    const deleteUserIdInput = document.getElementById("deleteUserId");

    const deleteButtons = document.querySelectorAll(".collaborator");
    const closeDelete = deleteModal.querySelector(".close");
    const cancelDelete = document.getElementById("cancelDelete");

    let hiddenUserId = document.getElementById("deleteUserId");
    hiddenUserId.value = "";

    // Ouvrir modal et passer l'ID
    deleteButtons.forEach(btn => {
        btn.addEventListener("click", () => {
            const userId = btn.dataset.userId;
            deleteUserIdInput.value = userId;
            deleteModal.style.display = "flex";
        });
    });

    // Fermer modal
    closeDelete.addEventListener("click", () => deleteModal.style.display = "none");
    cancelDelete.addEventListener("click", () => deleteModal.style.display = "none");
    window.addEventListener("click", (e) => {
        if(e.target === deleteModal){
            deleteModal.style.display = "none";
        }
    });

////////// Gestion du menu contextuel sur les tâches
const items = document.querySelectorAll(".task");

    items.forEach(item => {
        item.addEventListener("contextmenu", (e) => {
            e.preventDefault();
            const contextMenu = document.getElementById("contextMenu");
            Array.from(contextMenu.children).forEach(li => {
                const link = li.querySelector("a");

                // On remet l'URL proprement
                link.href = link.dataset.baseHref + item.dataset.taskId;
            });
                contextMenu.style.top = e.pageY + "px";
                contextMenu.style.left = e.pageX + "px";
                contextMenu.style.display = "block";
            });
        });

    document.addEventListener("click", () => {
        contextMenu.style.display = "none";
    });


/////////// popup modification des dates
const dateModal = document.getElementById("dateModal");
    const form = document.getElementById("dateForm");
    const projectIdInput = document.getElementById("modalProjectId");
    const dateTypeInput = document.getElementById("dateType");
    const dateInput = form.querySelector('input[type="date"]');
    const dateCloseBtn = document.getElementById("closeModal");
    
    let projectDate = document.querySelectorAll(".info-date");
    projectDate.forEach(el => {
        el.addEventListener("click", () => {
            dateTypeInput.value = el.dataset.dateType;
            dateInput.value = el.dataset.currentDate || '';
            dateModal.style.display = "flex";
            dateInput.focus();
        });
    });

    dateCloseBtn.addEventListener("click", closeModal);

    dateModal.addEventListener("click", (e) => {
        if (e.target === dateModal) {
            closeModal();
        }
    });

    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && dateModal.style.display === "flex") {
            closeModal();
        }
    });

    function closeModal() {
        dateModal.style.display = "none";
        form.reset();
    }
       
/////////// popup modification du projet
const projectModal = document.getElementById("projectModal");
    const titlemodif = document.querySelector(".title");
    const projectCloseBtn = document.getElementById("closeProjectModal");

    const projectForm = document.getElementById("projectForm");
    const modifProjectIdInput = document.getElementById("modalProjectId");
    const titleInput = document.getElementById("modalTitle");
    const descInput = document.getElementById("modalDesc");

    // Ouvrir modal et remplir les champs
    titlemodif.addEventListener("click", () => {
        projectModal.style.display = "flex";
        titleInput.focus();
    });

    // Fermer modal
    projectCloseBtn.addEventListener("click", () => {
        projectModal.style.display = "none";
        projectForm.reset();
    });

    // Fermer en cliquant hors modal
    projectModal.addEventListener("click", (e) => {
        if (e.target === projectModal) {
            projectModal.style.display = "none";
            projectForm.reset();
        }
    });

    // Fermer avec ESC
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape" && projectModal.style.display === "flex") {
            projectModal.style.display = "none";
            projectForm.reset();
        }
    });

///////////// popup suppression du projet
const deleteProjectModal = document.getElementById("deleteProjectModal");
    const deleteProjectForm = document.getElementById("deleteProjectForm");
    const deleteProjectBtn = document.getElementById("btnDeleteProject");
    const closeDeleteProject = deleteProjectModal.querySelector(".close");
    const cancelDeleteProject = document.getElementById("cancelDelete");

    // Ouvrir modal
    deleteProjectBtn.addEventListener("click", (e) => {
        e.preventDefault();
        deleteProjectModal.style.display = "flex";
    });

    // Fermer modal
    closeDeleteProject.addEventListener("click", () => deleteProjectModal.style.display = "none");
    cancelDeleteProject.addEventListener("click", () => deleteProjectModal.style.display = "none");
    window.addEventListener("click", (e) => {
        if(e.target === deleteProjectModal){
            deleteProjectModal.style.display = "none";
        }
    });

</script>

