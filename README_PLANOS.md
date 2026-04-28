# Sistema de Assinaturas e Controle de Acesso

Este sistema implementa um completo controle de assinaturas e permissões para diferentes tipos de usuários.

## 🚀 Funcionalidades Implementadas

### 1. Sistema de Planos
- **Autônomo**: R$ 49/mês - 1 usuário, recursos básicos
- **Pequena Empresa**: R$ 149/mês - Até 4 usuários, recursos completos
- **Empresa**: R$ 399/mês - Usuários ilimitados, todos os recursos

### 2. Controle de Acesso por Roles
- **Administrador**: Acesso completo a todos os módulos
- **Gerente Estoque**: Controle de produtos, compras e movimentações
- **Gerente Financeiro**: Gestão financeira e relatórios básicos
- **Vendedor**: Gestão de clientes, produtos e vendas
- **Usuário Comum**: Acesso apenas leitura

### 3. Middleware de Controle de Plano
Protege rotas baseado no plano ativo do usuário.

## 📋 Instalação e Configuração

### 1. Executar Migrations
```bash
php artisan migrate
```

### 2. Executar Seeders
```bash
php artisan db:seed --class=PlanoSeeder
php artisan db:seed --class=RolePermissionSeeder
```

### 3. Agendar Comando de Verificação
Adicione ao `app/Console/Kernel.php`:
```php
protected function schedule(Schedule $schedule)
{
    $schedule->command('assinaturas:verificar-expiradas')->daily();
}
```

## 🔧 Como Usar

### Criar Assinatura para um Usuário
```php
use App\Models\Assinatura;
use App\Models\Plano;

$plano = Plano::where('nome', 'Pequena Empresa')->first();
$user = User::find(1);

Assinatura::create([
    'user_id' => $user->id,
    'plano_id' => $plano->id,
    'status' => 'ativa',
    'data_inicio' => now(),
    'data_fim' => now()->addMonth(),
    'periodicidade' => 'mensal',
    'valor' => $plano->preco_mensal
]);
```

### Verificar Permissões
```php
// No controller
if (!$user->podeAcessarRecurso('estoque')) {
    abort(403, 'Recurso não disponível no seu plano');
}

// Verificar limite
if ($user->getLimite('max_clientes') <= Cliente::where('user_id', $user->id)->count()) {
    return back()->with('error', 'Limite de clientes atingido');
}
```

### Atribuir Roles
```php
$user->assignRole('Gerente Estoque');
$user->hasRole('Gerente Estoque'); // true
$user->can('gerenciar_estoque'); // true
```

## 📊 Estrutura do Banco

### Tabelas Criadas
- `planos`: Definição dos planos disponíveis
- `assinaturas`: Assinaturas ativas dos usuários
- `roles`: Roles do Spatie Permission
- `permissions`: Permissões do Spatie Permission
- `model_has_permissions`: Relacionamento permissões
- `model_has_roles`: Relacionamento roles
- `role_has_permissions`: Permissões por role

### Relacionamentos
- User belongsTo Assinatura
- Assinatura belongsTo Plano
- User hasMany Users (para usuários da mesma empresa)
- User hasMany Roles/Permissions (via Spatie)

## 🔒 Middleware

### CheckPlanoPermission
Protege rotas baseado no plano ativo:
```php
Route::get('/estoque', [Controller::class, 'index'])->middleware('plano:estoque');
```

## ⚡ Comandos Artisan

### Verificar Assinaturas Expiradas
```bash
php artisan assinaturas:verificar-expiradas
```

## 📈 Próximos Passos

1. **Integração com Gateway de Pagamento**
   - Implementar Stripe/Mercado Pago
   - Webhooks para renovação automática

2. **Sistema de Cobrança**
   - Geração de faturas
   - Lembretes de vencimento
   - Histórico de pagamentos

3. **Dashboard Administrativo**
   - Métricas de uso por plano
   - Gestão de assinaturas
   - Relatórios financeiros

4. **API para Mobile**
   - Endpoints para app mobile
   - Controle de rate limiting por plano

## 🛠️ Troubleshooting

### Erro: "Assinatura expirada"
- Verificar se o usuário tem assinatura ativa
- Executar comando de verificação de expiradas

### Erro: "Recurso não disponível no seu plano"
- Verificar recursos do plano no banco
- Confirmar se o middleware está aplicado corretamente

### Erro: "Limite atingido"
- Verificar limites no arquivo config/planos.php
- Implementar contadores em tempo real