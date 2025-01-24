<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class DeleteDuplicateServices extends Command
{
    protected $signature = 'services:delete-duplicates';
    protected $description = 'Delete duplicate services while keeping one record per service name';

    public function handle()
    {
        // Fetch services with duplicate service names
        $duplicateServices = Service::select('service_name', DB::raw('count(*) as count'))
            ->groupBy('service_name')
            ->having('count', '>', 1)
            ->get();

        // Loop through each duplicate service name
        foreach ($duplicateServices as $service) {
            // Delete all but the first record for each duplicate service_name
            Service::where('service_name', $service->service_name)
                ->skip(1) // Skip the first record
                ->delete();
        }

        $this->info('Duplicate services deleted successfully.');
    }
}
