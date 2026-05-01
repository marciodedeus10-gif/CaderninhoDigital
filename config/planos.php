<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Recursos do Sistema
    |--------------------------------------------------------------------------
    |
    | Lista de todos os recursos disponíveis no sistema, organizados por categoria.
    | Estes recursos são usados para controle de acesso baseado no plano.
    |
    */

    'recursos' => [
        'basicos' => [
            'clientes',
            'produtos',
            'servicos',
            'vendas',
            'dashboard_basico'
        ],

        'intermediarios' => [
            'compras',
            'estoque',
            'financeiro',
            'dashboard_completo',
            'relatorios_basicos',
            'multi_usuario'
        ],

        'avancados' => [
            'relatorios_avancados',
            'api',
            'suporte_prioritario',
            'auditoria_completa'
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Limites por Plano
    |--------------------------------------------------------------------------
    |
    | Limites padrão para cada tipo de recurso por plano.
    | 0 = ilimitado
    |
    */

    'limites' => [
        'autonomo' => [
            'max_clientes' => 100,
            'max_produtos' => 200,
            'max_vendas_mes' => 500,
            'max_usuarios' => 1
        ],

        'pequena_empresa' => [
            'max_clientes' => 1000,
            'max_produtos' => 1000,
            'max_vendas_mes' => 2000,
            'max_compras_mes' => 1000,
            'max_usuarios' => 4
        ],

        'empresa' => [
            'max_clientes' => 0, // ilimitado
            'max_produtos' => 0,
            'max_vendas_mes' => 0,
            'max_compras_mes' => 0,
            'max_usuarios' => 0
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Mapeamento de Recursos para Módulos
    |--------------------------------------------------------------------------
    |
    | Mapeia recursos para módulos específicos do sistema.
    | Usado para verificar permissões em controllers.
    |
    */

    'modulos' => [
        'clientes' => ['ver_clientes', 'criar_clientes', 'editar_clientes', 'deletar_clientes'],
        'produtos' => ['ver_produtos', 'criar_produtos', 'editar_produtos', 'deletar_produtos'],
        'servicos' => ['ver_servicos', 'criar_servicos', 'editar_servicos', 'deletar_servicos'],
        'vendas' => ['ver_vendas', 'criar_vendas', 'editar_vendas', 'deletar_vendas'],
        'compras' => ['ver_compras', 'criar_compras', 'editar_compras', 'deletar_compras'],
        'estoque' => ['ver_estoque', 'gerenciar_estoque', 'ver_movimentacoes'],
        'financeiro' => ['ver_financeiro', 'gerenciar_financeiro', 'ver_lancamentos', 'criar_lancamentos', 'editar_lancamentos'],
        'usuarios' => ['ver_usuarios', 'criar_usuarios', 'editar_usuarios', 'deletar_usuarios', 'gerenciar_roles'],
        'relatorios' => ['ver_relatorios_basicos', 'ver_relatorios_avancados'],
        'dashboard' => ['acessar_dashboard'],
        'sistema' => ['configurar_sistema', 'gerenciar_planos']
    ]
];