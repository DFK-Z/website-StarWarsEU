<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ShowRole extends Command
{
    protected $signature = 'role:show {email}';
    protected $description = 'Показать роль пользователя';

    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("❌ Пользователь с email '$email' не найден.");
            return 1;
        }

        $this->info("👤 Пользователь: {$user->name}");
        $this->info("📧 Email: {$user->email}");
        $this->info("🏷️ Роль: {$user->role_name}");
        return 0;
    }
}
