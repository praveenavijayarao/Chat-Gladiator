<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Smart Gladi</title>
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
                                        <i class="fas fa-user-plus"></i>
                                        <h2>Join Smart Gladi</h2>
                                        <p>Create your account and start collaborating with your team today.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-section">
                                    <h2>Sign Up</h2>
                                    <p class="subtitle">Create your account to get started</p>
                                    <form id="signupForm">
                                        <div class="form-group">
                                            <label class="d-block">Full Name</label>
                                            <input type="text" class="form-control" name="name" placeholder="Enter your full name" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="d-block">Email Address</label>
                                            <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="d-block">Password</label>
                                            <input type="password" class="form-control" name="password" placeholder="Create a password" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-block mt-4">Sign Up</button>
                                    </form>
                                    <div class="text-center text-link mt-4">
                                        <p>Already have an account? <a href="<?= base_url('signin') ?>">Sign In</a></p>
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

        $('#signupForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '<?= base_url('auth/register') ?>',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        setTimeout(function() {
                            window.location.href = '<?= base_url('signin') ?>';
                        }, 1500);
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
