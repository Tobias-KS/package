<?php


namespace Ephort\Firewall\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Ephort\Firewall\CRUD\Read;
use Illuminate\Support\Facades\Cache;

class NumberOfBlockedIPS extends Command
{
    protected $signature = 'firewall:status';

    protected $description = 'number of clients blocked in the last hour';

    public function handle()
    {

        $blocklist = Cache::get('blocklist');
        if ($blocklist) {
            $clients = count($blocklist);
            $this->info("Firewall has blocked {$clients} client(s) in the last hour");

        } else {
            $this->info("Firewall has not blocked any clients in the last hour");
        }

    }

}
