<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Bersihkan cache permission
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Daftar permission yang dimiliki oleh kedua role
        $commonPermissions = [
            'dashboard',
            'account_details',
            'account_details.update',
            'account_details.deactivate',
            'account_details.change-password',
            'account_details.change-password-action',
        ];

        // Daftar permission khusus untuk admin
        $adminPermissions = [
            'members',
            'administrators',
            'user.details',
            'announcements',
            'announcements.add',
            'announcements.create',
            'announcements.details',
            'announcements.update',
            'announcements.delete',
        ];

        // Buat semua permission (jika belum ada)
        foreach (array_merge($commonPermissions, $adminPermissions) as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Buat role member dan assign permission yang bersifat umum
        $memberRole = Role::firstOrCreate(['name' => 'member']);
        $memberRole->syncPermissions($commonPermissions);

        // Buat role admin dan assign semua permission (umum + admin)
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions(array_merge($commonPermissions, $adminPermissions));
    }
}
