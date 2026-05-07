<div class="container">

    <div class="row">
        <div class="col-md-9">

            <h3 class="text-center mb-4 fw-bold">Questions</h3>

            <?php
            include "./common/db.php";

            $qid = $_GET['question_id'];

            $stmt = $conn->prepare("
        SELECT q.*, u.username, c.name AS category_name
        FROM questions q
        LEFT JOIN users u ON q.user_id = u.id
        LEFT JOIN category c ON q.category_id = c.id
        WHERE q.id = ?
    ");

            $stmt->bind_param("i", $qid);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $questionId = $row['id'];
                    $categoryId = $row['category_id'];
            ?>

                    <!-- Question Card  -->
                    <div class="card mb-3 border-1 shadow-sm question-card">
                        <div class="card-body">
                            <!-- Title -->
                            <h5 class="card-title fw-semibold text-dark"> Question:
                                <?= htmlspecialchars($row['title']) ?>
                            </h5>
                            <!-- Description -->
                            <p class="card-text text-muted">
                                <?= substr(htmlspecialchars($row['description']), 0, 120) ?>...
                            </p>
                            <!-- Footer -->
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <span class="badge bg-light text-dark border">
                                        <?= $row['category_name'] ?? 'General' ?>
                                    </span>
                                </div>
                                <small class="text-muted">
                                    👤 <?= $row['username'] ?? 'Guest' ?>
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Answer Form -->
                    <div class="card my-4 shadow-sm">
                        <div class="card-body">

                            <h5 class="mb-3">Your Answer</h5>

                            <form action="./server/requests.php" method="POST">

                                <input type="hidden" name="question_id" value="<?= $questionId ?>">

                                <div class="mb-3">
                                    <textarea name="answer" class="form-control" rows="4" placeholder="Write your answer..." required></textarea>
                                </div>

                                <button type="submit" name="submitAnswer" class="btn btn-dark">
                                    Submit Answer
                                </button>

                            </form>

                        </div>
                    </div>

                    <?php
                    $ansStmt = $conn->prepare("
                        SELECT a.*, u.username 
                        FROM answers a
                        LEFT JOIN users u ON a.user_id = u.id
                        WHERE a.question_id = ?
                        ORDER BY a.id DESC
                    ");
                    $ansStmt->bind_param("i", $questionId);
                    $ansStmt->execute();
                    $ansResult = $ansStmt->get_result();
                    ?>

                    <h3 class="text-center mb-4 fw-bold">Answers</h3>

                    <?php if ($ansResult->num_rows == 0): ?>
                        <div class="alert alert-info">No answers yet. Be the first to answer!</div>
                    <?php else: ?>

                        <?php while ($ans = $ansResult->fetch_assoc()): ?>
                            <div class="card mb-3 shadow-sm">
                                <div class="card-body d-flex justify-content-between align-items-start">

                                    <!-- Answer -->
                                    <div class="me-3">
                                        <?= nl2br(htmlspecialchars($ans['answer'])) ?>
                                    </div>

                                    <!-- Username -->
                                    <small class="text-muted text-nowrap">
                                        👤 <?= $ans['username'] ?? 'Guest' ?>
                                    </small>
                                </div>
                            </div>
                        <?php endwhile; ?>

                    <?php endif; ?>
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
            <h3 class="text-center mb-4 fw-bold">Related Questions</h3>
            <?php
            $query = "SELECT * FROM questions WHERE category_id = $categoryId AND id != $questionId ORDER BY id DESC";
            $result = $conn->query($query);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $questionId = $row['id'];
            ?>

                    <div class="card mb-3 border-1 shadow-sm category-card">
                        <div class="card-body">
                            <h5 class="card-title fw-semibold text-dark">
                                <a href="?question_id=<?= $questionId ?>" class="text-decoration-none">
                                    <?= htmlspecialchars(ucfirst($row['title'])) ?>
                                </a>
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
                                No Related questions found
                            </p>
                        </h5>
                    </div>
                </div>
            <?php }
            ?>
        </div>
    </div>

</div>