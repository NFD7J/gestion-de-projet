<?php $title = "Dashboard" ?>
<style>
    .dashboard-section {
        max-width: 1400px;
        margin: 40px auto;
        padding: 0 24px;
    }

    .dashboard-header {
        display: flex;
        justify-content: space-between;
        gap: 1em;
        align-items: center;
        margin-bottom: 32px;
    }

    .dashboard-header h1 {
        font-size: 2rem;
        color: #2563eb;
    }

    /*.projects-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 24px;
    }*/
    .projects-grid {
        display: flex;
        flex-wrap: wrap;       /* permet aux cartes de passer à la ligne si pas assez d’espace */
        gap: 24px;               /* espace entre les cartes */
        align-items: stretch;       
        justify-content: flex-start; /* aligne à gauche, ou center si tu veux centrer */
    }

    .project-card {
        width: 300px;
        height: 100%;
        padding: 28px;
        border-radius: 14px;
        border: 1px solid #e5e7eb;
        background: #fff;
        box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        display: flex;
        flex-direction: column; /* pour aligner titre, description, info */
    }

    .project-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.08);
    }

    .project-card h2 {
        margin-bottom: 8px;
        font-size: 1.3rem;
        color: #1e40af;
    }

    .project-card p {
        font-size: 0.95rem;
        color: #555;
        margin-bottom: 12px;
         /* 👇 TRONCATURE */
        display: -webkit-box;
        -webkit-line-clamp: 3;      /* nombre de lignes */
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .project-info {
        display: flex;
        justify-content: space-between;
        font-size: 0.85rem;
        color: #777;
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

    .project-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }

    /*.project-card {
        background: #fff;
        padding: 20px;
        border-radius: 14px;
        border: 1px solid #e5e7eb;
        transition: 0.2s;
        cursor: pointer;
        height: 100%;
    }*/

    @media (max-width: 1024px) {
        .project-card {
            flex: 1 1 45%; /* 2 cartes par ligne approximativement */
        }
    }

    @media (max-width: 600px) {
        .project-card {
            flex: 1 1 100%; /* 1 carte par ligne */
        }
    }


</style>

<section class="dashboard-section">

    <div class="dashboard-header">
        <h1>Tableau de bord</h1>
        <a href="index.php?controller=project&action=add" class="btn-primary">+ Nouveau projet</a>
    </div>

    <div class="projects-grid">

        <?php foreach ($projects as $project): ?>
            <a href="index.php?controller=project&action=openProject&id=<?= $project->id_project ?>" class="project-link">
                <div class="project-card">
                    <h2><?= htmlspecialchars($project->name) ?></h2>
                    <p><?= htmlspecialchars($project->description) ?></p>
                    <div class="project-info">
                        <span>Participants : <?= $project->participant_count ?></span>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>

    </div>

</section>
