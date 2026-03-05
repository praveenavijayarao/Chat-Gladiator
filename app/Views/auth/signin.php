<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Smart Gladi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="<?= base_url('css/theme.css') ?>">
</head>
<body>
    <div class="container-fluid auth-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-9">
                    <div class="auth-card">
                        <div class="row no-gutters">
                            <div class="col-md-6">
                                <div class="image-section">
                                    <div class="image-content">
                                        <i class="fas fa-comments"></i>
                                        <h2>Welcome Back!</h2>
                                        <p>Sign in to continue your conversations and connect with your team.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-section">
                                    <h2>Sign In</h2>
                                    <p class="subtitle">Enter your credentials to access your account</p>
                                    <form id="signinForm">
                                        <div class="form-group">
                                            <label class="d-block">Email Address</label>
                                            <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="d-block">Password</label>
                                            <input type="password" class="form-control" name="password" placeholder="Enter your password" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-block mt-4">Sign In</button>
                                    </form>
                                    <div class="text-center text-link mt-4">
                                        <p>Don't have an account? <a href="<?= base_url('signup') ?>">Sign Up</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000"
        };

        $('#signinForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '<?= base_url('auth/login') ?>',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        setTimeout(function() {
                            window.location.href = '<?= base_url('/') ?>';
                        }, 1000);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function() {
                    toastr.error('An error occurred. Please try again.');
                }
            });
        });
    </script>
</body>
</html>
