<div class="sidebar" id="sidebar">
    <div class="logo">
        <img src="{{ asset('admin/img/logo.png') }}" alt="Logo" class="logo-image">
    </div>

    <nav>

        {{-- Dashboard link --}}
        @can('dashboard-view')
            <a href="{{ route('home') }}"
               class="{{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="fas fa-home" style="font-size:15px;"></i>
                <span>Dashboard</span>
            </a>
        @endcan


        {{-- Booking links --}}
        @canany([
            'booking-list',
            'booking-create'
        ])
            <div class="sidebar-section">
                <div class="section-header">
                    <i class="fas fa-calendar-check"></i>
                    <span>Bookings</span>
                    <i class="fas fa-chevron-down toggle-icon"></i>
                </div>

                <div class="section-links">

                    {{-- Booking list --}}
                    @can('booking-list')
                        <a href="{{ route('bookings.index') }}"
                           class="{{ request()->routeIs('bookings.index') || request()->routeIs('bookings.show') ? 'active' : '' }}">
                            All Bookings
                        </a>

                        <a href="{{ route('bookings.today') }}"
                           class="{{ request()->routeIs('bookings.today') ? 'active' : '' }}">
                            Today's Bookings
                        </a>

                        <a href="{{ route('bookings.tomorrow') }}"
                           class="{{ request()->routeIs('bookings.tomorrow') ? 'active' : '' }}">
                            Tomorrow's Bookings
                        </a>
                    @endcan

                    {{-- Create booking --}}
                    @can('booking-create')
                        <a href="{{ route('bookings.create') }}"
                           class="{{ request()->routeIs('bookings.create') ? 'active' : '' }}">
                            New Booking
                        </a>
                    @endcan

                </div>
            </div>
        @endcanany


        {{-- Fleet management --}}
        @canany([
            'vehicle-list',
            'vehicle-create',
            'vehicle-edit',
            'vehicle-delete',
            'vehicle-export',
            'driver-list',
            'driver-create',
            'driver-edit',
            'driver-delete',
            'driver-export'
        ])
            <div class="sidebar-section">
                <div class="section-header">
                    <i class="fas fa-car"></i>
                    <span>Fleet Management</span>
                    <i class="fas fa-chevron-down toggle-icon"></i>
                </div>

                <div class="section-links">

                    {{-- Vehicle links --}}
                    @canany([
                        'vehicle-list',
                        'vehicle-create',
                        'vehicle-edit',
                        'vehicle-delete',
                        'vehicle-export'
                    ])
                        <a href="{{ route('vehicles.index') }}"
                           class="{{ request()->routeIs('vehicles.*') ? 'active' : '' }}">
                            Vehicles
                        </a>
                    @endcanany

                    {{-- Driver links --}}
                    @canany([
                        'driver-list',
                        'driver-create',
                        'driver-edit',
                        'driver-delete',
                        'driver-export'
                    ])
                        <a href="{{ route('drivers.index') }}"
                           class="{{ request()->routeIs('drivers.*') ? 'active' : '' }}">
                            Drivers
                        </a>
                    @endcanany

                </div>
            </div>
        @endcanany


        {{-- Document links --}}
        @canany([
            'driver-document-list',
            'driver-document-create',
            'driver-document-edit',
            'driver-document-delete',
            'driver-document-view',
            'driver-document-download',

            'staff-document-list',
            'staff-document-create',
            'staff-document-edit',
            'staff-document-delete',
            'staff-document-view',
            'staff-document-download'
        ])
            <div class="sidebar-section">
                <div class="section-header">
                    <i class="fas fa-file-contract"></i>
                    <span>Documents</span>
                    <i class="fas fa-chevron-down toggle-icon"></i>
                </div>

                <div class="section-links">

                    {{-- Driver documents --}}
                    @canany([
                        'driver-document-list',
                        'driver-document-create',
                        'driver-document-edit',
                        'driver-document-delete',
                        'driver-document-view',
                        'driver-document-download'
                    ])
                        <a href="{{ route('documents.driver.index') }}"
                           class="{{ request()->routeIs('documents.driver.*') ? 'active' : '' }}">
                            Driver Documents
                        </a>
                    @endcanany

                    {{-- Staff documents --}}
                    @canany([
                        'staff-document-list',
                        'staff-document-create',
                        'staff-document-edit',
                        'staff-document-delete',
                        'staff-document-view',
                        'staff-document-download'
                    ])
                        <a href="{{ route('documents.staff.index') }}"
                           class="{{ request()->routeIs('documents.staff.*') ? 'active' : '' }}">
                            Staff Documents
                        </a>
                    @endcanany

                </div>
            </div>
        @endcanany


        {{-- Asset links --}}
        @canany([
            'pos-machine-list',
            'pos-machine-create',
            'pos-machine-edit',
            'pos-machine-delete',
            'pos-machine-view',
            'pos-machine-download',

            'mobile-phone-list',
            'mobile-phone-create',
            'mobile-phone-edit',
            'mobile-phone-delete',
            'mobile-phone-view',
            'mobile-phone-download',

            'sim-card-list',
            'sim-card-create',
            'sim-card-edit',
            'sim-card-delete',
            'sim-card-view',
            'sim-card-download'
        ])
            <div class="sidebar-section">
                <div class="section-header">
                    <i class="fas fa-laptop"></i>
                    <span>Assets</span>
                    <i class="fas fa-chevron-down toggle-icon"></i>
                </div>

                <div class="section-links">

                    {{-- POS machine links --}}
                    @canany([
                        'pos-machine-list',
                        'pos-machine-create',
                        'pos-machine-edit',
                        'pos-machine-delete',
                        'pos-machine-view',
                        'pos-machine-download'
                    ])
                        <a href="{{ route('assets.pos-machines.index') }}"
                           class="{{ request()->routeIs('assets.pos-machines.*') ? 'active' : '' }}">
                            POS Machines
                        </a>
                    @endcanany

                    {{-- Mobile phone links --}}
                    @canany([
                        'mobile-phone-list',
                        'mobile-phone-create',
                        'mobile-phone-edit',
                        'mobile-phone-delete',
                        'mobile-phone-view',
                        'mobile-phone-download'
                    ])
                        <a href="{{ route('assets.mobile-phones.index') }}"
                           class="{{ request()->routeIs('assets.mobile-phones.*') ? 'active' : '' }}">
                            Mobile Phones
                        </a>
                    @endcanany

                    {{-- SIM card links --}}
                    @canany([
                        'sim-card-list',
                        'sim-card-create',
                        'sim-card-edit',
                        'sim-card-delete',
                        'sim-card-view',
                        'sim-card-download'
                    ])
                        <a href="{{ route('assets.sim-cards.index') }}"
                           class="{{ request()->routeIs('assets.sim-cards.*') ? 'active' : '' }}">
                            SIM Cards
                        </a>
                    @endcanany

                </div>
            </div>
        @endcanany


        {{-- Staff links --}}
        @canany([
            'staff-list',
            'staff-create',
            'staff-edit',
            'staff-delete'
        ])
            <div class="sidebar-section">
                <div class="section-header">
                    <i class="fas fa-users"></i>
                    <span>People</span>
                    <i class="fas fa-chevron-down toggle-icon"></i>
                </div>

                <div class="section-links">

                    @canany([
                        'staff-list',
                        'staff-create',
                        'staff-edit',
                        'staff-delete'
                    ])
                        <a href="{{ route('staff.index') }}"
                           class="{{ request()->routeIs('staff.*') ? 'active' : '' }}">
                            Staff
                        </a>
                    @endcanany

                </div>
            </div>
        @endcanany


        {{-- User and role links --}}
        @canany([
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'user-export',

            'role-list',
            'role-create',
            'role-edit',
            'role-delete'
        ])
            <div class="sidebar-section">
                <div class="section-header">
                    <i class="fas fa-user-shield"></i>
                    <span>Masters</span>
                    <i class="fas fa-chevron-down toggle-icon"></i>
                </div>

                <div class="section-links">

                    {{-- User links --}}
                    @canany([
                        'user-list',
                        'user-create',
                        'user-edit',
                        'user-delete',
                        'user-export'
                    ])
                        <a href="{{ route('users.index') }}"
                           class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                            Manage Users
                        </a>
                    @endcanany


                    {{-- Role links --}}
                    @canany([
                        'role-list',
                        'role-create',
                        'role-edit',
                        'role-delete'
                    ])
                        <a href="{{ route('roles.index') }}"
                           class="{{ request()->routeIs('roles.*') ? 'active' : '' }}">
                            Roles
                        </a>
                    @endcanany

                </div>
            </div>
        @endcanany


        {{-- Logout button --}}
        <form method="POST"
              action="{{ route('logout') }}"
              style="margin-top: auto;">
            @csrf

            <button type="submit" class="sidebar-logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </form>

    </nav>


    <button class="menu-toggle" id="menuToggle">
        <i class="fas fa-bars"></i>
    </button>

