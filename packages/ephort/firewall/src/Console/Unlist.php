<?php

namespace Ephort\Firewall\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Ephort\Firewall\CRUD\Read;
use Illuminate\Support\Facades\Cache;

class Unlist extends Command
{
    protected $signature = 'firewall:unlist';

    protected $description = 'unlist a whitelisted IP';

    public function handle()
    {
        $IP = $this->ask("Enter the IPv4 address you wish to unlist");
        if (Str::length($IP) > 6) {
            if (filter_var($IP, FILTER_VALIDATE_IP)) {
                $this->info("{$IP} has been unlisted");
                Cache::forget('whitelist', $IP);
            } else {
                $this->info("Not a valid IP address!");
            }
        }
    }
}
