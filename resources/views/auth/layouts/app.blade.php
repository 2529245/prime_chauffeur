<!DOCTYPE html>
<html lang="en">

{{-- Load authentication head --}}
@include('auth.includes.head')

<body class="bg-gradient-primary">

    <div class="container" id="wrapper">

        {{-- Show authentication content --}}
        @yield('content')

    </div>

    {{-- Load authentication scripts --}}
    @include('auth.includes.scripts')

</body>

</html>