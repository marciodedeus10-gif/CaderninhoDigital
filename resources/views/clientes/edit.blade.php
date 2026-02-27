<div class="d-flex">

    {{-- Conteúdo Principal --}}
    <div class="flex-fill p-4">
        @yield('content')
    </div>

    {{-- Menu Lateral Direita --}}
    <div style="width: 220px; background:#f8f9fa; padding:20px;">
        <h5>Menu</h5>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('clientes.index') }}">
                    Clientes
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#">
                    Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#">
                    Vendas
                </a>
            </li>
        </ul>
    </div>

</div>