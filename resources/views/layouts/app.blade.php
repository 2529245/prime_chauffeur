<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Load Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Load Google fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Load dashboard styles -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    
    <style>
        /* Background image overlay */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('{{ asset('images/b2.jpg') }}') no-repeat center center;
            background-size: cover;
            opacity: 0.15;
            z-index: -1;
            pointer-events: none;
        }
    .pagination-info { color: #666; font-size: 14px; margin-bottom: 10px; }
    .pagination { display: flex; gap: 7px; list-style: none;color: #fff; }
    .pagination .page-item .page-link { padding: 8px 12px; border: 1px solid #ddd;color: #fff; }
    .pagination .page-item.active .page-link { background: #007bff; color: white; }
    </style>

    @stack('styles')
</head>
<body id="page-top">

    <!-- Main page wrapper -->
    <div id="wrapper">

        <!-- Load sidebar -->
        @include('common.sidebar')
        <!-- Sidebar ends -->

        <!-- Main page content -->
        <div class="main">

            <!-- Load page header -->
            @include('common.header')
            <!-- Header ends -->

            <!-- Show page content -->
            <div class="content">
                @yield('content')
@if(isset($orders) && method_exists($orders, 'links'))
    <div class="pagination-wrapper">
        <p class="pagination-info">
            Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} entries
        </p>
        {{ $orders->links() }}
    </div>
@endif
            </div>
            <!-- Page content ends -->

            <!-- Load page footer -->
            @include('common.footer')
            <!-- Footer ends -->

        </div>
        <!-- Main content ends -->

    </div>
    <!-- Page wrapper ends -->

    <!-- Scroll to top button -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal 
    @include('common.logout-modal')-->

    <!-- Load dashboard scripts -->
    <script src="{{ asset('js/dashboard.js') }}"></script>

    @stack('scripts')
</body>
</html>
