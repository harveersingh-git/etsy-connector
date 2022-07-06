<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AllowLicense;
use App\Models\User;

class DeactivateLicence extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deactivatelicence:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $allowLicense = AllowLicense::whereDate('expire_date', '<', now())->latest()->get();
        if (count($allowLicense) > 0) {
            foreach ($allowLicense as $value) {
                User::find($value->user_id)->update(['license' => '0']);
                AllowLicense::find($value->id)->delete();
            }
        }
    }
}
