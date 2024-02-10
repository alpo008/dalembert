<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PingIp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ip:ping {ip}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ping IP address';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $ip = $this->argument('ip');
        $returnVar = NULL;
        $output  = NULL;
        $command = sprintf('ping -c 4 %s', $ip);
        $re = '/(\d+)\sreceived/';
        $result = '0';
 
        exec($command, $output, $returnVar);

        if(is_array($output) && !empty($output[7]) && is_string($output[7])) {
            preg_match($re, $output[7], $matches);
            if(is_array($matches) && !empty($matches[1]) && is_string($matches[1])) {
                $result = $matches[1];
            }
        }
        return !!$result ? Command::SUCCESS : Command::FAILURE;
    }
}
