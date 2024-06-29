<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use TCG\Voyager\Models\Permission;
use TCG\Voyager\Models\Role;
use App\Models\PermissionRole;

class BreadPermissionsSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('name', 'admin')->firstOrFail();

        $permissions = Permission::all();

        $role->permissions()->sync(
            $permissions->pluck('id')->all()
        );

        //Remove ability to delete support tickets
        $roleID = Role::where('name', 'support')->first()->id;

        $permissionIDs[0] = Permission::where('key', 'browse_supporttickets')->first()->id;
        $permissionIDs[1] = Permission::where('key', 'read_supporttickets')->first()->id;

        foreach ($permissionIDs as $permissionID) {
            $data = array(
                'role_id' => $roleID,
                'permission_id' => $permissionID,
            );

            PermissionRole::insert($data);
        }
    }
}
