<header class="absolute inset-x-0 top-0">
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
    <a href="/about" class="text-sm/6 font-semibold text-zinc-400 transition hover:text-white">About Me</a>
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
        <el-dialog-panel class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto p-6 sm:max-w-sm sm:ring-1 sm:ring-gray-100/10">
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
                <a href="/about" class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-white hover:bg-white/5">About Me</a>
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