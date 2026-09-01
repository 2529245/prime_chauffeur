{{-- Show alert messages --}}
@if (Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <div class="alert-content">
            <div class="alert-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="alert-message">
                <strong>Success!</strong> {{ session('success') }}
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
@endif

@if (Session::has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <div class="alert-content">
            <div class="alert-icon">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <div class="alert-message">
                <strong>Error!</strong> {{ session('error') }}
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
@endif

@if (Session::has('warning'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <div class="alert-content">
            <div class="alert-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="alert-message">
                <strong>Warning!</strong> {{ session('warning') }}
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
@endif

@if (Session::has('info'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <div class="alert-content">
            <div class="alert-icon">
                <i class="fas fa-info-circle"></i>
            </div>
            <div class="alert-message">
                <strong>Info!</strong> {{ session('info') }}
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
@endif

<style>
    .alert {
        border: none;
        border-radius: 12px;
        padding: 0;
        margin-bottom: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        backdrop-filter: blur(8px);
        border: 1px solid transparent;
    }

    .alert-content {
        display: flex;
        align-items: center;
        padding: 16px 20px;
        position: relative;
    }

    .alert-icon {
        margin-right: 15px;
        font-size: 20px;
        display: flex;
        align-items: center;
    }

    .alert-message {
        flex: 1;
        font-size: 14px;
        font-weight: 500;
        line-height: 1.4;
    }

    .alert-message strong {
        font-weight: 600;
    }

    .alert-success {
        background: rgba(78, 205, 196, 0.15);
        border-color: rgba(78, 205, 196, 0.3);
    }

    .alert-success .alert-icon {
        color: #4ecdc4;
    }

    .alert-success .alert-message {
        color: #4ecdc4;
    }

    .alert-danger {
        background: rgba(255, 107, 107, 0.15);
        border-color: rgba(255, 107, 107, 0.3);
    }

    .alert-danger .alert-icon {
        color: #ff6b6b;
    }

    .alert-danger .alert-message {
        color: #ff6b6b;
    }

    .alert-warning {
        background: rgba(255, 177, 66, 0.15);
        border-color: rgba(255, 177, 66, 0.3);
    }

    .alert-warning .alert-icon {
        color: #ffb142;
    }

    .alert-warning .alert-message {
        color: #ffb142;
    }

    .alert-info {
        background: rgba(66, 153, 225, 0.15);
        border-color: rgba(66, 153, 225, 0.3);
    }

    .alert-info .alert-icon {
        color: #4299e1;
    }

    .alert-info .alert-message {
        color: #4299e1;
    }

    .close {
        background: none;
        border: none;
        padding: 0;
        margin-left: 15px;
        cursor: pointer;
        opacity: 0.7;
        transition: opacity 0.3s ease;
        color: inherit;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 24px;
        height: 24px;
        border-radius: 4px;
    }

    .close:hover {
        opacity: 1;
        background: rgba(255,255,255,0.1);
    }

    .alert-dismissible .close {
        position: static;
    }

    /* Alert entry animation */
    .alert.fade.show {
        animation: slideInDown 0.5s ease;
    }

    @keyframes slideInDown {
        from {
            transform: translateY(-20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Alert hover effect */
    .alert:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.25);
        transition: all 0.3s ease;
    }

    /* Responsive alert styles */
    @media (max-width: 768px) {
        .alert-content {
            padding: 14px 16px;
        }

        .alert-icon {
            font-size: 18px;
            margin-right: 12px;
        }

        .alert-message {
            font-size: 13px;
        }

        .close {
            font-size: 14px;
            width: 20px;
            height: 20px;
        }
    }

    @media (max-width: 576px) {
        .alert-content {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .alert-icon {
            margin-right: 0;
        }

        .close {
            position: absolute;
            top: 12px;
            right: 12px;
            margin-left: 0;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto close alerts
        const alerts = document.querySelectorAll('.alert-dismissible');
        
        alerts.forEach(alert => {
            setTimeout(() => {
                if (alert && alert.classList.contains('show')) {
                    const closeButton = alert.querySelector('.close');
                    if (closeButton) {
                        closeButton.click();
                    }
                }
            }, 5000);
        });

        // Animate alert closing
        const closeButtons = document.querySelectorAll('.alert .close');
        
        closeButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const alert = this.closest('.alert');
                
                alert.style.transform = 'translateY(-20px)';
                alert.style.opacity = '0';
                alert.style.transition = 'all 0.3s ease';
                
                setTimeout(() => {
                    alert.remove();
                }, 300);
            });
        });
    });
</script>