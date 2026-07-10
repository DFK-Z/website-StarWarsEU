<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class SetRole extends Command
{
    protected $signature = 'role:set {email} {role=user}';
    protected $description = 'Назначить роль пользователю (user, guardian, moderator, admin)';

    public function handle()
    {
        $email = $this->argument('email');
        $role = $this->argument('role');

        // Проверяем, что роль существует
        $validRoles = ['user', 'guardian', 'moderator', 'admin'];
        if (!in_array($role, $validRoles)) {
            $this->error("❌ Роль '$role' не существует. Доступные роли: " . implode(', ', $validRoles));
            return 1;
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("❌ Пользователь с email '$email' не найден.");
            return 1;
        }

        $user->role = $role;
        $user->save();

        $this->info("✅ Пользователь '{$user->name}' теперь " . $this->getRoleName($role));
        return 0;
    }

    private function getRoleName(string $role): string
    {
        return match ($role) {
            'admin'     => '🔴 Верховный Хранитель',
            'moderator' => '🔵 Рыцарь Хронологии',
            'guardian'  => '🟣 Хранитель Знаний',
            default     => '🟢 Хранитель Голокрона',
        };
    }
}
