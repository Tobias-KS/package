<?php

namespace Ephort\Firewall\CRUD;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class Read
{
    protected $url = "0.0.0.0:80";

    public function getBlacklist()
    {
        $blacklist = Http::get($this->url . "/api/blacklist");
        $blacklist = json_decode($blacklist, true);
        return $blacklist;
    }

    public function getWhitelist()
    {
        $whitelist = Cache::get('whitelist');
        if ($whitelist) {
            return (array)$whitelist;
        } else {
            return [];
        }

    }
}
