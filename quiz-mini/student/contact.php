<?php 
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Share Your Feedback</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>📧</text></svg>">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Custom CSS -->
  
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --success-color: #198754;
            --info-color: #0dcaf0;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --light-color: #f8f9fa;
            --dark-color: #212529;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .contact-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            margin-top: 2rem;
            margin-bottom: 2rem;
        }

        .contact-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .contact-header h1 {
            color: var(--dark-color);
            font-weight: 700;
            margin-bottom: 1rem;
            position: relative;
        }

        .contact-header h1::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--info-color));
            border-radius: 2px;
        }

        .subtitle {
            color: var(--secondary-color);
            font-size: 1.1rem;
            margin-bottom: 0;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 0.875rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #fff;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
            background-color: #fff;
        }

        .form-control::placeholder {
            color: #adb5bd;
            opacity: 0.8;
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--primary-color) 0%, #0056b3 100%);
            border: none;
            padding: 0.875rem 2.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 12px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0 auto;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(13, 110, 253, 0.4);
            background: linear-gradient(135deg, #0056b3 0%, var(--primary-color) 100%);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .form-floating {
            margin-bottom: 1.5rem;
        }

        .contact-info {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 15px;
            padding: 1.5rem;
            margin-top: 2rem;
            text-align: center;
        }

        .contact-info h5 {
            color: var(--dark-color);
            margin-bottom: 1rem;
        }

        .contact-info p {
            color: var(--secondary-color);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .floating-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .floating-element {
            position: absolute;
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }

        .floating-element:nth-child(1) {
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-element:nth-child(2) {
            top: 20%;
            right: 10%;
            animation-delay: 2s;
        }

        .floating-element:nth-child(3) {
            bottom: 10%;
            left: 20%;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(10deg);
            }
        }

        @media (max-width: 768px) {
            .contact-container {
                padding: 1.5rem;
                margin: 1rem;
                border-radius: 15px;
            }
            
            .contact-header h1 {
                font-size: 2rem;
            }
        }

        .required-asterisk {
            color: var(--danger-color);
            margin-left: 2px;
        }

        .form-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--secondary-color);
            z-index: 5;
        }
    </style>
</head>
<body>
    <!-- Floating Background Elements -->
    <div class="floating-elements">
        <div class="floating-element">
            <i class="bi bi-envelope-heart" style="font-size: 3rem; color: #0d6efd;"></i>
        </div>
        <div class="floating-element">
            <i class="bi bi-chat-dots" style="font-size: 2.5rem; color: #0dcaf0;"></i>
        </div>
        <div class="floating-element">
            <i class="bi bi-telephone" style="font-size: 2rem; color: #198754;"></i>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="contact-container">
                    <div class="contact-header">
                        <h1><i class="bi bi-chat-square-heart me-2"></i>Share Your Feedback</h1>
                        <p class="subtitle">Drop your questions or suggestions below, We'll get back soon.</p>
                    </div>

                    <form action="contact_process.php" method="post" class="needs-validation" novalidate>
                        <div class="form-group">
                            <label for="name" class="form-label">
                                <i class="bi bi-person-circle"></i>
                                Your Name
                                <span class="required-asterisk">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="name" 
                                   name="name" 
                                   required 
                                   placeholder="Enter your full name"
                                   minlength="2">
                            <i class="bi bi-person input-icon"></i>
                            <div class="invalid-feedback">
                                Please provide a valid name (minimum 2 characters).
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope-at"></i>
                                Email Address
                                <span class="required-asterisk">*</span>
                            </label>
                            <input type="email" 
                                   class="form-control" 
                                   id="email" 
                                   name="email" 
                                   required 
                                   placeholder="Enter your email address">
                            <i class="bi bi-envelope input-icon"></i>
                            <div class="invalid-feedback">
                                Please provide a valid email address.
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="message" class="form-label">
                                <i class="bi bi-chat-left-text"></i>
                                Message
                                <span class="required-asterisk">*</span>
                            </label>
                            <textarea class="form-control" 
                                      id="message" 
                                      name="message" 
                                      rows="6" 
                                      required 
                                      placeholder="Type your message, questions, or suggestions here..."
                                      minlength="10"></textarea>
                            <i class="bi bi-chat-dots input-icon" style="top: 20%;"></i>
                            <div class="invalid-feedback">
                                Please provide a message (minimum 10 characters).
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-submit">
                                <i class="bi bi-send"></i>
                                Send Message
                            </button>
                        </div>
                    </form>

                    <div class="contact-info">
                        <h5><i class="bi bi-info-circle me-2"></i>Get in Touch</h5>
                        <p><i class="bi bi-clock"></i>We typically respond within 24 hours</p>
                        <p><i class="bi bi-shield-check"></i>Your information is secure and confidential</p>
                        <p><i class="bi bi-heart"></i>Thank you for taking the time to reach out!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript for form validation and enhancement -->
    <script>
        // Bootstrap form validation
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        } else {
                            // Show loading state
                            const submitBtn = form.querySelector('.btn-submit');
                            const originalText = submitBtn.innerHTML;
                            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Sending...';
                            submitBtn.disabled = true;
                            
                            // Re-enable after 3 seconds (for demo purposes)
                            setTimeout(() => {
                                submitBtn.innerHTML = originalText;
                                submitBtn.disabled = false;
                            }, 3000);
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        // Add real-time validation feedback
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.form-control');
            
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.checkValidity()) {
                        this.classList.add('is-valid');
                        this.classList.remove('is-invalid');
                    } else {
                        this.classList.add('is-invalid');
                        this.classList.remove('is-valid');
                    }
                });
                
                input.addEventListener('input', function() {
                    if (this.classList.contains('was-validated') || this.classList.contains('is-invalid')) {
                        if (this.checkValidity()) {
                            this.classList.add('is-valid');
                            this.classList.remove('is-invalid');
                        } else {
                            this.classList.add('is-invalid');
                            this.classList.remove('is-valid');
                        }
                    }
                });
            });
        });

        // Character counter for textarea
        document.getElementById('message').addEventListener('input', function() {
            const maxLength = 1000;
            const currentLength = this.value.length;
            
            if (!document.querySelector('.char-counter')) {
                const counter = document.createElement('small');
                counter.className = 'char-counter text-muted';
                counter.style.float = 'right';
                this.parentNode.appendChild(counter);
            }
            
            const counter = document.querySelector('.char-counter');
            counter.textContent = `${currentLength}/${maxLength} characters`;
            
            if (currentLength > maxLength * 0.9) {
                counter.className = 'char-counter text-warning';
            } else {
                counter.className = 'char-counter text-muted';
            }
        });
    </script>
</body>
</html>