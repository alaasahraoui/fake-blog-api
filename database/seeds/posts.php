<?php

use App\Category;
use App\Post;
use App\User;
use Illuminate\Database\Seeder;

class posts extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        
        Post::truncate();
        
        $users = User::author()->pluck('id')->toArray();

        $data = [];
        
        for($i = 1; $i <= 500; $i++) {
            $name = $faker->sentence($faker->numberBetween(4, 8));

            array_push($data, [
                'user_id'      => $faker->randomElement($users),
                'name'         => $name,
                'slug'         => str_slug($name),
                'excerpt'      => $faker->realText(150),
                'body'         => $faker->realText($faker->numberBetween(1000,2000)),
                'thumb'        => 'https://picsum.photos/1600/600/?random',
                'is_featured'  => $faker->boolean(30),
                'hits'         => $faker->numberBetween(30, 800),
                'published_at' => $faker->dateTimeBetween(),
            ]);
        }
        
        Post::insert($data);

        $data = [];
        $posts = Post::pluck('id')->toArray();
        $categories = Category::pluck('id')->toArray();

        for ($i=1; $i <= 100 ; $i++) { 
            array_push($data, [
                'post_id'     => $faker->randomElement($posts),
                'category_id' => $faker->randomElement($categories),
            ]);
        }

        \DB::table('category_post')->insert($data);
    }
}
