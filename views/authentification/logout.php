<?php $title = "Disconnect" ?>
<style>
    .logout-alert {
        max-width: 400px;
        margin: 60px auto;
        padding: 24px 32px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        text-align: center;
    }

    .logout-alert p {
        font-size: 1.1rem;
        margin-bottom: 24px;
        color: #333;
        font-weight: 500;
    }

    .logout-form {
        display: flex;
        justify-content: center;
        gap: 16px;
    }

    .logout-form input[type="submit"] {
        padding: 10px 24px;
        font-size: 1rem;
        font-weight: 600;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.25s ease;
    }

    /* Bouton OUI – primaire */
    .btn-oui {
        background: linear-gradient(135deg, #2563eb, #1e40af);
        color: #fff;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }

    .btn-oui:hover {
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.4);
        background: linear-gradient(135deg, #1e40af, #1e3a8a);
    }

    .btn-oui:active {
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    }

    /* Bouton NON – secondaire */
    .btn-non {
        background: #f3f4f6;
        color: #333;
        border: 1px solid #ccc;
    }

    .btn-non:hover {
        background: #e5e7eb;
    }
</style>
<div role="alert" class="logout-alert">
    <p>Voulez-vous vous déconnecter ?</p>
    <form action="#" method="POST" class="logout-form">
        <input type="submit" name="true" value="OUI" class="btn-oui">
        <input type="submit" name="false" value="NON" class="btn-non">
    </form>
</div>
