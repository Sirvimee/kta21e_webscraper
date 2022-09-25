<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class gunshowcomicScraper extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:gunshow';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $client = new Client(['verify' => false]);
        for($i=1;$i<10;$i++) {

            if(Cache::has('gunshow-'. $i)){
                $html = Cache::get('gunshow-'. $i);
            } else {
                $response = $client->get('https://gunshowcomic.com/' . $i);
                $html = $response->getBody()->getContents();
                Cache::put('gunshow-'. $i, $html);
            }
            $crawler = new \Symfony\Component\DomCrawler\Crawler($html);
            $imgEl = $crawler->filter('.strip');
            var_dump($imgEl->attr('src'));
            var_dump($imgEl->attr('title'));

        }
    }
}
