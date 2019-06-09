<?php

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [[
            'name' => 'Makuake',
            'url' => 'https://www.makuake.com/',
            'favicon' => 'https://www.makuake.com/favicon.ico',
        ],[
            'name' => 'readyfor',
            'url' => 'https://readyfor.jp/',
            'favicon' => 'https://readyfor.jp/favicon.ico',
        ],[
            'name' => 'fundiy',
            'url' => 'https://fundiy.jp/',
            'favicon' => 'https://fundiy.jp/favicon.ico',
        ],[
            'name' => 'COUNTDOWN',
            'url' => 'https://www.countdown-x.com/ja/',
            'favicon' => 'https://www.countdown-x.com/images/xfavicon.png,q_=20130215.pagespeed.ic.zcns8LOoMy.png',
        ],[
            'name' => 'MotionGallery',
            'url' => 'https://motion-gallery.net/',
            'favicon' => 'https://motion-gallery.net/favicon.ico',
        ],[
            'name' => 'CAMPFIRE',
            'url' => 'https://camp-fire.jp/',
            'favicon' => 'https://camp-fire.jp/favicon.ico',
        ],[
            'name' => 'faavo',
            'url' => 'https://faavo.jp/',
            'favicon' => 'https://faavo.jp/favicon.ico',
        ],[
            'name' => 'kibidango',
            'url' => 'https://kibidango.com/',
            'favicon' => 'https://kibidango.com/favicon.ico',
        ],[
            'name' => 'GREEN FUNDING',
            'url' => 'https://greenfunding.jp/',
            'favicon' => 'https://greenfunding.jp/favicon.ico',
        ],[
            'name' => 'First Flight',
            'url' => 'https://first-flight.sony.com/',
            'favicon' => 'https://first-flight.sony.com/favicon.ico',
        ],];

        foreach ($services as $service) {
            $serviceModel = new Service();
            $serviceModel->name =$service['name'];
            $serviceModel->url = $service['url'];
            $serviceModel->favicon = $service['favicon'];
            $serviceModel->save();
        }

    }
}
