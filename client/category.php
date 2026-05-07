<select name="category_id" id="category_id" class="form-select">
    <option value="">Select Category</option>
    <?php
    include __DIR__ . '/../common/db.php';

    $query = "SELECT * FROM category";
    $result = $conn->query($query);

    foreach ($result as $row) {
        $id = $row['id'];
        
        $name = ucfirst($row['name']);
        echo "<option value='$id'> $name </option>";
    }
    ?>
</select>