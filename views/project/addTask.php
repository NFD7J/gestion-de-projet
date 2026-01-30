<?php $title = "Ajouter une tâche" ?>
<link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
<a href="index.php?controller=project&action=openProject&id=<?= $_GET['id'] ?>" class="back-btn">← Retour</a>

<section class="task-form-section">

    <h2>➕ Ajouter une tâche</h2>

    <form action="index.php?controller=project&action=addTask" method="POST" class="task-form">

        <!-- Titre / description -->
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" id="description" name="description" required>
        </div>

        <!-- Dates -->
        <div class="form-row">
            <div class="form-group">
                <label for="start_date">Date de début</label>
                <input type="datetime-local" id="start_date" name="start_date" >
            </div>

            <div class="form-group">
                <label for="end_date">Date de fin</label>
                <input type="datetime-local" id="end_date" name="end_date" >
            </div>
        </div>

        <!-- Statut -->
        <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="id_status" required>
                <option value="1">📌 À faire</option>
                <option value="2">⚙️ En cours</option>
                <option value="3">✅ Terminé</option>
            </select>
        </div>

        <!-- Assignation -->
        <div class="form-group">
            <label for="assigned_to">Assignée à</label>
            <select id="users" name="users[]" multiple>
                <?php foreach ($collaborateurs as $collaborateur): ?>
                    <option value="<?= $collaborateur->id_user ?>">
                        <?= $collaborateur->nom ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <input type="hidden" name="id_project" value="<?= $_GET['id'] ?>">
        <!-- Boutons -->
        <div class="form-actions">
            <button type="submit" class="btn-primary">Créer la tâche</button>
        </div>

    </form>

</section>
<style>
    .task-form-section {
        max-width: 600px;
        min-width: 400px;
        margin: 40px auto;
    }

    .task-form {
        background: #f9fafb;
        padding: 25px;
        border-radius: 16px;
        border: 1px solid #e5e7eb;
    }

    .task-form-section h2 {
        margin-bottom: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        margin-bottom: 15px;
    }

    .form-group label {
        font-weight: 600;
        margin-bottom: 6px;
    }

    .form-group input,
    .form-group select {
        padding: 10px;
        border-radius: 10px;
        border: 1px solid #d1d5db;
        font-size: 14px;
    }

    .form-row {
        display: flex;
        gap: 15px;
    }

    .form-actions {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

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

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        margin-bottom: 15px;
        background: #f3f4f6;
        color: #2563eb;
        font-weight: 600;
        text-decoration: none;
        border-radius: 10px;
        transition: all 0.2s ease;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    .back-btn:hover {
        background: #2563eb;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }

    /* Responsive */
    @media (max-width: 600px) {
        .form-row {
            flex-direction: column;
        }

        .form-actions {
            flex-direction: column;
        }

        .form-actions a,
        .form-actions button {
            width: 100%;
            text-align: center;
        }
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

<script>
new TomSelect('#users', {
    plugins: ['remove_button'],
    placeholder: 'Sélectionner des collaborateurs'
});
</script>
