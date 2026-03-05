<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Gladiator</title>
    <link rel="icon" type="image/png" href="<?= base_url('images/logo.png') ?>">
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
        .left-content h1 { font-size: 48px; font-weight: 700; margin-bottom: 20px; color: #fff; }
        .left-content p { font-size: 18px; color: rgba(255,255,255,0.9); line-height: 1.8; margin-bottom: 40px; }
        .right-side { flex: 1; background: #0f1425; display: flex; align-items: center; justify-content: center; padding: 40px; overflow-y: auto; }
        .signup-form { max-width: 450px; width: 100%; }
        .signup-form h2 { color: #4a90e2; font-size: 36px; font-weight: 700; margin-bottom: 10px; text-align: center; }
        .signup-form .subtitle { color: #8892b0; margin-bottom: 40px; font-size: 15px; text-align: center; }
        .signup-form .form-control { padding: 15px 18px; font-size: 16px; height: auto; }
        .signup-form .btn { padding: 15px; font-size: 16px; font-weight: 600; }
        .signup-form label { font-size: 16px; font-weight: 500; }
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
                <p>Join us and start collaborating with your team</p>
            </div>
        </div>
        <div class="right-side">
            <div class="signup-form">
                <h2>Create Account</h2>
                <p class="subtitle">Sign up to get started</p>
                <form id="signupForm">
                    <div class="form-group">
                        <label><i class="fas fa-user" style="margin-right: 8px;"></i>Full Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Enter your full name" required>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-envelope" style="margin-right: 8px;"></i>Email Address</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-lock" style="margin-right: 8px;"></i>Password</label>
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
                events: { onhover: { enable: true, mode: ['grab', 'bubble'] }, onclick: { enable: true, mode: 'push' }, resize: true },
                modes: { 
                    grab: { distance: 200, line_linked: { opacity: 0.8 } },
                    bubble: { distance: 200, size: 6, duration: 0.3, opacity: 0.8 },
                    repulse: { distance: 100, duration: 0.4 }, 
                    push: { particles_nb: 4 } 
                }
            },
            retina_detect: true
        });

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
