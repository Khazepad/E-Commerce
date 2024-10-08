<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    @stack('styles')
</head>
<body>
    <header>
        <!-- Add your header content here -->
    </header>

    <nav>
        <!-- Add your navigation menu here -->
    </nav>

    <main>
        @yield('content')
    </main>

    <footer>
        <!-- Add your footer content here -->
    </footer>

    @stack('scripts')
</body>
</html>
