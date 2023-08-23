<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $editorRole = Role::create(['name' => 'headmaster']);
        $siswaRole = Role::create(['name' => 'siswa']);

        // Create permissions
        $createPostsPermission = Permission::create(['name' => 'create roles']);
        $editPostsPermission = Permission::create(['name' => 'edit roles']);
        $deletePostsPermission = Permission::create(['name' => 'delete roles']);

        // Assign permissions to roles
        $adminRole->givePermissionTo(
            $createPostsPermission,
            $editPostsPermission
        );
        $editorRole->givePermissionTo($createPostsPermission);

        // Create a new user instance
        $admin = User::create([
            // 'user_id' => 2,
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
        ]);

        // Assign the 'admin' role to the user
        $admin->assignRole('admin');

        // Create a new user instance
        $head = User::create([
            // 'user_id' => 3,
            'name' => 'Headmaster',
            'email' => 'head@gmail.com',
            'password' => bcrypt('headmaster'),
        ]);

        // Assign the 'admin' role to the user
        $head->assignRole('headmaster');

        // Create a new user instance
        $student = Student::create([
            // 'user_id' => 4,
            'school_class_id' => 1,
            'student_identification_number' => '00420422',
            'name' => 'Tini Haryanti',
            'email' => 'tini@gmail.com',
            'phone_number' => '083856813888',
            'gender' => 2,
            'school_year_start' => '2020',
            'school_year_end' => '2023'
        ]);

        $studentUser = User::create([
            'name' => $student->name,
            'email' => $student->email,
            'password' => bcrypt('password'), // Ganti dengan password yang sesuai
        ]);

        // Assign the 'admin' role to the user
        $studentUser->assignRole('siswa');

    }
}
