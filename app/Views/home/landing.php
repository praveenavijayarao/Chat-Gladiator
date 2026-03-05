<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Gladiator</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('css/theme.css') ?>">
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow: hidden;
            background-color: #000;
            color: #fff;
        }
        .fullscreen-container {
            height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 20px;
            overflow: hidden;
        }
        .user-grid {
            flex: 1;
            overflow: hidden;
            margin-top: 20px;
        }
        .user-grid .row {
            height: 100%;
            overflow: hidden;
        }
        h2, h5 {
            color: #fff;
            font-weight: bold;
        }
        .card {
            background-color: #1a1a1a;
            border: 1px solid #333;
        }
        .card-body {
            padding: 10px;
        }
        .card-body strong {
            color: #fff;
            font-weight: bold;
            font-size: 14px;
        }
        .card-body small {
            color: #ccc;
            font-size: 11px;
        }
        .card-body i {
            font-size: 30px !important;
        }
        .user-dropdown {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
        .user-dropdown .btn {
            background: #1a1f3a;
            border: 2px solid #4a90e2;
            color: #fff;
            padding: 8px 20px;
            border-radius: 25px;
        }
        .user-dropdown .dropdown-menu {
            background: #1a1f3a;
            border: 2px solid #4a90e2;
            margin-top: 10px;
        }
        .user-dropdown .dropdown-item {
            color: #fff;
            padding: 10px 20px;
        }
        .user-dropdown .dropdown-item:hover {
            background: #4a90e2;
        }
        .user-dropdown .dropdown-item.text-danger {
            color: #ff4444 !important;
        }
    </style>
</head>
<body>
    <div class="user-dropdown">
        <div class="dropdown">
            <button class="btn dropdown-toggle" type="button" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user-circle" style="font-size: 20px;"></i>
                <span><?= session()->get('user_name') ?></span>
            </button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="<?= base_url('profile') ?>">
                    <i class="fas fa-user"></i> Profile
                </a>
                <a class="dropdown-item" href="<?= base_url('change-password') ?>">
                    <i class="fas fa-key"></i> Change Password
                </a>
                <div class="dropdown-divider" style="border-color: #333;"></div>
                <a class="dropdown-item text-danger" href="<?= base_url('auth/logout') ?>">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </div>
    <div class="fullscreen-container">
        <div class="text-center">
            <h2>Welcome, <?= session()->get('user_name') ?>!</h2>
            <a href="<?= base_url('chat') ?>" class="btn btn-primary mt-2"><i class="fas fa-comment-dots mr-2"></i>Go to Chat</a>
            <h5 class="mt-3"><i class="fas fa-users mr-2" style="color: #4a90e2;"></i>Available Users</h5>
        </div>
        
        <div class="user-grid">
            <div class="row">
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-2">
                            <div class="card user-chat-item" data-user-id="<?= $user['id'] ?>" style="cursor: pointer;">
                                <div class="card-body d-flex align-items-center">
                                    <i class="fas fa-user-circle mr-3" style="font-size: 40px; color: #4a90e2;"></i>
                                    <div>
                                        <strong class="d-block"><?= esc($user['name']) ?></strong>
                                        <small class="text-muted"><?= esc($user['email']) ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center text-muted">
                        <i class="fas fa-user-slash mr-2"></i>No other users available
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $('.user-chat-item').on('click', function() {
            const userId = $(this).data('user-id');
            window.location.href = '<?= base_url('chat') ?>?user=' + userId + '&focus=1';
        });
    </script>
</body>
</html>
