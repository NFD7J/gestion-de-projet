<?php $title = "Accueil" ?>
<style>
    .home-intro {
        max-width: 800px;
        margin: 60px auto;
        text-align: center;
    }

    .home-intro h1 {
        font-size: 2.2rem;
        margin-bottom: 16px;
    }

    .home-intro .subtitle {
        font-size: 1.1rem;
        color: #555;
        margin-bottom: 24px;
    }

    .home-intro p {
        margin-bottom: 16px;
        line-height: 1.6;
    }

    .home-actions {
        margin-top: 32px;
        display: flex;
        justify-content: center;
        gap: 16px;
    }

    .btn-primary {
        padding: 10px 20px;
        background: #2563eb;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        transition: background 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
    }

    .btn-primary:hover {
        background: #1e4ed8;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(37, 99, 235, 0.3);
    }

    .btn-secondary {
        padding: 10px 20px;
        border: 1px solid #2563eb;
        color: #2563eb;
        text-decoration: none;
        border-radius: 6px;
        transition: background 0.2s ease, color 0.2s ease, transform 0.2s ease;
    }

    .btn-secondary:hover {
        background: #2563eb;
        color: white;
        transform: translateY(-2px);
    }
</style>

<section class="home-intro">

    <h1>Plateforme de collaboration Open Source</h1>

    <p class="subtitle">
        Un espace collaboratif pour organiser, développer et suivre des projets open source
        en équipe, simplement et efficacement.
    </p>

    <p>
        Cette plateforme permet aux développeurs et collaborateurs de gérer des projets,
        d’attribuer des tâches, de suivre leur avancement et d’échanger via des espaces de
        discussion dédiés. Inspirée d’outils comme Trello ou Notion, elle centralise toutes
        les informations essentielles au bon déroulement d’un projet.
    </p>

    <p>
        Chaque utilisateur peut rejoindre des projets, consulter les tâches qui lui sont
        assignées, participer aux discussions et contribuer activement à l’évolution des
        projets open source.
    </p>

    <?php if(!isset($_SESSION['user'])): ?>
    <div class="home-actions">
        <a href="index.php?controller=auth&action=register" class="btn-primary">
            S'inscrire
        </a>
        <a href="index.php?controller=auth" class="btn-secondary">
            Se connecter
        </a>
    </div>
    <?php endif; ?>

</section>
