<!-- Main Content -->
<div class="container">

    <div class="row">
        <div class="col-md-9">

            <h3 class="text-center mb-4 fw-bold">Questions</h3>

            <?php
            include "./common/db.php";

            if (isset($_GET['category_id'])) {
                $category_id = $_GET['category_id'];
                $query = "SELECT * FROM questions WHERE category_id = $category_id";
            } elseif (isset($_GET['user_id'])) {
                $user_id = $_GET['user_id'];
                $query = "SELECT * FROM questions WHERE user_id = $user_id";
            } elseif (isset($_GET['latest'])) {
                $query = "SELECT * FROM questions ORDER BY id DESC";
            } elseif (isset($_GET['search'])) {
                $search = $_GET['search'];
                $query = "SELECT * FROM questions WHERE title LIKE '%$search%' OR description LIKE '%$search%'";
            } else {
                $query = "SELECT * FROM questions";
            }
            $result = $conn->query($query);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $questionId = $row['id'];
            ?>

                    <div class="card mb-3 border-1 shadow-sm question-card">
                        <div class="card-body">
                            <h5 class="card-title fw-semibold text-dark">
                                <a href="?question_id=<?= $questionId ?>" class="text-decoration-none">
                                    <?= htmlspecialchars(ucfirst($row['title'])) ?>
                                </a>
                                <!-- delete user -->
                                <?php if (isset($user_id) == $row['user_id']): ?>
                                    <a href="server/requests.php?delete_question=<?= $questionId ?>"
                                        class="btn btn-danger btn-sm float-end">
                                        Delete
                                    </a>
                                <?php endif; ?>
                            </h5>
                        </div>
                    </div>
                <?php
                }
            } else { ?>
                <div class="card mb-3 border-1 shadow-sm question-card">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold text-dark">
                            <p class="text-decoration-none">
                                No questions found
                            </p>
                        </h5>
                    </div>
                </div>
            <?php }
            ?>
        </div>
        <div class="col-md-3">
            <?php
            include 'categoryList.php';
            ?>
        </div>


    </div>

</div>