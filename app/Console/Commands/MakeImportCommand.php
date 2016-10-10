<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Admin\Import\Parties\AdminImportPartiesParserController as Parser;

class MakeImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Добавление товарных партий';

    protected $parser;

    /**
     * Create a new command instance.
     *
     * @param Parser $parser
     */
    public function __construct( Parser $parser )
    {
        parent::__construct();

        $this->parser = $parser;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->parser->actionMakeImport();
    }
}
