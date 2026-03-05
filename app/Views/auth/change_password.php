<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password - Smart Gladi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('css/theme.css') ?>">
</head>
<body>
    <div class="user-dropdown">
        <div class="dropdown">
            <button class="btn dropdown-toggle" type="button" id="userDropdown" data-toggle="dropdown">
                <i class="fas fa-user-circle" style="font-size: 20px;"></i>
                <span><?= session()->get('user_name') ?></span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="<?= base_url('profile') ?>">
                    <i class="fas fa-user"></i> Profile
                </a>
                <a class="dropdown-item" href="<?= base_url('change-password') ?>">
                    <i class="fas fa-key"></i> Change Password
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger" href="<?= base_url('auth/logout') ?>">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header p-4">
                        <h2 class="mb-0"><i class="fas fa-lock mr-2"></i>Change Password</h2>
                    </div>
                    <div class="card-body p-5">
                        <form id="passwordForm">
                            <div class="form-group">
                                <label class="d-block">Current Password</label>
                                <input type="password" class="form-control" name="current_password" placeholder="Enter current password" required>
                            </div>
                            <div class="form-group">
                                <label class="d-block">New Password</label>
                                <input type="password" class="form-control" name="new_password" placeholder="Enter new password" required>
                            </div>
                            <div class="form-group">
                                <label class="d-block">Confirm New Password</label>
                                <input type="password" class="form-control" name="confirm_password" placeholder="Confirm new password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block mt-4">Change Password</button>
                        </form>
                        <div class="text-center mt-4">
                            <a href="<?= base_url('/') ?>" class="text-link"><i class="fas fa-arrow-left mr-2"></i>Back to Home</a>
                        </div>
                        <div id="message" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $('#passwordForm').on('submit', function(e) {
            e.preventDefault();
            const newPassword = $('input[name="new_password"]').val();
            const confirmPassword = $('input[name="confirm_password"]').val();
            
            if (newPassword !== confirmPassword) {
                $('#message').html('<div class="alert alert-danger">Passwords do not match!</div>');
                return;
            }
            
            $.ajax({
                url: '<?= base_url('auth/updatePassword') ?>',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#message').html('<div class="alert alert-success">' + response.message + '</div>');
                        $('#passwordForm')[0].reset();
                    } else {
                        $('#message').html('<div class="alert alert-danger">' + response.message + '</div>');
                    }
                }
            });
        });
    </script>
</body>
</html>
