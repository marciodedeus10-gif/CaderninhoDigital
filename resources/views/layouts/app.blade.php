<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caderninho Digital</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 230px;
            --sidebar-collapsed-width: 64px;
            --topbar-height: 60px;
            --sidebar-bg: #1E3A8A;
            --sidebar-hover: rgba(255, 255, 255, 0.12);
            --sidebar-active: rgba(255, 255, 255, 0.2);
            --transition: 0.25s ease;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f4ff;
            color: #1a1a2e;
            transition: background-color var(--transition), color var(--transition);
        }

        /* ===== DARK MODE ===== */
        body.dark-mode {
            background-color: #0f0f1a;
            color: #e0e0f0;
        }
        body.dark-mode .topbar { background: linear-gradient(90deg, #0f1f55, #1a3080); }
        body.dark-mode .sidebar { background-color: #0f1f55; }
        body.dark-mode .main-content { background-color: #0f0f1a; }
        body.dark-mode .card { background-color: #1a1a2e; border-color: #2a2a4a; }
        body.dark-mode .profile-dropdown {
            background-color: #1a1a2e;
            border-color: #2a2a4a;
        }
        body.dark-mode .profile-dropdown-header { border-color: #2a2a4a; }
        body.dark-mode .pd-name { color: #e0e0f0 !important; }
        body.dark-mode .pd-divider { background: #2a2a4a; }
        body.dark-mode .profile-dropdown ul li a,
        body.dark-mode .profile-dropdown ul li button { color: #c0c0d8; }
        body.dark-mode .profile-dropdown ul li a:hover,
        body.dark-mode .profile-dropdown ul li button:hover { background: #2a2a4a; }
        body.dark-mode .topbar-search {
            background-color: rgba(255,255,255,0.08);
            color: #fff;
        }

        /* ===== LAYOUT ===== */
        .layout-wrapper { display: flex; flex-direction: column; min-height: 100vh; }
        .body-row { display: flex; flex: 1; overflow: hidden; }

        /* ===== TOPBAR ===== */
        .topbar {
            height: var(--topbar-height);
            background: linear-gradient(90deg, #1E3A8A, #2563eb);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1rem 0 0;
            position: sticky;
            top: 0;
            z-index: 1040;
            box-shadow: 0 2px 12px rgba(30, 58, 138, 0.25);
        }

        .topbar-left { display: flex; align-items: center; }

        .btn-sidebar-toggle {
            width: var(--sidebar-collapsed-width);
            height: var(--topbar-height);
            background: transparent;
            border: none;
            color: rgba(255,255,255,0.8);
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background var(--transition), color var(--transition);
            flex-shrink: 0;
        }
        .btn-sidebar-toggle:hover { background: rgba(255,255,255,0.1); color: #fff; }

        .topbar-brand {
            font-size: 1rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: 0.3px;
            white-space: nowrap;
            overflow: hidden;
            max-width: 200px;
            transition: max-width var(--transition), opacity var(--transition);
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Busca */
        .topbar-search-wrap { position: relative; margin-right: 4px; }
        .topbar-search {
            background-color: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 20px;
            color: #fff;
            font-size: 0.83rem;
            padding: 5px 14px 5px 34px;
            width: 180px;
            outline: none;
            transition: width var(--transition), background-color var(--transition);
        }
        .topbar-search::placeholder { color: rgba(255,255,255,0.6); }
        .topbar-search:focus { width: 220px; background-color: rgba(255,255,255,0.22); }
        .topbar-search-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.6);
            font-size: 0.8rem;
            pointer-events: none;
        }

        /* Ícones topbar */
        .topbar-icon-btn {
            background: transparent;
            border: none;
            color: rgba(255,255,255,0.85);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background var(--transition), color var(--transition);
            position: relative;
            font-size: 1.05rem;
        }
        .topbar-icon-btn:hover { background: rgba(255,255,255,0.15); color: #fff; }

        .notif-badge {
            position: absolute;
            top: 2px;
            right: 2px;
            width: 16px;
            height: 16px;
            background: #ef4444;
            border-radius: 50%;
            font-size: 9px;
            font-weight: 700;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Botão dark mode */
        #toggleTheme {
            font-size: 0.75rem;
            padding: 4px 10px;
            border-radius: 20px;
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.25);
            color: #fff;
            cursor: pointer;
            transition: background var(--transition);
            margin: 0 2px;
        }
        #toggleTheme:hover { background: rgba(255,255,255,0.25); }

        /* Avatar btn */
        .topbar-avatar-btn {
            background: transparent;
            border: none;
            padding: 4px 10px 4px 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            border-radius: 24px;
            transition: background var(--transition);
            margin-left: 4px;
        }
        .topbar-avatar-btn:hover { background: rgba(255,255,255,0.12); }

        .topbar-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255,255,255,0.35);
        }

        .topbar-user-info { text-align: left; line-height: 1.2; }
        .topbar-user-name { font-size: 0.8rem; font-weight: 600; color: #fff; display: block; }
        .topbar-user-role { font-size: 0.68rem; color: rgba(255,255,255,0.6); display: block; }

        /* Dropdown perfil */
        .profile-dropdown {
            position: absolute;
            top: calc(var(--topbar-height) - 4px);
            right: 0;
            width: 224px;
            background: #fff;
            border: 0.5px solid rgba(0,0,0,0.1);
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
            z-index: 2000;
            overflow: hidden;
            opacity: 0;
            transform: translateY(-8px);
            pointer-events: none;
            transition: opacity 0.15s ease, transform 0.15s ease;
        }
        .profile-dropdown.open {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }

        .profile-dropdown-header {
            padding: 14px 16px 12px;
            border-bottom: 0.5px solid rgba(0,0,0,0.08);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .profile-dropdown-header img {
            width: 40px; height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .pd-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: #1a1a2e;
            display: block;
        }

        .pd-email {
            font-size: 0.72rem;
            color: #6b7280;
            display: block;
            margin-top: 1px;
        }

        .profile-dropdown ul {
            list-style: none;
            margin: 0;
            padding: 6px 0;
        }

        .profile-dropdown ul li a,
        .profile-dropdown ul li button {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 16px;
            font-size: 0.85rem;
            color: #374151;
            text-decoration: none;
            background: transparent;
            border: none;
            width: 100%;
            cursor: pointer;
            transition: background 0.15s;
        }

        .profile-dropdown ul li a:hover,
        .profile-dropdown ul li button:hover { background: #f3f4f6; }

        .profile-dropdown ul li a i,
        .profile-dropdown ul li button i {
            font-size: 0.9rem;
            color: #6b7280;
            width: 16px;
            text-align: center;
        }

        .pd-divider { height: 0.5px; background: rgba(0,0,0,0.08); margin: 4px 0; }

        .pd-logout, .pd-logout i { color: #ef4444 !important; }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: var(--sidebar-width);
            min-height: calc(100vh - var(--topbar-height));
            background-color: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            transition: width var(--transition);
            overflow: hidden;
        }

        .sidebar.collapsed { width: var(--sidebar-collapsed-width); }

        .sidebar-nav {
            flex: 1;
            padding: 0.75rem 0.5rem;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar-section-label {
            font-size: 0.62rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: rgba(255,255,255,0.35);
            padding: 0.6rem 0.75rem 0.3rem;
            white-space: nowrap;
            overflow: hidden;
            transition: opacity var(--transition);
        }
        .sidebar.collapsed .sidebar-section-label { opacity: 0; }

        .nav-item { list-style: none; }

        .nav-link-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 8px;
            color: rgba(255,255,255,0.78);
            text-decoration: none;
            font-size: 0.875rem;
            white-space: nowrap;
            overflow: hidden;
            transition: background var(--transition), color var(--transition);
            position: relative;
        }
        .nav-link-item:hover { background: var(--sidebar-hover); color: #fff; }
        .nav-link-item.active { background: var(--sidebar-active); color: #fff; font-weight: 600; }

        .nav-icon { font-size: 1rem; min-width: 20px; text-align: center; flex-shrink: 0; }

        .nav-label {
            overflow: hidden;
            text-overflow: ellipsis;
            transition: opacity var(--transition), max-width var(--transition);
            max-width: 160px;
        }
        .sidebar.collapsed .nav-label { opacity: 0; max-width: 0; }

        /* Tooltip ao colapsar */
        .sidebar.collapsed .nav-link-item:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            left: calc(var(--sidebar-collapsed-width) - 4px);
            top: 50%;
            transform: translateY(-50%);
            background: #1e293b;
            color: #fff;
            font-size: 0.78rem;
            padding: 4px 10px;
            border-radius: 6px;
            white-space: nowrap;
            z-index: 2000;
            pointer-events: none;
        }

        .sidebar-divider { height: 0.5px; background: rgba(255,255,255,0.12); margin: 6px 12px; }

        /* Footer da sidebar */
        .sidebar-footer {
            padding: 0.5rem;
            border-top: 0.5px solid rgba(255,255,255,0.1);
        }

        .sidebar-footer .logout-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 8px;
            color: rgba(255,120,120,0.85);
            background: transparent;
            border: none;
            font-size: 0.875rem;
            width: 100%;
            cursor: pointer;
            white-space: nowrap;
            overflow: hidden;
            transition: background var(--transition), color var(--transition);
            position: relative;
        }
        .sidebar-footer .logout-btn:hover { background: rgba(239,68,68,0.15); color: #fca5a5; }
        .sidebar.collapsed .sidebar-footer .nav-label { opacity: 0; max-width: 0; }
        .sidebar.collapsed .sidebar-footer .logout-btn:hover::after {
            content: "Sair";
            position: absolute;
            left: calc(var(--sidebar-collapsed-width) - 4px);
            top: 50%;
            transform: translateY(-50%);
            background: #1e293b;
            color: #fff;
            font-size: 0.78rem;
            padding: 4px 10px;
            border-radius: 6px;
            white-space: nowrap;
            z-index: 2000;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            flex: 1;
            padding: 1.5rem;
            background-color: #f0f4ff;
            overflow-y: auto;
            transition: background-color var(--transition);
        }
        body.dark-mode .main-content { background-color: #0f0f1a; }
    </style>
</head>

<body class="{{ auth()->check() && auth()->user()->tema == 'escuro' ? 'dark-mode' : '' }}">

<div class="layout-wrapper">

    {{-- ===== TOPBAR ===== --}}
    <header class="topbar">

        <div class="topbar-left">
            <button class="btn-sidebar-toggle" id="sidebarToggle" title="Colapsar menu">
                <i class="bi bi-list"></i>
            </button>
            <span class="topbar-brand">📓 Caderninho Digital</span>
        </div>

        <div class="topbar-right">

            {{-- Busca --}}
            <div class="topbar-search-wrap">
                <i class="bi bi-search topbar-search-icon"></i>
                <input type="text" class="topbar-search" placeholder="Buscar...">
            </div>

            {{-- Notificações --}}
            <button class="topbar-icon-btn" title="Notificações">
                <i class="bi bi-bell"></i>
                <span class="notif-badge">3</span>
            </button>

            {{-- Dark mode --}}
            <button id="toggleTheme">🌙</button>

            {{-- Avatar + Dropdown Perfil --}}
            <div style="position: relative;">
                <button class="topbar-avatar-btn" id="profileToggle">
                    <img src="{{ auth()->check() ? (auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=random') : 'https://i.pravatar.cc/40' }}" class="topbar-avatar" alt="Avatar">
                    <div class="topbar-user-info">
                        <span class="topbar-user-name">
                            {{ auth()->check() ? auth()->user()->name : 'Usuário' }}
                        </span>
                        <span class="topbar-user-role">
                            {{ auth()->check() ? auth()->user()->email : 'usuario@email.com' }}
                        </span>
                    </div>
                    <i class="bi bi-chevron-down" style="font-size:0.62rem; color:rgba(255,255,255,0.6); margin-left:2px;"></i>
                </button>

                <div class="profile-dropdown" id="profileDropdown">

                    <div class="profile-dropdown-header">
                        <img src="{{ auth()->check() ? (auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=random') : 'https://i.pravatar.cc/80' }}" alt="Avatar">
                        <div>
                            <span class="pd-name">{{ auth()->check() ? auth()->user()->name : 'Usuário' }}</span>
                            <span class="pd-email">{{ auth()->check() ? auth()->user()->email : 'usuario@email.com' }}</span>
                        </div>
                    </div>

                    <ul>
                        <li>
                            <a href="{{ route('perfil.edit') }}">
                                <i class="bi bi-person"></i> Meu Perfil
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('perfil.edit') }}">
                                <i class="bi bi-gear"></i> Configurações
                            </a>
                        </li>
                        <li>
                            <a href="#" id="themeToggleDropdown">
                                <i class="bi bi-moon-stars"></i>
                                <span id="themeLabel">Modo Escuro</span>
                            </a>
                        </li>
                    </ul>

                    <div class="pd-divider"></div>

                    <ul>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="pd-logout">
                                    <i class="bi bi-box-arrow-right"></i> Sair da conta
                                </button>
                            </form>
                        </li>
                    </ul>

                </div>
            </div>

        </div>
    </header>

    {{-- ===== ÁREA PRINCIPAL ===== --}}
    <div class="body-row">

        {{-- ===== SIDEBAR ===== --}}
        <nav class="sidebar" id="sidebar">

            <div class="sidebar-nav">

                <p class="sidebar-section-label">Principal</p>
                <ul class="p-0 m-0">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}"
                           class="nav-link-item {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                           data-tooltip="Dashboard">
                            <i class="bi bi-speedometer2 nav-icon"></i>
                            <span class="nav-label">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('quemSomos.index') }}"
                           class="nav-link-item {{ request()->routeIs('quemSomos.*') ? 'active' : '' }}"
                           data-tooltip="Quem Somos">
                            <i class="bi bi-info-circle nav-icon"></i>
                            <span class="nav-label">Quem Somos</span>
                        </a>
                    </li>
                </ul>

                <div class="sidebar-divider"></div>
                <p class="sidebar-section-label">Gestão</p>
                <ul class="p-0 m-0">
                    <li class="nav-item">
                        <a href="{{ route('clientes.index') }}"
                           class="nav-link-item {{ request()->routeIs('clientes.*') ? 'active' : '' }}"
                           data-tooltip="Clientes">
                            <i class="bi bi-people nav-icon"></i>
                            <span class="nav-label">Clientes</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('vendas.index') }}"
                           class="nav-link-item {{ request()->routeIs('vendas.*') ? 'active' : '' }}"
                           data-tooltip="Vendas">
                            <i class="bi bi-cash-stack nav-icon"></i>
                            <span class="nav-label">Vendas</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('produtos.index') }}"
                           class="nav-link-item {{ request()->routeIs('produtos.*') ? 'active' : '' }}"
                           data-tooltip="Produtos">
                            <i class="bi bi-box-seam nav-icon"></i>
                            <span class="nav-label">Produtos</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('servicos.index') }}"
                           class="nav-link-item {{ request()->routeIs('servicos.*') ? 'active' : '' }}"
                           data-tooltip="Serviços">
                            <i class="bi bi-tools nav-icon"></i>
                            <span class="nav-label">Serviços</span>
                        </a>
                    </li>
                </ul>

                <div class="sidebar-divider"></div>
                <p class="sidebar-section-label">Comunicação</p>
                <ul class="p-0 m-0">
                    <li class="nav-item">
                        <a href="{{ route('contatos.index') }}"
                           class="nav-link-item {{ request()->routeIs('contatos.*') ? 'active' : '' }}"
                           data-tooltip="Contatos">
                            <i class="bi bi-envelope nav-icon"></i>
                            <span class="nav-label">Contatos</span>
                        </a>
                    </li>
                </ul>

            </div>

            <div class="sidebar-footer">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="bi bi-box-arrow-left nav-icon"></i>
                        <span class="nav-label">Sair</span>
                    </button>
                </form>
            </div>

        </nav>

        {{-- ===== CONTEÚDO ===== --}}
        <main class="main-content">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')

        </main>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // ===== SIDEBAR TOGGLE =====
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');

    function applySidebar(collapsed) {
        sidebar.classList.toggle('collapsed', collapsed);
        sidebarToggle.querySelector('i').className = collapsed
            ? 'bi bi-layout-sidebar-reverse'
            : 'bi bi-list';
        localStorage.setItem('sidebarCollapsed', collapsed ? '1' : '0');
    }

    sidebarToggle.addEventListener('click', () => {
        applySidebar(!sidebar.classList.contains('collapsed'));
    });

    if (localStorage.getItem('sidebarCollapsed') === '1') applySidebar(true);

    // ===== DARK MODE =====
    const toggleTheme = document.getElementById('toggleTheme');
    const themeToggleDropdown = document.getElementById('themeToggleDropdown');
    const themeLabel = document.getElementById('themeLabel');

    function applyTheme(dark) {
        document.body.classList.toggle('dark-mode', dark);
        toggleTheme.textContent = dark ? '☀️' : '🌙';
        if (themeLabel) themeLabel.textContent = dark ? 'Modo Claro' : 'Modo Escuro';
        localStorage.setItem('theme', dark ? 'dark' : 'light');
    }

    toggleTheme.addEventListener('click', () => {
        applyTheme(!document.body.classList.contains('dark-mode'));
    });

    themeToggleDropdown && themeToggleDropdown.addEventListener('click', (e) => {
        e.preventDefault();
        applyTheme(!document.body.classList.contains('dark-mode'));
    });

    // Restaura tema ao carregar
    const savedTheme = localStorage.getItem('theme');
    applyTheme(savedTheme === 'dark' || document.body.classList.contains('dark-mode'));

    // ===== DROPDOWN PERFIL =====
    const profileToggle = document.getElementById('profileToggle');
    const profileDropdown = document.getElementById('profileDropdown');

    profileToggle.addEventListener('click', (e) => {
        e.stopPropagation();
        profileDropdown.classList.toggle('open');
    });

    document.addEventListener('click', () => profileDropdown.classList.remove('open'));
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') profileDropdown.classList.remove('open');
    });
</script>

</body>
</html>
