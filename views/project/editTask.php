<?php $title = "Modifier la tâche"; ?>
<link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
<a href="index.php?controller=project&action=openProject&id=<?= $task->id_project ?>" class="back-btn">← Retour</a>
<h2>✏️ Modifier la tâche</h2>

<?php if (!empty($error)): ?>
    <p style="color:red"><?= $error ?></p>
<?php endif; ?>

<form action="index.php?controller=project&action=editTask" method="POST" class="task-form">
    
    <!-- Description -->
    <div class="form-group">
        <label>Description</label>
        <input 
            type="text" 
            name="description" 
            value="<?= htmlspecialchars($task->description) ?>" 
            required
        >
    </div>

    <!-- Dates -->
    <div class="form-group">
        <label>Date de début</label>
        <input 
            type="datetime-local" 
            name="start_date" 
            value="<?= $task->start_date ? date('Y-m-d H:i', strtotime($task->start_date)) : '' ?>"
        >
    </div>

    <div class="form-group">
        <label>Date de fin</label>
        <input 
            type="datetime-local" 
            name="end_date" 
            value="<?= $task->end_date ? date('Y-m-d H:i', strtotime($task->end_date)) : '' ?>"
        >
    </div>

    <!-- Statut -->
    <div class="form-group">
        <label for="status">Status</label>
        <select id="status" name="id_status" required>
            <option value="1" <?= $task->id_status == 1 ? 'selected' : '' ?>>📌 À faire</option>
            <option value="2" <?= $task->id_status == 2 ? 'selected' : '' ?>>⚙️ En cours</option>
            <option value="3" <?= $task->id_status == 3 ? 'selected' : '' ?>>✅ Terminé</option>
        </select>
    </div>

    <!-- Collaborateurs -->
    <div class="form-group">
        <label>Collaborateurs</label>
        <select id="users" name="users[]" multiple>
            <?php foreach ($collaborateurs as $user): ?>
                <option 
                    value="<?= $user->id_user ?>"
                >
                    <?= $user->nom ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Hidden -->
    <input type="hidden" name="id_task" value="<?= $task->id_task ?>">
    <input type="hidden" name="id_project" value="<?= $task->id_project ?>">

    <!-- Actions -->
    <div class="form-actions">
        <button type="submit" class="btn-primary">💾 Enregistrer</button>
        <a href="index.php?controller=project&action=openProject&id=<?= $task->id_project ?>" class="btn-outline">
            Annuler
        </a>
    </div>
</form>
<style>
    .task-form {
        max-width: 600px;
        min-width: 400px;
        background: #f9fafb;
        padding: 25px;
        border-radius: 16px;
        border: 1px solid #e5e7eb;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 6px;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 10px;
        border-radius: 10px;
        border: 1px solid #d1d5db;
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
    
</style>
<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
<script>
    new TomSelect('#users', {
        plugins: ['remove_button'],
        placeholder: 'Sélectionner des collaborateurs'
    });
</script>
