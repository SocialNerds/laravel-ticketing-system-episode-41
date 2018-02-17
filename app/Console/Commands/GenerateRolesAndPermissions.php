<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class GenerateRolesAndPermissions extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tickets:rp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate applications default roles and permissions.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Generating default roles and permissions...');
        $admin = User::create(
          [
            'name'     => 'Admin',
            'email'    => 'admin@socialnerds.gr',
            'password' => bcrypt('12345'),
          ]
        );

        // Create roles.
        $adminRole   = Role::create(['name' => 'admin']);
        $supportRole = Role::create(['name' => 'support']);

        $admin->assignRole('admin');

        // Create permissions.
        $userManagement = Permission::create(['name' => 'users management']);
        $deleteTickets  = Permission::create(['name' => 'delete tickets']);
        $ticketStatus   = Permission::create(
          ['name' => 'change tickets status']
        );

        $adminRole->givePermissionTo($userManagement);
        $deleteTickets->syncRoles([$adminRole, $supportRole]);
        $ticketStatus->syncRoles([$adminRole, $supportRole]);
    }
}