</div>


<style>
/* Collapsible sidebar */

.sidebar-section {
    margin-bottom: 10px;
}

.section-header {
    display: flex;
    align-items: center;
    padding: 12px 15px;
    cursor: pointer;
    color: #e8e8e8;
    font-weight: 500;
    transition: all 0.3s ease;
    font-size: 14px;
}

.section-header:hover {
    background: rgba(78, 205, 196, 0.15);
}

.section-header i:first-child {
    margin-right: 10px;
    width: 20px;
    text-align: center;
    color: #4ecdc4;
    font-size: 14px;
}

.toggle-icon {
    margin-left: auto;
    transition: transform 0.3s ease;
    font-size: 12px;
    color: #4ecdc4;
}

.section-header.active .toggle-icon {
    transform: rotate(180deg);
}

.section-links {
    display: none;
    padding-left: 20px;
}

.section-header.active + .section-links {
    display: block;
}

.section-links a {
    padding: 10px 15px;
    font-size: 14px;
    padding-left: 15px;
    margin-bottom: 5px;
    color: #a0aec0;
    text-decoration: none;
    display: block;
    transition: all 0.2s ease;
}

.section-links a:hover,
.section-links a.active {
    background: rgba(78, 205, 196, 0.1);
    color: #e8e8e8;
}


