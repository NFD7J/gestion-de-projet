<?php $title = "Discussion du projet" ?>
<a href="index.php?controller=project&action=openProject&id=<?= $project->id_project ?>" class="back-btn">← Retour</a>

<section class="chat-page">

    <header class="chat-header">
        <h2>💬 <?= $project->name ?></h2>
    </header>

    <!-- Messages -->
    <div class="chat-messages" id="chatMessages">
        <?php foreach ($messages as $msg): ?>
            <div data-message-id="<?= $msg->id_message ?>" class="message <?= $msg->id_user == $_SESSION['user']['id'] ? 'me' : '' ?>">
                <strong><?= htmlspecialchars($msg->nom) ?></strong>
                <p><?= nl2br(htmlspecialchars($msg->content)) ?></p>
                <small><?= date('d/m/Y H:i', strtotime($msg->date)) ?></small>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Envoi -->
    <form action="index.php?controller=project&action=chat&id=<?= $project->id_project ?>" method="POST" class="chat-form">
        <textarea name="content" placeholder="Écris un message..." required></textarea>
        <button type="submit" class="btn-chat">Envoyer</button>
    </form>

</section>

<!-- Menu contextuel pour supprimmer les messages -->
<ul id="contextMenu" class="context-menu">
    <li><a data-base-href="index.php?controller=project&action=deleteMessage&id[]=<?= $project->id_project ?>&id[]=" href="#">🗑️ Supprimer</a></li>
</ul>

<style>
    .chat-page {
        display: flex;
        flex-direction: column;
        height: 80vh;
        max-width: 1000px;
        min-width: 900px;
        margin: auto;
        background: #f9fafb;
        border-radius: 16px;
        border: 1px solid #e5e7eb;
    }

    .chat-header {
        padding: 15px 20px;
        border-bottom: 1px solid #e5e7eb;
        background: white;
        border-radius: 16px 16px 0 0;
    }

    .chat-header span {
        color: #666;
        font-size: 14px;
    }

    .chat-messages {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .message {
        max-width: 70%;
        background: white;
        padding: 12px 15px;
        border-radius: 14px;
        border: 1px solid #e5e7eb;
    }

    .message.me {
        align-self: flex-end;
        background: #2563eb;
        color: white;
    }

    .message.me strong,
    .message.me small {
        color: #e0e7ff;
    }

    .message small {
        display: block;
        margin-top: 5px;
        font-size: 11px;
        color: #666;
    }

    .chat-form {
        display: flex;
        gap: 10px;
        padding: 15px;
        border-top: 1px solid #e5e7eb;
        background: white;
        border-radius: 0 0 16px 16px;
    }

    .chat-form textarea {
        flex: 1;
        resize: none;
        padding: 10px;
        border-radius: 10px;
        border: 1px solid #d1d5db;
        height: 50px;
    }

    .chat-form button {
        background: linear-gradient(135deg, #2563eb, #1e40af);
        color: white;
        border: none;
        padding: 0 22px;
        height: 50px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.25s ease;
        box-shadow: 0 6px 15px rgba(37, 99, 235, 0.3);
    }

    /* Hover */
    .chat-form button:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(37, 99, 235, 0.45);
    }

    /* Click */
    .chat-form button:active {
        transform: translateY(0);
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.3);
    }

    /* Désactivé */
    .chat-form button:disabled {
        background: #9ca3af;
        cursor: not-allowed;
        box-shadow: none;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        position: absolute;
        left: 3em;
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

</style>
<script>
/////////// Auto scroll vers le bas et gestion du bouton envoyer
const chat = document.getElementById("chatMessages");
    chat.scrollTop = chat.scrollHeight;
    const textarea = document.querySelector(".chat-form textarea");
    const btn = document.querySelector(".chat-form button");

    textarea.addEventListener("input", () => {
        btn.disabled = textarea.value.trim() === "";
    });
///////////// Menu contextuel sur les tâches
const items = document.querySelectorAll(".message.me");

    items.forEach(item => {
        item.addEventListener("contextmenu", (e) => {
            e.preventDefault();
            const contextMenu = document.getElementById("contextMenu");
            const li = contextMenu.children[0];
            const link = li.querySelector("a");

            // On remet l'URL proprement
            link.href = link.dataset.baseHref + item.dataset.messageId;
            contextMenu.style.top = e.pageY + "px";
            contextMenu.style.left = e.pageX + "px";
            contextMenu.style.display = "block";
        });
    });
    document.addEventListener("click", () => {
        contextMenu.style.display = "none";
    });
</script>