<!-- Main Content -->
<div class="container flex-grow-1 d-flex justify-content-center align-items-center py-5">

    <div class="card shadow-lg p-4" style="width: 400px; border-radius: 12px;">
        <h3 class="text-center mb-4">Signup</h3>

        <form id="signupForm" action="server/requests.php" method="post">

            <!-- Username -->
            <div class="mb-3">
                <label class="form-label">User Name</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Enter your user name">
                <small class="text-danger d-none" id="usernameError">Username is required</small>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label class="form-label">Email address</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email">
                <small class="text-danger d-none" id="emailError">Valid email is required</small>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password">
                <small class="text-danger d-none" id="passwordError">Minimum 6 characters</small>
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" id="confirmPassword" class="form-control" placeholder="Confirm password">
                <small class="text-danger d-none" id="confirmError">Passwords do not match</small>
            </div>

            <!-- Address -->
            <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" name="address" id="address" class="form-control" placeholder="Enter your address">
                <small class="text-danger d-none" id="addressError">Address is required</small>
            </div>

            <button type="submit" name="signup" class="btn btn-primary w-100">Create Account</button>
        </form>

        <p class="text-center mt-3 mb-0">
            Already have an account? <a href="?login=true">Login</a>
        </p>
    </div>

</div>

<script>
    $(document).ready(function() {

        $("#signupForm").on("submit", function(e) {

            let isValid = true;

            let username = $("#username").val().trim();
            let email = $("#email").val().trim();
            let password = $("#password").val().trim();
            let confirmPassword = $("#confirmPassword").val().trim();
            let address = $("#address").val().trim();

            // Reset errors
            $("small.text-danger").addClass("d-none");

            // Username
            if (username === "") {
                $("#usernameError").removeClass("d-none");
                isValid = false;
            }

            // Email
            let emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
            if (!email.match(emailPattern)) {
                $("#emailError").removeClass("d-none");
                isValid = false;
            }

            // Password
            if (password.length < 6) {
                $("#passwordError").removeClass("d-none");
                isValid = false;
            }

            // Confirm Password
            if (password !== confirmPassword) {
                $("#confirmError").removeClass("d-none");
                isValid = false;
            }

            // Address
            if (address === "") {
                $("#addressError").removeClass("d-none");
                isValid = false;
            }

            // Stop form submit if invalid
            if (!isValid) {
                e.preventDefault();
            }
        });

    });
</script>