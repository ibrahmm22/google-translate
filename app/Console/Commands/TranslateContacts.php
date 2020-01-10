<?php

namespace App\Console\Commands;

use App\Services\TranslateService;
use Illuminate\Console\Command;

/**
 * Class TranslateContacts
 * @package App\Console\Commands
 */
class TranslateContacts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contacts:translate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'translate contacts through google translate';

    private $contactService;

    public function __construct(TranslateService $contactService)
    {
        parent::__construct();
        $this->contactService = $contactService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->contactService->translate();
    }
}
