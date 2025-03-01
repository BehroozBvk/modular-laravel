<?php

declare(strict_types=1);

namespace Modules\Country\Database\Seeders;

use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Country\Services\CountriesApiService;

class CountryDatabaseSeeder extends Seeder
{
    public function __construct(
        private readonly CountriesApiService $countriesApiService
    ) {}

    /**
     * Run the database seeds.
     *
     * @throws Exception
     */
    public function run(): void
    {
        $this->command->info('Fetching countries from API...');

        $countries = $this->countriesApiService->fetchCountries()
            ->map(fn($country) => $country->toArray());

        $this->command->info(sprintf('Found %d countries', $countries->count()));

        $chunkSize = $this->countriesApiService->getChunkSize();
        $chunks = $countries->chunk($chunkSize);

        $this->command->info(sprintf('Inserting countries in chunks of %d...', $chunkSize));

        $bar = $this->command->getOutput()->createProgressBar($chunks->count());

        DB::transaction(function () use ($chunks, $bar): void {
            foreach ($chunks as $chunk) {
                DB::table('countries')->insert($chunk->toArray());
                $bar->advance();
            }
        });

        $bar->finish();
        $this->command->info("\nCountries seeded successfully!");
    }
}
