# 🚀 SETUP MANUAL - Passo a Passo

Se você está tendo dificuldade em rodar os comandos, siga este guia visual:

## Opção 1: Executar Script Automático (MAIS FÁCIL)

### No Windows:

1. **Abra o explorador de arquivos**
   - Navegue até: `C:\Users\Oycram10\Desktop\agenda\CaderninhoDigital`

2. **Duplo-clique em `setup.bat`**
   - Ele vai executar os 3 comandos automaticamente
   - Espere até ver "SUCESSO!"

---

## Opção 2: Executar Manualmente no Terminal

### Passo 1: Abra PowerShell
```
Windows + X → Windows PowerShell (Administrador)
```

### Passo 2: Navigate até a pasta do projeto
```powershell
cd C:\Users\Oycram10\Desktop\agenda\CaderninhoDigital
```

### Passo 3: Execute o primeiro comando
```powershell
php artisan migrate
```

**Você verá algo assim:**
```
Migrating: 0001_01_01_000000_create_users_table.php
Migrating: 2026_04_27_110000_create_planos_table.php
Migrating: 2026_04_27_110226_create_assinaturas_table.php
...
✓ Done
```

**Se vir "✓ Done" = ✅ Sucesso!**

### Passo 4: Execute o segundo comando
```powershell
php artisan db:seed --class=PlanoSeeder
```

**Você verá:**
```
Seeding: Database\Seeders\PlanoSeeder
✓ Done
```

### Passo 5: Execute o terceiro comando
```powershell
php artisan db:seed --class=RolePermissionSeeder
```

**Você verá:**
```
Seeding: Database\Seeders\RolePermissionSeeder
✓ Done
```

---

## Passo 6: Testar se funcionou

### Teste no Tinker (Terminal Interativo)

Ainda no PowerShell, execute:

```powershell
php artisan tinker
```

Você verá algo assim:
```
Psy Shell v0.xx.x
```

Agora copie e cole um linha por vez:

**Linha 1:**
```php
App\Models\Plano::count()
```

Deve aparecer: `=> 3` (3 planos criados)

**Linha 2:**
```php
App\Models\User::create(['name' => 'Teste', 'email' => 'teste@test.com', 'password' => Hash::make('123456')])
```

Deve criar um usuário

**Linha 3:**
```php
$user = App\Models\User::find(1)
```

Deve retornar um objeto User

**Linha 4:**
```php
$user->assignRole('Administrador')
```

Deve retornar true

**Linha 5:**
```php
$user->hasRole('Administrador')
```

Deve retornar: `=> true`

**Sair:**
```php
exit
```

---

## ❌ Se Houver Erro

### Erro: "SQLSTATE[HY000]: General error"

**Solução:** O banco de dados não existe
```powershell
# Criar banco manualmente no phpMyAdmin ou:
php artisan db:create
```

### Erro: "Class 'Spatie\Permission' not found"

**Solução:** Falta instalar dependências
```powershell
composer install
```

### Erro: "Migration file not found"

**Solução:** As migrations não foram criadas corretamente
```powershell
# Limpar banco e começar de novo
php artisan migrate:refresh
php artisan db:seed --class=PlanoSeeder
php artisan db:seed --class=RolePermissionSeeder
```

### Erro: "No application encryption key"

**Solução:** Falta gerar a chave
```powershell
php artisan key:generate
```

---

## 📋 Checklist

Marque conforme conseguir executar:

- [ ] PowerShell aberto na pasta do projeto
- [ ] `php artisan migrate` executado com sucesso
- [ ] `php artisan db:seed --class=PlanoSeeder` executado
- [ ] `php artisan db:seed --class=RolePermissionSeeder` executado
- [ ] `php artisan tinker` abre terminal interativo
- [ ] `App\Models\Plano::count()` retorna 3
- [ ] Usuário criado com sucesso
- [ ] Role "Administrador" atribuído

---

## 🎯 Próximo Passo

Depois que tudo passar, inicie o servidor:

```powershell
php artisan serve
```

Você verá:
```
Starting Laravel development server: http://127.0.0.1:8000
```

Abra no navegador:
```
http://127.0.0.1:8000/assinaturas
```

---

## 📞 Se Ainda Não Funcionar

Envie as informações:
1. **Versão do PHP:**
   ```powershell
   php -v
   ```

2. **Versão do Laravel:**
   ```powershell
   php artisan --version
   ```

3. **Mensagem de erro completa** (copie e cole toda a mensagem de erro que aparecer)

4. **Output do comando:**
   ```powershell
   php artisan tinker
   App\Models\Plano::all()
   ```
