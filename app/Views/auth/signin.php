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
    <style>
        body { margin: 0; overflow: hidden; }
        .split-container { display: flex; height: 100vh; }
        .left-side { flex: 1; background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #4a90e2 100%); display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; }
        #particles-js { position: absolute; width: 100%; height: 100%; }
        .left-content { text-align: center; color: white; z-index: 1; padding: 60px; max-width: 500px; }
        .left-content i { font-size: 50px; margin-bottom: 25px; display: inline-block; background: rgba(255,255,255,0.15); padding: 20px; border-radius: 15px; }
        .icon-box { width: 120px; height: 120px; background: rgba(255,255,255,0.2); border-radius: 30px; display: flex; align-items: center; justify-content: center; margin: 0 auto 40px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); transform: rotate(45deg); backdrop-filter: blur(10px); }
        .icon-box i { font-size: 60px; color: white; transform: rotate(-45deg); }
        .left-content h1 { font-size: 48px; font-weight: 700; margin-bottom: 20px; color: #fff; }
        .left-content p { font-size: 18px; color: rgba(255,255,255,0.9); line-height: 1.8; margin-bottom: 40px; }
        .feature-list { text-align: left; display: inline-block; }
        .feature-item { display: flex; align-items: center; margin-bottom: 15px; color: #fff; }
        .feature-item i { width: 30px; height: 30px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px; color: #fff; font-size: 14px; }
        .right-side { flex: 1; background: #0f1425; display: flex; align-items: center; justify-content: center; padding: 40px; }
        .signin-form { max-width: 450px; width: 100%; }
        .signin-form h2 { color: #4a90e2; font-size: 36px; font-weight: 700; margin-bottom: 10px; text-align: center; }
        .signin-form .subtitle { color: #8892b0; margin-bottom: 40px; font-size: 15px; text-align: center; }
        .signin-form .form-control { padding: 15px 18px; font-size: 16px; height: auto; }
        .signin-form .btn { padding: 15px; font-size: 16px; font-weight: 600; }
        .signin-form label { font-size: 16px; font-weight: 500; }
        @media (max-width: 768px) { .split-container { flex-direction: column; } .left-side { min-height: 40vh; } .right-side { min-height: 60vh; } }
    </style>
</head>
<body>
    <div class="split-container">
        <div class="left-side">
            <div id="particles-js"></div>
            <div class="left-content">
                <i class="fas fa-comments"></i>
                <h1>Smart Gladiator</h1>
                <p>Connect and collaborate with your team</p>
            </div>
        </div>
        <div class="right-side">
            <div class="signin-form">
                <h2>Welcome Back</h2>
                <p class="subtitle">Sign in to continue to your account</p>
                <form id="signinForm">
                    <div class="form-group">
                        <label><i class="fas fa-envelope" style="margin-right: 8px;"></i>Email Address</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-lock" style="margin-right: 8px;"></i>Password</label>
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

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        particlesJS('particles-js', {
            particles: {
                number: { value: 80, density: { enable: true, value_area: 800 } },
                color: { value: '#ffffff' },
                shape: { type: 'circle' },
                opacity: { value: 0.5, random: false },
                size: { value: 3, random: true },
                line_linked: { enable: true, distance: 150, color: '#ffffff', opacity: 0.4, width: 1 },
                move: { enable: true, speed: 2, direction: 'none', random: false, straight: false, out_mode: 'out', bounce: false }
            },
            interactivity: {
                detect_on: 'canvas',
                events: { onhover: { enable: true, mode: 'repulse' }, onclick: { enable: true, mode: 'push' }, resize: true },
                modes: { repulse: { distance: 100, duration: 0.4 }, push: { particles_nb: 4 } }
            },
            retina_detect: true
        });

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
