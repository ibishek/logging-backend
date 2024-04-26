<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Services\Permissions\Permissions as AppPolicyPermissions;
use Error;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Symfony\Component\Console\Output\ConsoleOutput;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        try {
            DB::beginTransaction();

            foreach (AppPolicyPermissions::webGuardPermissions() as $permission) {
                Permission::create(['guard_name' => 'api', 'name' => $permission]);
            }

            foreach (AppPolicyPermissions::adminGuardPermissions() as $permission) {
                Permission::create(['guard_name' => 'admin', 'name' => $permission]);
            }

            foreach (UserRole::roles() as $role) {
                if ($role === UserRole::APP_ADMIN->value) {
                    $guard = 'admin';
                    $permissionRole = Role::create(['guard_name' => $guard, 'name' => $role]);
                    $this->permissionProvideResolvingFormString($permissionRole, 'top_level');

                    continue;
                }

                if ($role === UserRole::UNASSIGNED->value) {
                    $permissionRole = Role::create(['guard_name' => 'api', 'name' => $role]);

                    continue;
                }

                $permissionRole = Role::create(['guard_name' => 'api', 'name' => $role]);
                $this->permissionProvideResolvingFormString($permissionRole, $role);
            }

            DB::commit();
        } catch (Exception $error) {
            DB::rollBack();

            $consoleOutput = new ConsoleOutput;
            $consoleOutput->writeln($error->getMessage());
        }
    }

    private function permissionProvideResolvingFormString(Role $role, string $roleName): void
    {
        $class = implode('', array_map(fn ($letter) => ucfirst($letter), explode('_', $roleName))) . 'Permissions';

        if (! method_exists('App\\Services\\Permissions\\' . $class, 'permissions')) {
            throw new Error('App\\Services\\Permissions\\' . $class . ' does not include permissions method.');
        }

        $role->givePermissionTo(call_user_func(['App\\Services\\Permissions\\' . $class, 'permissions']));
    }
}
