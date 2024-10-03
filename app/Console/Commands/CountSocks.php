<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CountSocks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'socks:count {socks*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Count the number of pairs of socks that sales can sell';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $number = explode(',', $this->argument('socks'));
        $number = $this->argument('socks');
        $count = $this->CountMath($number);
        $this->info("Number of pairs of socks that can be sold: $count");
    }

    private function CountMath(array $number)
    {
        $frekuensi = array_count_values($number);
        $countPair = 0;

        foreach ($frekuensi as $count) {
            $countPair += floor($count / 2);
        }

        return $countPair;
    }
}
