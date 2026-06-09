<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <title>{{ $title ?? 'Default Title' }}</title>
</head>
<body class="min-h-screen bg-gray-900">

    <div class="min-h-screen flex flex-col">
        <x-header/>

        <main class="flex flex-1 items-center justify-center px-6 py-20">
            {{ $slot }}
        </main>

        <x-footer/>
    </div>

    @session('success')
      <div
        x-data="{show: true}"
        x-init="setTimeout(() => show = false, 3000)"
        x-show="show"
        x-transition.opacity.duration.1000ms
        class="bg-gray-600 text-white px-4 py-3 absolute top-5 right-25 rounded-lg">
        {{ $value }}
      </div>
    @endsession

</body>
</html>