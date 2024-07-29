<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeResponder extends Command
{
    protected $signature = 'make:responder {name}';
    protected $description = 'Create a new responder class';

    public function handle()
    {
        $name = $this->argument('name');
        $path = app_path("Responders/{$name}.php");

        if (File::exists($path)) {
            $this->error("Responder {$name} already exists!");
            return;
        }

        File::ensureDirectoryExists(app_path('Responders'));

        File::put($path, $this->getStubContent($name));

        $this->info("Responder {$name} created successfully.");
    }

    protected function getStubContent($name)
    {
        return <<<EOT
<?php

namespace App\Responders;

use Illuminate\Http\JsonResponse;

class {$name}
{
    public function respond(\$data, \$status = 200): JsonResponse
    {
        return response()->json(\$data, \$status);
    }
}
EOT;
    }
}
