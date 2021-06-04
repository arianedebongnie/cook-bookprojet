<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-5">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <img src="/blog/resources/images/bootstrap-logo.svg" alt="" width="30" height="24" class="d-inline-block align-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/php_simple/pages/articles/articles.php">Articles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/php_simple/pages/articles/article_form.php">Créer</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/php_simple/pages/users/users.php">Utilisateurs</a>
                    </li>
                </ul>
                <ul class="navbar-nav mb-2 mb-lg-0 ms-auto">
                    <?php
                    require($_SERVER['DOCUMENT_ROOT'].'/php_simple/components/users/' . (isset($user) ? 'user_actions' : 'login') . '.php');
                    ?>
                </ul>
            </div>
        </div>
    </nav>
</header>