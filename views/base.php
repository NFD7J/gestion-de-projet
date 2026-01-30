<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Projet MVC' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        /* RESET SIMPLE */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background: #f4f6f8;
            color: #333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* HEADER */
        header {
            background: #ffffff;
            height: 64px;
            border-bottom: 1px solid #e5e7eb;
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            padding: 0 24px;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .header-left a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .header-center {
            display: flex;
            gap: 32px;
            justify-self: center;
        }

        /*.header-right {
            vide volontairement pour équilibrer
        }*/


        .logo {
            width: 32px;
            height: 32px;
            background: #2563eb;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            font-weight: bold;
        }

        .header-center {
            flex: 1;
            display: flex;
            justify-content: center;
            gap: 32px;
        }

        .header-center a {
            text-decoration: none;
            color: #555;
            font-weight: 500;
            padding: 6px 0;
            border-bottom: 2px solid transparent;
        }

        .header-center a:hover {
            color: #2563eb;
            border-bottom-color: #2563eb;
        }

        /* MAIN */
        main {
            padding: 32px;
            max-width: 1200px;
            margin: auto;
        }

        /* FOOTER */
        footer {
            margin-top: 40px;
            padding: 16px;
            text-align: center;
            font-size: 14px;
            color: #777;
            background-color: #e5e7eb;

        }
    </style>
</head>

<body>

<header>
    <div class="header-left">
        <a href="index.php">
            <div class="logo">PB</div>
            <span>ProjectBoard</span>
        </a>
    </div>

    <nav class="header-center">
        <?php if (isset($_SESSION['user'])): ?>
            <a href="index.php?controller=project&action=project">Projets</a>
            <a href="index.php?controller=project">Dashboard</a>
            <a href="index.php?controller=auth&action=logout">Logout</a>
        <?php else: ?>
            <a href="index.php?controller=auth">Login</a>
            <a href="index.php?controller=auth&action=register">Register</a>
        <?php endif; ?>
    </nav>

    <div class="header-right"></div>
</header>


<main>
    <?= $content ?>
</main>

<footer>
    © <?= date('Y') ?> ProjectBoard — MVC
</footer>

</body>
</html>