/* Sidebar divider */

.sidebar-divider {
    height: 1px;
    background: rgba(255,255,255,0.1);
    margin: 10px 0;
    width: 100%;
}


/* Collapsed sidebar */

.sidebar.collapsed .section-header span,
.sidebar.collapsed .toggle-icon {
    display: none;
}

.sidebar.collapsed .section-header {
    justify-content: center;
    padding: 12px;
}

.sidebar.collapsed .section-header i:first-child {
    margin-right: 0;
    font-size: 18px;
}

.sidebar.collapsed .section-links {
    display: none !important;
}


/* Logout button */

.sidebar-logout-btn {
    display: flex;
    align-items: center;
    padding: 12px 15px;
    width: 100%;
    border: none;
    background: none;
    color: #e8e8e8;
    cursor: pointer;
    transition: background 0.2s;
    text-align: left;
    font-size: 14px;
}

.sidebar-logout-btn i {
    margin-right: 10px;
    color: #4ecdc4;
    width: 20px;
    text-align: center;
    font-size: 14px;
}

.sidebar-logout-btn:hover {
    background: rgba(78, 205, 196, 0.15);
}


/* Top level links */

.sidebar nav > a {
    font-size: 14px;
}

.sidebar nav > a i {
    font-size: 14px;
}
</style>


<script>
document.addEventListener('DOMContentLoaded', function() {

    const sidebar = document.getElementById('sidebar');
    const menuToggle = document.getElementById('menuToggle');

    /* Toggle sidebar */

    menuToggle.addEventListener('click', function() {
        sidebar.classList.toggle('collapsed');
    });


    /* AUTO COLLAPSE ON SMALL SCREENS */

    if (window.innerWidth < 768) {
        sidebar.classList.add('collapsed');
    }


    window.addEventListener('resize', function() {
        if (window.innerWidth < 768) {
            sidebar.classList.add('collapsed');
        } else {
            sidebar.classList.remove('collapsed');
        }
    });


    /* Toggle sidebar sections */

    const sectionHeaders = document.querySelectorAll('.section-header');

    sectionHeaders.forEach(header => {

        header.addEventListener('click', function() {

            if (!sidebar.classList.contains('collapsed')) {

                this.classList.toggle('active');

                // Close other sections
                if (this.classList.contains('active')) {

                    sectionHeaders.forEach(otherHeader => {

                        if (
                            otherHeader !== this &&
                            otherHeader.classList.contains('active')
                        ) {
                            otherHeader.classList.remove('active');
                        }

                    });

                }

            }

        });

    });


    /* Expand active section */

    const currentPath = window.location.pathname;
    let activeSectionFound = false;

    document.querySelectorAll('.section-links a').forEach(link => {

        const linkPath = new URL(link.href).pathname;

        if (
            linkPath === currentPath ||
            (
                linkPath !== '/' &&
                currentPath.startsWith(linkPath)
            )
        ) {

            link.classList.add('active');

            const sectionLinks = link.closest('.section-links');

            const sectionHeader =
                link.closest('.sidebar-section')
                    .querySelector('.section-header');

            sectionLinks.style.display = 'block';
            sectionHeader.classList.add('active');

            activeSectionFound = true;
        }

    });


    /* ACTIVE TOP LEVEL LINKS */

    if (!activeSectionFound) {

        document.querySelectorAll('.sidebar nav > a').forEach(link => {

            const linkPath = new URL(link.href).pathname;

            if (linkPath === currentPath) {
                link.classList.add('active');
            }

        });

    }

});
</script>