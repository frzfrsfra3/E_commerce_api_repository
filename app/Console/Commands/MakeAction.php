<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeAction extends Command
{
    protected $signature = 'make:action {name}';
    protected $description = 'Create a new action class';

    public function handle()
    {
        $name = $this->argument('name');
        $path = app_path("Actions/{$name}.php");

        if (File::exists($path)) {
            $this->error("Action {$name} already exists!");
            return;
        }

        File::ensureDirectoryExists(app_path('Actions'));

        File::put($path, $this->getStubContent($name));

        $this->info("Action {$name} created successfully.");
    }

    protected function getStubContent($name)
    {
        return <<<EOT
<?php

namespace App\Actions;



class {$name}
{
    public function __invoke() 
    {
      
    }
}
EOT;
    }
}
