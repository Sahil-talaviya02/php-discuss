<!-- Main Content -->
<div class="container flex-grow-1 d-flex justify-content-center align-items-center py-5">

    <div class="card shadow-lg p-4" style="width: 400px; border-radius: 12px;">
        <h3 class="text-center mb-4">Ask questions</h3>

        <form id="questionForm" action="server/requests.php" method="post">

            <!-- Title -->
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" id="title" class="form-control" placeholder="Enter your Question">
                <small class="text-danger d-none" id="titleError">Title is required</small>
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" id="description" rows="3" cols="30" class="form-control" placeholder="Enter your description"></textarea>
                <small class="text-danger d-none" id="descriptionError">Description is required</small>
            </div>

            <!-- Category -->
            <div class="mb-3">
                <label class="form-label">Category</label>
                <?php include 'category.php'; ?>
                <small class="text-danger d-none" id="categoryError">Category is required</small>
            </div>

            <button type="submit" name="askQuestion" class="btn btn-primary w-100">Ask Questions</button>
        </form>

    </div>

</div>