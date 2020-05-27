<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ArticleTableSeede extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$faker = Faker::create();
		foreach (range(1,5000) as $index) {
			$name = $faker->name;
			dump($name);
			\DB::table('articles')->insert([
				'a_name' => $name,
				'a_slug' => \Illuminate\Support\Str::slug($name),
				'a_menu_id' => rand(1,2),
				'a_content' => $faker->text
			]);
		}
    }
}
