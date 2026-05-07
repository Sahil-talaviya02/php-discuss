<!-- Main Content -->
<div class="container flex-grow-1 d-flex justify-content-center align-items-center py-5">

    <div class="card shadow-lg p-4" style="width: 400px; border-radius: 12px;">
        <h3 class="text-center mb-4">Login</h3>

        <form id="loginForm" action="server/requests.php" method="post">

            <!-- Email -->
            <div class="mb-3">
                <label class="form-label">Email address</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email">
                <small class="text-danger d-none" id="emailError">Valid email is required</small>
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label class="form-label d-flex justify-content-between">
                    <span>Password</span>
                    <span class="small text-muted" id="togglePassword" style="cursor:pointer;">Show</span>
                </label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password">
                <small class="text-danger d-none" id="passwordError">Password is required</small>
            </div>

            <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
        </form>

        <p class="text-center mt-3 mb-0">
            Don't have an account? <a href="?signup=true">Signup</a>
        </p>
    </div>

</div>

<script>
    $(document).ready(function() {

        // Toggle password show/hide
        $("#togglePassword").click(function() {
            let input = $("#password");
            let type = input.attr("type") === "password" ? "text" : "password";
            input.attr("type", type);
            $(this).text(type === "password" ? "Show" : "Hide");
        });

        // Form validation
        $("#loginForm").on("submit", function(e) {

            let isValid = true;

            let email = $("#email").val().trim();
            let password = $("#password").val().trim();

            // Reset errors
            $("small.text-danger").addClass("d-none");

            // Email validation
            let emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,}$/;
            if (!email.match(emailPattern)) {
                $("#emailError").removeClass("d-none");
                isValid = false;
            }

            // Password validation
            if (password === "") {
                $("#passwordError").removeClass("d-none");
                isValid = false;
            }

            // Stop submit if invalid
            if (!isValid) {
                e.preventDefault();
            }
        });

    });
</script>