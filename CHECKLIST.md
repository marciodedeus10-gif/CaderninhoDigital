# ✅ CHECKLIST INTERATIVO - Setup Completo

Siga este checklist passo a passo. Marque conforme terminar cada etapa.

---

## 📋 PRÉ-REQUISITOS

- [ ] PHP instalado (versão 8.1+)
  ```powershell
  php -v
  ```

- [ ] Laravel instalado
  ```powershell
  php artisan --version
  ```

- [ ] Composer instalado
  ```powershell
  composer --version
  ```

- [ ] Banco de dados criado e configurado no `.env`
  ```
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=caderninho_digital
  DB_USERNAME=root
  DB_PASSWORD=
  ```

---

## 🚀 SETUP PRINCIPAL

### OPÇÃO A: Executar via Script (Recomendado)

- [ ] **1.** Abra Explorador de Arquivos
  - Vá para: `C:\Users\Oycram10\Desktop\agenda\CaderninhoDigital`

- [ ] **2.** Duplo-clique em `setup.bat`
  - Abrirá terminal preto
  - Espere os comandos executarem

- [ ] **3.** Veja a mensagem "SUCESSO"
  - Se vir ❌, vá para "TROUBLESHOOTING"

- [ ] **4.** Pressione qualquer tecla para fechar

---

### OPÇÃO B: Executar via PowerShell

- [ ] **1.** Abra PowerShell como Administrador
  - Windows + X → Windows PowerShell (Admin)

- [ ] **2.** Navegue até a pasta
  ```powershell
  cd C:\Users\Oycram10\Desktop\agenda\CaderninhoDigital
  ```

- [ ] **3.** Execute o script PowerShell
  ```powershell
  powershell -ExecutionPolicy Bypass -File .\setup.ps1
  ```

- [ ] **4.** Veja 3 passos completados com ✅
  - [1/3] Migrations
  - [2/3] PlanoSeeder
  - [3/3] RolePermissionSeeder

- [ ] **5.** Veja "✅ SETUP CONCLUÍDO!"

---

### OPÇÃO C: Executar Manualmente

- [ ] **1.** Abra PowerShell como Administrador
  - Windows + X → Windows PowerShell (Admin)

- [ ] **2.** Navegue até a pasta
  ```powershell
  cd C:\Users\Oycram10\Desktop\agenda\CaderninhoDigital
  ```

- [ ] **3.** Execute primeiro comando
  ```powershell
  php artisan migrate
  ```
  - Espere "✓ Done" aparecer

- [ ] **4.** Execute segundo comando
  ```powershell
  php artisan db:seed --class=PlanoSeeder
  ```
  - Espere "✓ Done" aparecer

- [ ] **5.** Execute terceiro comando
  ```powershell
  php artisan db:seed --class=RolePermissionSeeder
  ```
  - Espere "✓ Done" aparecer

---

## 🧪 TESTES DE VERIFICAÇÃO

### Teste 1: Verificar Planos no Tinker

- [ ] **1.** Abra Tinker
  ```powershell
  php artisan tinker
  ```

- [ ] **2.** Digite comando
  ```php
  App\Models\Plano::count()
  ```

- [ ] **3.** Deve aparecer
  ```
  => 3
  ```

✅ Se apareceu 3, passou no teste!

---

### Teste 2: Criar Usuário Teste

- [ ] **1.** Ainda no Tinker, crie usuário
  ```php
  $user = App\Models\User::create([
      'name' => 'João Teste',
      'email' => 'joao@teste.com',
      'password' => Hash::make('senha123')
  ])
  ```

- [ ] **2.** Deve aparecer um objeto User com ID

✅ Se apareceu, usuário foi criado!

---

### Teste 3: Atribuir Role

- [ ] **1.** Atribua o role Administrador
  ```php
  $user->assignRole('Administrador')
  ```

- [ ] **2.** Deve aparecer
  ```
  => true
  ```

✅ Se apareceu true, role foi atribuído!

---

### Teste 4: Criar Assinatura

- [ ] **1.** Busque um plano
  ```php
  $plano = App\Models\Plano::where('nome', 'Pequena Empresa')->first()
  ```

- [ ] **2.** Crie assinatura
  ```php
  App\Models\Assinatura::create([
      'user_id' => $user->id,
      'plano_id' => $plano->id,
      'status' => 'ativa',
      'data_inicio' => now(),
      'data_fim' => now()->addMonth(),
      'data_renovacao' => now()->addMonth(),
      'periodicidade' => 'mensal',
      'valor' => $plano->preco_mensal
  ])
  ```

- [ ] **3.** Deve aparecer um objeto Assinatura

✅ Se apareceu, assinatura foi criada!

---

### Teste 5: Verificar Permissões

- [ ] **1.** Verifique se tem acesso ao recurso
  ```php
  $user->podeAcessarRecurso('estoque')
  ```

- [ ] **2.** Deve aparecer
  ```
  => true
  ```

- [ ] **3.** Verifique role
  ```php
  $user->hasRole('Administrador')
  ```

- [ ] **4.** Deve aparecer
  ```
  => true
  ```

✅ Se ambos apareceram true, permissões estão funcionando!

---

### Teste 6: Sair do Tinker

- [ ] **1.** Digite
  ```php
  exit
  ```

