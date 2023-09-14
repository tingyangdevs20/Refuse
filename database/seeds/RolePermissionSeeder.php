<?php


use App\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\User;
use Spatie\Permission\Models\Permission;

/**
 * Class RolePermissionSeeder.
 *
 * @see https://spatie.be/docs/laravel-permission/v5/basic-usage/multiple-guards
 *
 * @package App\Database\Seeds
 */
class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define roles
        $roles = [
            'Super Admin',
            'Administrator',
            'Assistant',
            'Acquisitions',
            'Dispositions',
            'Transaction Coordinator',
            'Marketing Manager',

        ];

        foreach ($roles as $roleName) {
            // Create roles
            $role = Role::firstOrCreate(['name' => $roleName]);

            // Define permissions for each role (modify as needed)
            $permissions = [
                'access_all',
                'administrator',
                'dashboard',
                'permissions_create',
                'permissions_delete',
                'permissions_edit',
                'permissions_module',
                'role_create',
                'role_delete',
                'role_edit',
                'roles_module',
                'scraping_module',
                'user_create',
                'user_delete',
                'user_edit',
                'user_module',
                'user_task_module',
                'scraping_create',
                'scraping_edit',
                'scraping_delete',
                'user_task_edit',
                'user_task_create',
                'source_list',

                'contact_list',
                'campaigns',
                'sms_module',
                'template_module',
                'auto_responder',

                'tags_module',
                'market_module',
                'lead_categories',
                'rvms',
                'dnc_management',
                'phone_module',
                'quick_response',

               
                'system_setting',
                'quick_response',
                'zoom_module',




            ];

            // Assign permissions to roles
            foreach ($permissions as $permissionName) {
                // Check if the permission already exists
                $existingPermission = Permission::where('name', $permissionName)->first();

                if (!$existingPermission) {
                    $permission = Permission::create(['name' => $permissionName]);
                    $role->givePermissionTo($permission);
                }
            }

            // Check if the role is "Administrator" and assign it to a specific user
            if ($roleName === 'Administrator') {
                // Replace with your user retrieval logic or create a new user
                $user = User::firstOrCreate([
                    'email' => 'adminn@gmail.com', // Specify the user's email
                    // Add other user attributes here
                ]);

                // Assign the "Administrator" role to the user
                $user->assignRole($roleName);
            }

        }
    }
}
