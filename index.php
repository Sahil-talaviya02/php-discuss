<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discuss</title>

    <?php include 'client/commonFiles.php'; ?>
</head>

<style>
    html,
    body {
        height: 100%;
    }
</style>

<body class="d-flex flex-column min-vh-100">

    <?php
    session_start();

    // Navbar
    include 'client/header.php';
    ?>


    <!-- Scrollable Content -->
    <div class="flex-grow-1 overflow-auto">
        <div class="container my-4">

            <!-- Messages -->
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?= $_SESSION['error'];
                    unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?= $_SESSION['success'];
                    unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <!-- Main Content -->
            <?php
            $isLoggedIn = isset($_SESSION['user']['username']);

            if (isset($_GET['signup']) && !$isLoggedIn) {
                include 'client/signup.php';
            } elseif (isset($_GET['login']) && !$isLoggedIn) {
                include 'client/login.php';
            } elseif (isset($_GET['ask'])) {
                include 'client/ask.php';
            } elseif (isset($_GET['question_id'])) {
                include 'client/question_details.php';
            } elseif (isset($_GET['user_id'])) {
                include 'client/question.php';
            } elseif (isset($_GET['category_id'])) {
                include 'client/question.php';
            } elseif (isset($_GET['latest'])) {
                include 'client/question.php';
            } elseif (isset($_GET['category'])) {
                include 'client/categoryList.php';
            } elseif (isset($_GET['search'])) {
                include 'client/question.php';
            } else {
                include 'client/question.php';
            }
            ?>

        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-auto">
        <p class="mb-0">© 2026 Discuss. All Rights Reserved.</p>
    </footer>

</body>

</html>