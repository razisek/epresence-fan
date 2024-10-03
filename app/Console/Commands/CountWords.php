<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CountWords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'words:count {sentence}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Count the number of words in a sentence with special characters';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sentence = $this->argument('sentence');
        $wordCount = $this->countWords($sentence);
        $this->info("Word Count: " . $wordCount);
    }

    private function countWords(string $input)
    {
        $words = preg_split('/\s+/', $input);

        $count = 0;
        foreach ($words as $word) {
            if (preg_match('/[^a-zA-Z0-9]+/', $word) && !preg_match('/[^a-zA-Z0-9]+$/', $word)) {
                continue;
            }
            $count++;
        }

        return $count;
    }
}
