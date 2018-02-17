<?php

namespace App\Console\Commands;

use App\Category;
use Illuminate\Console\Command;

class GenerateCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tickets:categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate default categories.';

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
        $categories = ['Bug', 'Help', 'New feature', 'Task', 'Improvement'];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
