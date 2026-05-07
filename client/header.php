<?php
$currentPage = $_GET;
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container-fluid mx-2">

        <!-- Logo -->
        <a class="navbar-brand fw-bold" href="index.php">
            Discuss
        </a>

        <!-- Toggle -->
        <button class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">

            <!-- LEFT MENU -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <!-- Home -->
                <li class="nav-item">
                    <a class="nav-link <?= empty($currentPage) ? 'active fw-bold' : '' ?>"
                        href="index.php">
                        Home
                    </a>
                </li>

                <!-- Category -->
                <li class="nav-item">
                    <a class="nav-link <?= isset($_GET['category']) ? 'active fw-bold' : '' ?>"
                        href="?category=true">
                        Category List
                    </a>
                </li>

                <!-- Latest -->
                <li class="nav-item">
                    <a class="nav-link <?= isset($_GET['latest']) ? 'active fw-bold' : '' ?>"
                        href="?latest=true">
                        Latest Questions
                    </a>
                </li>

                <?php if (isset($_SESSION['user']['username'])): ?>

                    <!-- Ask -->
                    <li class="nav-item">
                        <a class="nav-link <?= isset($_GET['ask']) ? 'active fw-bold' : '' ?>"
                            href="?ask=true">
                            Ask Question
                        </a>
                    </li>

                    <!-- My Question -->
                    <li class="nav-item">
                        <a class="nav-link <?= isset($_GET['user_id']) ? 'active fw-bold' : '' ?>"
                            href="?user_id=<?= $_SESSION['user']['user_id'] ?>">
                            My Question
                        </a>
                    </li>

                <?php endif; ?>

            </ul>

            <!-- SEARCH -->
            <form class="d-flex me-3 mb-2 mb-lg-0"
                action="">

                <input class="form-control form-control-sm me-2"
                    type="search"
                    name="search"
                    placeholder="Search...">

                <button type="submit" class="btn btn-outline-light btn-sm">
                    Search
                </button>

            </form>

            <!-- RIGHT -->
            <div class="d-flex gap-2 align-items-center">

                <?php if (isset($_SESSION['user']['username'])): ?>

                    <span class="text-white small">
                        Hello,
                        <?= htmlspecialchars($_SESSION['user']['username']) ?>
                    </span>

                    <a href="server/requests.php?logout=true"
                        class="btn btn-outline-light btn-sm">
                        Logout
                    </a>

                <?php else: ?>

                    <a href="?login=true"
                        class="btn btn-outline-light btn-sm <?= isset($_GET['login']) ? 'active' : '' ?>">
                        Login
                    </a>

                    <a href="?signup=true"
                        class="btn btn-primary btn-sm <?= isset($_GET['signup']) ? 'active' : '' ?>">
                        Signup
                    </a>
                <?php endif; ?>

            </div>
        </div>
    </div>
</nav>