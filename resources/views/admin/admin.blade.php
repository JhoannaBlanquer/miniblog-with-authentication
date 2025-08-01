<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Dashboard</title>

    @viteReactRefresh
    @vite('resources/js/app.jsx')
</head>
<body class="bg-gray-50 text-gray-900">

 
    @auth
        <script>
            window.authUser = @json(auth()->user());
        </script>
    @endauth

    <div id="app"></div> 

</body>
</html>