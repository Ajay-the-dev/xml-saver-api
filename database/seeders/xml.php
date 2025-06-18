<?php

namespace Database\Seeders;

use App\Models\xml as ModelsXml;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class xml extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < 200; $i++) { 
            ModelsXml::create([
                'title' => 'title'.$i,
                'description' => 'This is a very long description'.$i,
                'code' => '&#x3C;?xml version=&#x22;1.0&#x22; encoding=&#x22;UTF-8&#x22;?&#x3E;
                            &#x3C;bookstore&#x3E;
                                &#x3C;book category=&#x22;cooking&#x22;&#x3E;
                                    &#x3C;id&#x3E;'.$i.'&#x3C;/id&#x3E;
                                    &#x3C;title lang=&#x22;en&#x22;&#x3E;Everyday Italian&#x3C;/title&#x3E;
                                    &#x3C;author&#x3E;Giada De Laurentiis&#x3C;/author&#x3E;
                                    &#x3C;year&#x3E;2005&#x3C;/year&#x3E;
                                    &#x3C;price&#x3E;30.00&#x3C;/price&#x3E;
                                &#x3C;/book&#x3E;
                            &#x3C;/bookstore&#x3E;'
            ]);
            # code...
        }
    }
}
