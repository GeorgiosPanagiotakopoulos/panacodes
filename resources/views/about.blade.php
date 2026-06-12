<x-layout title="About">
    <section class="w-full max-w-6xl px-6 py-20 text-white">
        <div class="grid gap-12 lg:grid-cols-[1.1fr_0.9fr] lg:items-center">
            
            {{-- Intro --}}
            <div>

                <h1 class="mt-4 text-4xl font-semibold tracking-tight sm:text-3xl">Software Engineer focused on building, learning and improving.</h1>

                <p class="mt-6 max-w-2xl leading-8 text-zinc-300">
                    I’m a Computer Science graduate based in Athens, with experience in web development,
                    quality assurance and IT support. My recent work has focused on Laravel, PHP, MySQL
                    and testing, but I see frameworks as tools — the real focus is understanding problems,
                    writing clean code and adapting to the right technology for the job.
                </p>

                <p class="mt-4 max-w-2xl leading-8 text-zinc-300">
                    I enjoy turning ideas into working software, breaking complex problems into smaller
                    pieces and improving through real projects, feedback and continuous practice.
                </p>

                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ asset('PanagiotakopoulosGeorgiosCV.pdf') }}" target="_blank" rel="noopener noreferrer" class="rounded-xl bg-white px-5 py-3 text-sm font-semibold text-gray-900 transition hover:bg-zinc-200">
                        View Full CV
                    </a>
                    <a href="/projects" class="rounded-xl bg-white px-5 py-3 text-sm font-semibold text-gray-900 transition hover:bg-zinc-200">View Projects</a>
                    <a href="/contact" class="rounded-xl bg-white px-5 py-3 text-sm font-semibold text-gray-900 transition hover:bg-zinc-200">Contact Me</a>
                </div>
            </div>

            {{-- Snapshot Card --}}
            <div class="rounded-2xl border border-white/10 bg-white/5 p-6 shadow-xl">
                <h2 class="text-xl font-semibold">Developer Snapshot</h2>

                <dl class="mt-6 space-y-5">
                    <div>
                        <dt class="text-sm text-zinc-400">Background</dt>
                        <dd class="mt-1 text-white">BSc Computer Science, AUEB</dd>
                    </div>

                    <div>
                        <dt class="text-sm text-zinc-400">Current focus</dt>
                        <dd class="mt-1 text-white">Web applications, testing and backend fundamentals</dd>
                    </div>

                    <div>
                        <dt class="text-sm text-zinc-400">Recent stack</dt>
                        <dd class="mt-1 text-white">Laravel, PHP, MySQL, Blade, Tailwind CSS, JavaScript</dd>
                    </div>

                    <div>
                        <dt class="text-sm text-zinc-400">Also familiar with</dt>
                        <dd class="mt-1 text-white">Java, Python, C++, Cypress, Git</dd>
                    </div>
                </dl>
            </div>
        </div>

        {{-- Journey --}}
        <div class="mt-24 grid gap-12 lg:grid-cols-[0.8fr_1.2fr]">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-zinc-400">
                    Journey
                </p>

                <h2 class="mt-4 text-3xl font-semibold">
                    A practical path into software.
                </h2>

                <p class="mt-4 text-zinc-300 leading-7">
                    My background combines academic computer science, real work experience,
                    quality assurance and hands-on web development. That mix has helped me
                    approach software from both a technical and practical point of view.
                </p>
            </div>

            <div class="space-y-5">
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
                    <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                        <h3 class="font-semibold">Computer Science at AUEB</h3>
                        <span class="text-sm text-zinc-400">2017 – 2024</span>
                    </div>
                    <p class="mt-3 text-sm leading-6 text-zinc-300">
                        Built a foundation in programming, databases, algorithms and software engineering concepts.
                    </p>
                </div>

                <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
                    <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                        <h3 class="font-semibold">Quality Assurance & IT Support</h3>
                        <span class="text-sm text-zinc-400">2025</span>
                    </div>
                    <p class="mt-3 text-sm leading-6 text-zinc-300">
                        Worked with manual and automated testing, Cypress, Windows Server, Active Directory
                        and technical support, gaining a broader view of software reliability and users’ needs.
                    </p>
                </div>

                <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
                    <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                        <h3 class="font-semibold">Web Development</h3>
                        <span class="text-sm text-zinc-400">2026</span>
                    </div>
                    <p class="mt-3 text-sm leading-6 text-zinc-300">
                        Developed responsive web applications and e-commerce features using Laravel,
                        Tailwind CSS, JavaScript, MySQL and Git-based workflows.
                    </p>
                </div>
            </div>
        </div>

        {{-- Current focus --}}
        <div class="mt-24">
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-zinc-400">
                Current focus
            </p>

            <h2 class="mt-4 text-3xl font-bold">
                Growing beyond one framework.
            </h2>

            <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ([
                    'Backend Development',
                    'Database Design',
                    'Testing & Quality Assurance',
                    'Object-Oriented Programming',
                    'Algorithms & Data Structures',
                    'Problem Solving',
                    'Mathematical Thinking',
                    'Continuous Improvement',
                ] as $item)
                    <div class="rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-zinc-200">
                        {{ $item }}
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</x-layout>