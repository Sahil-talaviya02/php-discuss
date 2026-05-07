<div class="container">


    <?php
    include "./common/db.php";

    if (isset($_GET['user_id'])) {
    } else {
        echo "<h3 class='text-center mb-4 fw-bold'>Category</h3>";

        $query = "SELECT * FROM category";

        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $categoryId = $row['id'];
    ?>

                <div class="card mb-3 border-1 shadow-sm category-card">
                    <div class="card-body" id="categoryList">
                        <h5 class="card-title fw-semibold text-dark">
                            <a href="?category_id=<?= $categoryId ?>" class="text-decoration-none">
                                <?= htmlspecialchars(ucfirst($row['name'])) ?>
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
                            No categories found
                        </p>
                    </h5>
                </div>
            </div>
    <?php }
    }

    ?>
</div>