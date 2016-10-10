<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Admin\Import\Update\AdminImportUpdateParserController as Parser;

class MakeUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Обновление товарных акций';

    protected $parser;

    /**
     * Create a new command instance.
     *
     * MakeUpdateCommand constructor.
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
