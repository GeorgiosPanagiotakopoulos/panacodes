<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96" />
  <link rel="icon" type="image/svg+xml" href="/favicon.svg" />
  <link rel="shortcut icon" href="/favicon.ico" />
  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
  <meta name="apple-mobile-web-app-title" content="Panacodes" />
  <link rel="manifest" href="/site.webmanifest" />
  <title>{{ $title ?? 'Panacodes' }}</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])

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