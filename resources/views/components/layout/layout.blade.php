<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <title>{{ $title ?? 'Default Title' }}</title>
</head>
<body>

<div class="bg-gray-900">
  <header class="absolute inset-x-0 top-0 z-50">
    <nav aria-label="Global" class="flex items-center justify-between p-6 lg:px-8">
      <div class="flex lg:flex-1">
        <a href="/" class="-m-1.5 p-1.5">
          <span class="sr-only">Panacodes</span>
          <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500" alt="" class="h-8 w-auto" />
        </a>
      </div>
      <div class="flex lg:hidden">
        <button type="button" command="show-modal" commandfor="mobile-menu" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-200">
          <span class="sr-only">Open main menu</span>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6">
            <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </button>
      </div>
      <div class="hidden lg:flex lg:gap-x-12">
        <a href="/about" class="text-sm/6 font-semibold text-zinc-400 transition hover:text-white">About me</a>
        <a href="/projects" class="text-sm/6 font-semibold text-zinc-400 transition hover:text-white">Projects</a>
        <a href="/contact" class="text-sm/6 font-semibold text-zinc-400 transition hover:text-white">Contact</a>
      </div>

      @guest
        <div class="hidden lg:flex lg:flex-1 lg:justify-end gap-x-8">
          <a href="/login" class="text-sm/6 font-semibold text-zinc-400 transition hover:text-white">Log in</a>
          <a href="/register" class="text-sm/6 font-semibold text-zinc-400 transition hover:text-white">Register</a>
        </div>
      @endguest

      @auth
      <div class="hidden lg:flex lg:flex-1 lg:justify-end gap-x-8">
          <form action="/logout" method="POST">
              @csrf
              <button type="submit" class="text-sm/6 font-semibold text-zinc-400 transition hover:text-white">
                  Log Out
              </button>
          </form>
      </div>
      @endauth
    </nav>
    <el-dialog>
      <dialog id="mobile-menu" class="backdrop:bg-transparent lg:hidden">
        <div tabindex="0" class="fixed inset-0 focus:outline-none">
          <el-dialog-panel class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-gray-900 p-6 sm:max-w-sm sm:ring-1 sm:ring-gray-100/10">
            <div class="flex items-center justify-between">
              <a href="#" class="-m-1.5 p-1.5">
                <span class="sr-only">Your Company</span>
                <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500" alt="" class="h-8 w-auto" />
              </a>
              <button type="button" command="close" commandfor="mobile-menu" class="-m-2.5 rounded-md p-2.5 text-gray-200">
                <span class="sr-only">Close menu</span>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon" aria-hidden="true" class="size-6">
                  <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </button>
            </div>
            <div class="mt-6 flow-root">
              <div class="-my-6 divide-y divide-white/10">
                <div class="space-y-2 py-6">
                  <a href="/about" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-white hover:bg-white/5">About me</a>
                  <a href="/projects" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-white hover:bg-white/5">Projects</a>
                  <a href="/contact" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-white hover:bg-white/5">Contact</a>
                </div>

                @guest
                  <div class="py-6">
                    <a href="/login#" class="-mx-3 block rounded-lg px-3 py-2.5 text-base/7 font-semibold text-white hover:bg-white/5">Log in</a>
                    <a href="/register" class="-mx-3 block rounded-lg px-3 py-2.5 text-base/7 font-semibold text-white hover:bg-white/5">Register</a>
                  </div>
                @endguest

                @auth
                  <div class="py-6">
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit" class="-mx-3 block rounded-lg px-3 py-2.5 text-base/7 font-semibold text-white hover:bg-white/5">
                            Log Out
                        </button>
                    </form>
                  </div>
                @endauth
              </div>
            </div>
          </el-dialog-panel>
        </div>
      </dialog>
    </el-dialog>
  </header>

  <div class="relative isolate px-6 pt-14 lg:px-8">
    <div aria-hidden="true" class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80">
      <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" class="relative left-[calc(50%-11rem)] aspect-1155/678 w-144.5 -translate-x-1/2 rotate-30 bg-linear-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-288.75"></div>
    </div>
    <div class="flex items-center justify-center min-h-screen px-6 py-20 sm:py-32 lg:py-48">
        {{ $slot }}
    </div>
    @session('success')
      <div
        x-data="{show: true}"
        x-init="setTimeout(() => show = false, 3000)"
        x-show="show"
        x-transition.opacity.duration.1000ms
        class="bg-gray-600 text-white px-4 py-3 absolute top-5 right-25 rounded-lg"
      >
        {{ $value }}
      </div>
    @endsession
    <footer class="border-t border-white/10">
      <div class="mx-auto max-w-7xl px-6 py-16 lg:px-8">
        <div class="flex justify-center gap-12 sm:gap-24 lg:gap-48">

            <!-- Navigation -->
            <div>
              <h4 class="text-sm font-semibold uppercase tracking-wider text-white">Navigation</h4>

              <ul class="mt-4 space-y-3">
                <li>
                  <a href="/" class="text-zinc-400 transition hover:text-white">Home</a>
                </li>

                <li>
                  <a href="/about" class="text-zinc-400 transition hover:text-white">About me</a>
                </li>

                <li>
                  <a href="/projects" class="text-zinc-400 transition hover:text-white">Projects</a>
                </li>

                <li>
                  <a href="/contact" class="text-zinc-400 transition hover:text-white">Contact</a>
                </li>
              </ul>
            </div>

            <!-- Socials -->
            <div>
              <h4 class="text-sm font-semibold uppercase tracking-wider text-white">Connect</h4>

              <div class="mt-4 flex flex-col items-center gap-5">
                <!-- GitHub -->
                <a href="https://github.com/GeorgiosPanagiotakopoulos" target="_blank" class="text-zinc-400 transition hover:text-white">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="h-6 w-6">
                      <path d="M12 .5C5.65.5.5 5.65.5 12a11.5 11.5 0 0 0 7.86 10.93c.58.11.79-.25.79-.56v-2.01c-3.2.69-3.87-1.36-3.87-1.36-.52-1.32-1.28-1.67-1.28-1.67-1.05-.72.08-.7.08-.7 1.16.08 1.77 1.2 1.77 1.2 1.03 1.76 2.7 1.25 3.36.95.1-.75.4-1.25.73-1.54-2.55-.29-5.23-1.28-5.23-5.69 0-1.25.45-2.28 1.19-3.08-.12-.29-.52-1.46.11-3.05 0 0 .97-.31 3.19 1.18a11.1 11.1 0 0 1 5.8 0c2.22-1.49 3.19-1.18 3.19-1.18.63 1.59.23 2.76.11 3.05.74.8 1.19 1.83 1.19 3.08 0 4.42-2.69 5.39-5.25 5.68.41.36.78 1.06.78 2.14v3.17c0 .31.21.68.8.56A11.5 11.5 0 0 0 23.5 12C23.5 5.65 18.35.5 12 .5Z"/>
                  </svg>
                </a>

                <!-- LinkedIn -->
                <a href="https://linkedin.com/in/georgios-panagiotakopoulos" target="_blank" class="text-zinc-400 transition hover:text-white">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="h-6 w-6">
                      <path d="M4.98 3.5C4.98 4.88 3.86 6 2.49 6A2.49 2.49 0 0 1 0 3.5 2.49 2.49 0 0 1 2.49 1a2.49 2.49 0 0 1 2.49 2.5ZM.5 8h4v15h-4V8Zm7 0h3.84v2.05h.05c.53-1.01 1.84-2.05 3.79-2.05 4.05 0 4.8 2.67 4.8 6.14V23h-4v-7.66c0-1.83-.03-4.19-2.55-4.19-2.56 0-2.95 2-2.95 4.06V23h-4V8Z"/>
                  </svg>
                </a>

                <!-- Email -->
                <a href="mailto:georgiospanagiotakopoulos@outlook.com" class="text-zinc-400 transition hover:text-white">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5A2.25 2.25 0 0 1 19.5 19.5h-15A2.25 2.25 0 0 1 2.25 17.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15A2.25 2.25 0 0 0 2.25 6.75m19.5 0-9.75 6.75L2.25 6.75"/>
                  </svg>
                </a>
              </div>
            </div>
          </div>

          <div class="mt-12 border-t border-white/10 pt-6">
            <p class="text-center text-sm text-white">© 2026 Georgios Panagiotakopoulos. Built with Laravel & Tailwind CSS.</p>
          </div>
        </div>
      </div>
    </footer>
    <div aria-hidden="true" class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]">
      <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" class="relative left-[calc(50%+3rem)] aspect-1155/678 w-144.5 -translate-x-1/2 bg-linear-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%+36rem)] sm:w-288.75"></div>
    </div>
  </div>
</div>

</body>
</html>