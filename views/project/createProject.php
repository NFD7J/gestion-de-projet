<?php $title = "Créer un projet" ?>
<style>
    .create-project-section {
        max-width: 600px;
        margin: 50px auto;
        padding: 24px 32px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    }

    .create-project-section h1 {
        font-size: 2rem;
        color: #2563eb;
        margin-bottom: 8px;
    }

    .create-project-section .section-desc {
        font-size: 1rem;
        color: #555;
        margin-bottom: 24px;
    }

    .create-project-form .form-group {
        margin-bottom: 18px;
        text-align: left;
    }

    .create-project-form label {
        display: block;
        font-weight: 500;
        margin-bottom: 6px;
        color: #333;
    }

    .create-project-form input,
    .create-project-form textarea,
    .create-project-form select {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 1rem;
        transition: border 0.2s ease, box-shadow 0.2s ease;
    }

    .create-project-form input:focus,
    .create-project-form textarea:focus,
    .create-project-form select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.2);
        outline: none;
    }

    .create-project-form button.btn-primary {
        margin-top: 12px;
        width: 100%;
        padding: 12px 0;
        font-size: 1rem;
    }
    .btn-primary {
        margin-left: auto;
        display: inline-block;
        padding: 12px 28px;
        font-size: 1rem;
        font-weight: 600;
        text-decoration: none;
        color: #fff;
        background: linear-gradient(135deg, #2563eb, #1e40af);
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.25s ease;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }

    /* Hover – intensifie le dégradé */
    .btn-primary:hover {
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.4);
        background: linear-gradient(135deg, #1e40af, #1e3a8a);
    }

    /* Active – clique appuyé */
    .btn-primary:active {
        transform: translateY(1px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }
</style>
<section class="create-project-section">

    <h1>Créer un nouveau projet</h1>
    <p class="section-desc">Remplissez les informations ci-dessous pour créer un projet collaboratif.</p>

    <?php if(isset($error)): ?>
        <div class="error-message" style="color:red; margin-bottom:15px;">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>
    <form action="index.php?controller=project&action=add" method="POST" class="create-project-form">

        <div class="form-group">
            <label for="project-name">Nom du projet</label>
            <input type="text" id="project-name" name="name" placeholder="Ex: Projet Alpha" required>
        </div>

        <div class="form-group">
            <label for="project-desc">Description du projet</label>
            <textarea id="project-desc" name="description" rows="4" placeholder="Décrivez brièvement le projet" required></textarea>
        </div>
        <div class="form-group">
            <label for="project-start-date">Date de début</label>
            <input type="date" id="project-start-date" name="start_date" required>
        </div>
        <div class="form-group">
            <label for="project-end-date">Date de fin</label>
            <input type="date" id="project-end-date" name="end_date" required>
        </div>
        <div class="form-group">
            <label for="project-status">Status</label>
            <select name="status_id" id="project-status" required>
                <option value="" selected>Selection du status</option>
                <?php foreach($statuses as $status): ?>
                    <option value="<?= $status->id_status ?>"><?= $status->libelle ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <!--<div class="form-group">
            <label for="project-members">Ajouter des membres</label>
            <select id="project-members" name="members[]" multiple>
                <option value="1">Alice</option>
                <option value="2">Bob</option>
                <option value="3">Charlie</option>
            </select>
            <small>Maintenez Ctrl (ou Cmd) pour sélectionner plusieurs membres</small>
        </div>-->

        <button type="submit" class="btn-primary">Créer le projet</button>

    </form>

</section>
