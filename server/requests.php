<?php
session_start();
include '../common/db.php';

/**  Signup */
if (isset($_POST['signup'])) {

    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $address  = trim($_POST['address']);

    // 🔍 Check if email already exists
    $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        $_SESSION['error'] = "Email already registered!";
        header("Location: ../index.php?signup=true");
        exit;
    }

    // ✅ Insert new user
    $stmt = $conn->prepare("INSERT INTO users (username,email,password,address) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss", $username, $email, $password, $address);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Signup success";
        header("Location: ../index.php?login=true");
        exit;
    } else {
        $_SESSION['error'] = "Signup failed!";
        header("Location: ../index.php?signup=true");
        exit;
    }
}

/**  Login */
if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $user = $res->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                "username" => $user['username'],
                "email" => $user['email'],
                "user_id" => $user['id']
            ];
            $_SESSION['success'] = "Login success";
            header("Location: ../index.php");
            exit;
        } else {
            $_SESSION['error'] = "Wrong password";
            header("Location: ../index.php?login=true");
            exit;
        }
    } else {
        $_SESSION['error'] = "User not found";
        header("Location: ../index.php?login=true");
        exit;
    }
}

/**  Logout */
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../index.php");
}

/**  Insert new question */
if (isset($_POST['askQuestion'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $category_id = trim($_POST['category_id']);
    $user_id = $_SESSION['user']['user_id'];

    $stmt = $conn->prepare("INSERT INTO questions (title,description,category_id,user_id) VALUES (?,?,?,?)");
    $stmt->bind_param("ssii", $title, $description, $category_id, $user_id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Question added successfully";
        header("Location: ../index.php");
        exit;
    } else {
        $_SESSION['error'] = "Question adding failed!";
        header("Location: ../index.php?ask=true");
        exit;
    }
}

/** Submit Question_details Answer */
if (isset($_POST['submitAnswer'])) {

    $question_id = intval($_POST['question_id']);
    $answer = trim($_POST['answer']);
    $user_id = $_SESSION['user']['user_id'] ?? null;

    if (empty($answer)) {
        $_SESSION['error'] = "Answer cannot be empty";
        header("Location: ../index.php?question_id=$question_id");
        exit;
    }

    // 🔒 MUST check login
    if (!isset($_SESSION['user'])) {
        $_SESSION['error'] = "Please login first!";
        header("Location: ../index.php?login=true");
        exit;
    }

    // 🔒 Prevent duplicate answer
    $check = $conn->prepare("
        SELECT id FROM answers 
        WHERE question_id = ? AND user_id = ? AND answer = ?
    ");
    $check->bind_param("iis", $question_id, $user_id, $answer);
    $check->execute();
    $res = $check->get_result();

    if ($res->num_rows > 0) {
        $_SESSION['error'] = "Duplicate answer detected!";
        header("Location: ../index.php?question_id=$question_id");
        exit;
    }

    // ✅ Insert answer
    $stmt = $conn->prepare("
        INSERT INTO answers (question_id, answer, user_id) 
        VALUES (?, ?, ?)
    ");
    $stmt->bind_param("isi", $question_id, $answer, $user_id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Answer added successfully";
    } else {
        $_SESSION['error'] = "Answer failed!";
    }

    // ✅ Redirect (PRG pattern)
    header("Location: ../index.php?question_id=$question_id");
    exit;
}


/** Delete Question and Answers */
if (isset($_GET['delete_question'])) {
    $question_id = intval($_GET['delete_question']);
    $user_id = $_SESSION['user']['user_id'];

    // 🔒 MUST check ownership
    $check = $conn->prepare("SELECT user_id FROM questions WHERE id = ?");
    $check->bind_param("i", $question_id);
    $check->execute();
    $res = $check->get_result();

    if ($res->num_rows === 0) {
        $_SESSION['error'] = "Question not found!";
        header("Location: ../index.php");
        exit;
    }

    $row = $res->fetch_assoc();
    if ($row['user_id'] != $user_id) {
        $_SESSION['error'] = "You can only delete your own questions!";
        header("Location: ../index.php");
        exit;
    }

    // Start transaction
    $conn->begin_transaction();

    try {
        // 1️⃣ Delete answers first (foreign key constraint)
        $stmtAns = $conn->prepare("DELETE FROM answers WHERE question_id = ?");
        $stmtAns->bind_param("i", $question_id);
        $stmtAns->execute();

        // 2️⃣ Delete question
        $stmtQues = $conn->prepare("DELETE FROM questions WHERE id = ?");
        $stmtQues->bind_param("i", $question_id);
        $stmtQues->execute();

        // Commit transaction
        $conn->commit();
        $_SESSION['success'] = "Question and answers deleted successfully";
    } catch (Exception $e) {
        // Rollback on error
        $conn->rollback();
        $_SESSION['error'] = "Delete failed: " . $e->getMessage();
    }

    header("Location: ../index.php");
    exit;
}
