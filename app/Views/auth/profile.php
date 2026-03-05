<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Smart Gladi</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="<?= base_url('css/theme.css') ?>">
    <style>
        body {
            background-color: #f5f5f5;
        }
        .profile-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 200px;
            position: relative;
        }
        .profile-avatar {
            position: absolute;
            bottom: -60px;
            left: 40px;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: #fff;
            border: 5px solid #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .profile-avatar i {
            font-size: 80px;
            color: #999;
        }
        .edit-avatar {
            position: absolute;
            bottom: 10px;
            right: 10px;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: #fff;
            border: 2px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        .profile-content {
            margin-top: 80px;
            padding: 20px 40px;
        }
        .profile-name {
            font-size: 28px;
            font-weight: bold;
            color: #333;
        }
        .profile-role {
            color: #999;
            font-size: 16px;
        }
        .profile-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }
        .info-item {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .info-icon {
            font-size: 24px;
            color: #667eea;
        }
        .info-label {
            font-size: 14px;
            color: #999;
            margin-bottom: 5px;
        }
        .info-value {
            font-size: 16px;
            color: #333;
            font-weight: 500;
        }
    </style>
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

    <div class="profile-header">
        <div class="profile-avatar">
            <i class="fas fa-user"></i>
            <div class="edit-avatar">
                <i class="fas fa-pen" style="font-size: 14px; color: #333;"></i>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="profile-content">
            <div class="profile-name"><?= session()->get('user_name') ?></div>
            <div class="profile-role">User</div>

            <div class="profile-info">
                <div class="info-item">
                    <i class="fas fa-envelope info-icon"></i>
                    <div>
                        <div class="info-label">Official Email</div>
                        <div class="info-value"><?= session()->get('user_email') ?></div>
                    </div>
                </div>
                <div class="info-item">
                    <i class="fas fa-calendar info-icon"></i>
                    <div>
                        <div class="info-label">DOB</div>
                        <div class="info-value">Not Set</div>
                    </div>
                </div>
                <div class="info-item">
                    <i class="fas fa-phone info-icon"></i>
                    <div>
                        <div class="info-label">Contact Us</div>
                        <div class="info-value">Not Set</div>
                    </div>
                </div>
                <div class="info-item">
                    <i class="fas fa-map-marker-alt info-icon"></i>
                    <div>
                        <div class="info-label">Work Location</div>
                        <div class="info-value">Not Set</div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <a href="<?= base_url('/') ?>" class="btn btn-secondary"><i class="fas fa-arrow-left mr-2"></i>Back to Home</a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</body>
</html>
