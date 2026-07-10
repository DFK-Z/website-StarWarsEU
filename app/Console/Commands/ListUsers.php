<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ListUsers extends Command
{
    protected $signature = 'users:list';
    protected $description = 'Показать список всех пользователей с их ролями';

    public function handle()
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->info("📭 Пользователей пока нет.");
            return 0;
        }

        $this->table(
            ['ID', 'Имя', 'Email', 'Роль'],
            $users->map(fn($user) => [
                $user->id,
                $user->name,
                $user->email,
                $user->role_name
            ])
        );

        $this->info("📊 Всего пользователей: " . $users->count());
        return 0;
    }
}
