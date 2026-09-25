<div class="bg-white rounded-2xl shadow-sm border border-slate-200 px-10 py-7 mb-8 relative overflow-hidden">

    <div class="absolute top-0 left-0 right-0 h-1.5"
        style="background: linear-gradient(90deg, #dc2626, #ef4444, #dc2626);"></div>

    <div class="absolute -right-10 -top-10 w-56 h-56 rounded-full opacity-[0.04]" style="background: #dc2626;"></div>

    <div class="relative flex items-center justify-between">

        <div class="flex items-center space-x-6">

            <img src="{{ asset('img/Telkom.png') }}" alt="Telkom" class="h-12 w-auto">

            <div class="w-px h-12 bg-slate-200"></div>

            <div>
                <p class="text-[10px] font-black tracking-[0.3em] text-red-600 uppercase mb-1">
                    Witel Sumut
                </p>

                <h1 class="text-2xl font-black tracking-tight text-slate-900 leading-none uppercase">
                    Intimacy <span class="text-red-600">Monitoring</span>
                </h1>

                <p class="text-slate-400 text-xs font-bold mt-1 uppercase tracking-tight">
                    {{ $subtitle }}
                </p>
            </div>

        </div>

        <div class="flex items-center space-x-4">

            <a href="{{ route('admin.intimacy-monitoring') }}" class="flex items-center space-x-2.5 bg-white border-2 border-slate-900
                       hover:bg-slate-900 text-slate-900 hover:text-white
                       px-6 py-3 rounded-xl font-black text-xs
                       transition-all duration-300 shadow-sm uppercase tracking-wider">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                </svg>

                <span>Data Management</span>
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit" class="group flex items-center space-x-2.5
                           bg-slate-900 hover:bg-red-600 text-white
                           font-bold text-sm px-5 py-3 rounded-xl
                           transition-all duration-300 shadow-md
                           hover:shadow-lg hover:shadow-red-200">
                    <svg class="w-4 h-4 transition-transform duration-300 group-hover:rotate-12" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 013 3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>

                    <span>Logout</span>
                </button>
            </form>

        </div>
    </div>
</div>