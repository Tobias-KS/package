<?php


namespace Ephort\Firewall\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Ephort\Firewall\CRUD\Read;
use Illuminate\Support\Facades\Cache;

class WhiteListIPS extends Command
{
    protected $signature = 'firewall:whitelist';

    protected $description = 'whitelist IP';

    public function handle()
    {
        $IP = $this->ask("Enter the IPv4 address you wish to whitelist");
        if (Str::length($IP) > 6) {
            if (filter_var($IP, FILTER_VALIDATE_IP)) {
                $this->info("{$IP} has been whitelisted");
                Cache::put('whitelist', $IP);
            } else {
                $this->info("Not a valid IP address!");
            }
        }

    }
}
