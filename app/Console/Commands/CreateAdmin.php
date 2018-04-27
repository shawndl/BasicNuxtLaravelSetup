<?php

namespace App\Console\Commands;

use App\Role;
use App\User;
use Illuminate\Console\Command;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'forage:role {name=admin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a role with the option of adding a user';

    /**
     * @var Role
     */
    protected $role;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var string
     */
    protected $name;

    /**
     * Create a new command instance.
     *
     * @param Role $role
     * @param User $user
     */
    public function __construct(Role $role, User $user)
    {
        parent::__construct();
        $this->role = $role;
        $this->user = $user;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->name = strtolower($this->argument('name'));

        $this->addRole();

        $this->addUser();
    }

    /**
     * add the role if it does not exist
     *
     * @return void
     */
    private function addRole()
    {
        if($this->roleExists())
        {
            $this->error("The role {$this->name} already exists.");
            return;
        }
        $this->role = $this->role->create(['name' => $this->name]);
        $this->line("The role {$this->name} has been created with an id of {$this->role->id}.");
    }


    /**
     * does the role already exist
     *
     * @return bool
     */
    private function roleExists()
    {
        return $this->role->where('name', $this->name)->count() > 0;
    }

    /**
     * check if the users wants to assign the role to a user
     */
    private function addUser()
    {
        if (!$this->confirm('Do you want to assign this role to a user?')) return;

        $userID = $this->ask('What is the user\'s ID?');
        $this->userExists($userID);

        $this->attachRole();
    }

    /**
     * checks if the users exists if they do not
     * then it will send an error message and give the user a change to enter another id
     * @param int $id
     * @return void
     */
    private function userExists(int $id)
    {
        $this->user = $this->user->find($id);
        if (!isset($this->user->id)) {
            $this->error("A user with an id of $id does not exist.");
            $this->addUser();
        }
    }

    /**
     * attaches the role to the user
     */
    private function attachRole()
    {
        try {
            $this->user->roles()->attach($this->role);
        } catch (\Exception $exception) {
            $this->line($exception->getMessage());
            return;
        }
        $this->line("The user {$this->user->name} now has a role of {$this->role->name}");
    }
}
