<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $path = app_path("Services/{$name}.php");

        if (File::exists($path)) {
            $this->error("Service {$name} sudah ada!");
            return;
        }

        File::ensureDirectoryExists(app_path('Services'));

        $content = "<?php\n\nnamespace App\Services;\n\nclass {$name}\n{\n    // ...\n}\n";
        File::put($path, $content);

        $this->info("Service {$name} berhasil dibuat di app/Services/");
    }
}