- [ ] **2.** Volta ao PowerShell

---

## 🌐 TESTE NO NAVEGADOR

### Teste 7: Iniciar Servidor

- [ ] **1.** No PowerShell, inicie servidor
  ```powershell
  php artisan serve
  ```

- [ ] **2.** Você verá
  ```
  Starting Laravel development server: http://127.0.0.1:8000
  ```

- [ ] **3.** Deixe rodando (não feche essa janela)

---

### Teste 8: Acessar Página de Assinaturas

- [ ] **1.** Abra navegador (Chrome, Firefox, Edge)

- [ ] **2.** Digite URL
  ```
  http://127.0.0.1:8000/assinaturas
  ```

- [ ] **3.** Se vir página branca ou erro 500, vá para TROUBLESHOOTING

- [ ] **4.** Se vir os 3 planos
  - ✅ Passou no teste!

---

### Teste 9: Ver Detalhes dos Planos

Na página de assinaturas você verá:

- [ ] **Plano 1: Autônomo**
  - Preço: R$ 49,90/mês
  - Usuários: 1

- [ ] **Plano 2: Pequena Empresa**
  - Preço: R$ 149,90/mês
  - Usuários: 4

- [ ] **Plano 3: Empresa**
  - Preço: R$ 399,90/mês
  - Usuários: Ilimitado

✅ Se viu os 3 planos com preços corretos, tudo funcionou!

---

## 🎓 SETUP SECUNDÁRIO (OPCIONAL)

### Teste 10: Criar Usuários com Roles Diferentes

Volte para o PowerShell com Tinker:

```powershell
php artisan tinker
```

Crie 4 usuários diferentes:

- [ ] **1.** Gerente de Estoque
  ```php
  $gerente_estoque = App\Models\User::create([
      'name' => 'Maria Estoque',
      'email' => 'maria@test.com',
      'password' => Hash::make('123456')
  ]);
  $gerente_estoque->assignRole('Gerente Estoque');
  ```

- [ ] **2.** Gerente Financeiro
  ```php
  $gerente_financeiro = App\Models\User::create([
      'name' => 'Pedro Financeiro',
      'email' => 'pedro@test.com',
      'password' => Hash::make('123456')
  ]);
  $gerente_financeiro->assignRole('Gerente Financeiro');
  ```

- [ ] **3.** Vendedor
  ```php
  $vendedor = App\Models\User::create([
      'name' => 'Ana Vendas',
      'email' => 'ana@test.com',
      'password' => Hash::make('123456')
  ]);
  $vendedor->assignRole('Vendedor');
  ```

- [ ] **4.** Usuário Comum
  ```php
  $comum = App\Models\User::create([
      'name' => 'Carlos Comum',
      'email' => 'carlos@test.com',
      'password' => Hash::make('123456')
  ]);
  $comum->assignRole('Usuário Comum');
  ```

- [ ] **5.** Saia do Tinker
  ```php
  exit
  ```

✅ Se conseguiu criar todos, sistema está 100% pronto!

---

## 🆘 TROUBLESHOOTING

### Problema 1: Erro ao executar `php artisan migrate`

**Mensagem:** `SQLSTATE[HY000]: General error`

**Solução:**
```powershell
# Criar banco de dados
php artisan db:create

# Tentar migrate novamente
php artisan migrate
```

---

### Problema 2: Erro ao executar seeders

**Mensagem:** `Class PlanoSeeder not found`

**Solução:**
```powershell
# Recarregar autoload
composer dump-autoload

# Tentar seeder novamente
php artisan db:seed --class=PlanoSeeder
```

---

### Problema 3: Página em branco no navegador

**Solução 1:** Verificar logs
```powershell
tail -f storage/logs/laravel.log
```

**Solução 2:** Gerar chave de aplicação
```powershell
php artisan key:generate
```

**Solução 3:** Limpar cache
```powershell
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

### Problema 4: "No application encryption key"

**Solução:**
```powershell
php artisan key:generate
```

---

### Problema 5: Permissão negada ao rodar script

**Para BAT:** Clique com botão direito → "Executar como administrador"

**Para PowerShell:**
```powershell
Set-ExecutionPolicy -ExecutionPolicy Bypass -Scope CurrentUser
```

---

## ✅ CHECKLIST FINAL

Marque tudo que conseguiu fazer:

- [ ] Executou `php artisan migrate`
- [ ] Executou `php artisan db:seed --class=PlanoSeeder`
- [ ] Executou `php artisan db:seed --class=RolePermissionSeeder`
- [ ] `App\Models\Plano::count()` retorna 3
- [ ] Criou usuário com sucesso
- [ ] Atribuiu role ao usuário
- [ ] Criou assinatura
- [ ] Verificou permissões (true)
- [ ] Inicia servidor com `php artisan serve`
- [ ] Acessa http://127.0.0.1:8000/assinaturas no navegador
- [ ] Vê os 3 planos na página
- [ ] Criou 4 usuários com roles diferentes

**Se tudo está marcado: 🎉 PARABÉNS! Sistema 100% funcionando!**

---

## 🚀 Próximas Ações

1. Fazer login no sistema
2. Gerenciar assinaturas
3. Criar e atribuir roles
4. Testar permissões entre usuários

Quer um guia para isso?
