<!-- Header layout -->
<div class="header">
    <div class="title">@yield('page-title', 'Management Dashboard')</div>

    <div class="user" style="position: relative;">
        <span id="userToggle" style="cursor:pointer; display:flex; align-items:center; gap:8px;">
            <i class="fas fa-user-circle"></i>
            <span>{{ Auth::user()->full_name ?? 'Admin User' }}</span>
        </span>

        <!-- User dropdown menu -->
        <div id="userDropdownMenu" style="display:none; position:absolute; top:40px; right:0; background: rgba(26,42,58,0.95); color:#e8e8e8; border:none; border-radius:8px; min-width:180px; z-index:1000; box-shadow:0 4px 10px rgba(0,0,0,0.3);">
            
            <!-- Profile link -->
            <a href="{{ route('profile.detail') }}" style="color:#e8e8e8; display:flex; align-items:center; padding:10px 15px; text-decoration:none;">
                <i class="fas fa-user fa-sm fa-fw mr-2" style="color:#4ecdc4; margin-right:8px;"></i>
                Profile
            </a>

            <div class="dropdown-divider" style="border-color: rgba(255,255,255,0.1); margin:4px 0;"></div>

            <!-- Logout form -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="color:#e8e8e8; display:flex; align-items:center; padding:10px 15px; background:none; border:none; width:100%; text-align:left; cursor:pointer;">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2" style="color:#4ecdc4; margin-right:8px;"></i>
                    Logout
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // Toggle user menu
    document.addEventListener('DOMContentLoaded', function() {
        const userToggle = document.getElementById('userToggle');
        const dropdownMenu = document.getElementById('userDropdownMenu');

        userToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
        });

        // Close menu outside click
        document.addEventListener('click', function() {
            dropdownMenu.style.display = 'none';
        });
    });
</script>
