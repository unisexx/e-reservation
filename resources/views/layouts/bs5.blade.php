<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ปฏิทินงาน</title>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@5.5.1/main.min.css'>
    <!-- bootstrap V5 -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css' rel='stylesheet' />
    <link href='https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.13.1/css/all.css' rel='stylesheet'>
    @stack('css')
</head>
<body>
    @yield('content')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar-scheduler@5.5.1/main.min.js'></script>
    @stack('js')
</body>
</html>
