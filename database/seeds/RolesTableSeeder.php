<?php

use App\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        App\Role::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Role::create([
            'role' => 'dashboard',
            'description' => 'Permission to View Dashboard'
        ]);
        Role::create([
            'role' => 'add_blog',
            'description' => 'Permission to create a blog'
        ]);
        Role::create([
            'role' => 'edit_blog',
            'description' => 'Permission to edit a blog'
        ]);
        Role::create([
            'role' => 'delet_blog',
            'description' => 'Permission to delet a blog'
        ]);
        Role::create([
            'role' => 'view_blog',
            'description' => 'Permission to view a blog'
        ]);
        Role::create([
            'role' => 'view_all_blog',
            'description' => 'Permission to view all blogs'
        ]);
        Role::create([
            'role' => 'add_category',
            'description' => 'Permission to create a category'
        ]);
        Role::create([
            'role' => 'edit_category',
            'description' => 'Permission to edit a category'
        ]);
        Role::create([
            'role' => 'delet_category',
            'description' => 'Permission to delet a category'
        ]);
        Role::create([
            'role' => 'view_category',
            'description' => 'Permission to view a category'
        ]);
        Role::create([
            'role' => 'view_all_category',
            'description' => 'Permission to view all categories'
        ]);
        Role::create([
            'role' => 'view_all_comment',
            'description' => 'Permission to view all comments'
        ]);
        Role::create([
            'role' => 'view_comment',
            'description' => 'Permission to Manage comments'
        ]);
        Role::create([
            'role' => 'moderate_comment',
            'description' => 'Permission to Manage comments'
        ]);
        Role::create([
            'role' => 'delet_comment',
            'description' => 'Permission to delet a comment'
        ]);
        Role::create([
            'role' => 'view_user',
            'description' => 'Permission to view a user'
        ]);
        Role::create([
            'role' => 'view_all_user',
            'description' => 'Permission to view all users'
        ]);
        Role::create([
            'role' => 'add_user',
            'description' => 'Permission to create a user'
        ]);
        Role::create([
            'role' => 'edit_user',
            'description' => 'Permission to edit a user'
        ]);
        Role::create([
            'role' => 'delet_user',
            'description' => 'Permission to delet a user'
        ]);
        Role::create([
            'role' => 'view_all_subscriber',
            'description' => 'Permission to view all subscribers'
        ]);
        Role::create([
            'role' => 'edit_subscriber',
            'description' => 'Permission to change active status of subscriber'
        ]);
        Role::create([
            'role' => 'delet_subscriber',
            'description' => 'Permission to delet a subscriber'
        ]);
        Role::create([
            'role' => 'manage_roles',
            'description' => 'Permission to manage roles of a user'
        ]);
        Role::create([
            'role' => 'manage_settings',
            'description' => 'Permission to manage roles of a user'
        ]);
        Role::create([
            'role' => 'super_admin',
            'description' => 'Permission makes a user undeletable and uneditable by any admin except another Super Admin'
        ]);
    }
}
