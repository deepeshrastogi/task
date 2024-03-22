<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Task;
use App\Models\Attachment;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@yopmail.com',
            'password' => Hash::make('admin@123'),
        ]);
        $faker = Faker::create();
        $destinationPath = public_path('uploads');
        $pulicUrlPath = url('/') . '/uploads/';
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0775, true); // Create the directory recursively
        }
        
        for ($i = 0; $i < 10; $i++) {
            $taskData = [
                'subject' => $faker->sentence,
                'description' => $faker->paragraph,
                'start_date' => $faker->dateTimeBetween('-1 month', 'now'),
                'due_date' => $faker->dateTimeBetween('now', '+1 month'),
                'status' => $faker->randomElement(['New', 'Incomplete', 'Completed']),
                'priority' => $faker->randomElement(['Low', 'Medium', 'High']),
                'user_id' => $user->id
            ];

            $task = Task::create($taskData);
            for($j=0; $j< mt_rand(1,3); $j++){
                $noteData = [
                    'subject' => $faker->sentence,
                    'note' => $faker->paragraph,
                    'task_id' => $task->id,
                ];
                $note = $task->notes()->create($noteData);
                for($k=0; $k< mt_rand(1,2); $k++){
                    $randomFileName = $faker->image($destinationPath, 400, 300, null, false);
                    $pathParts = pathinfo($randomFileName);
                    $randomFileNameWithoutPath = $pathParts['basename'];
                    $attachData = [
                        'original_name' => $faker->name.".png",
                        'temp_name' => $randomFileNameWithoutPath,
                        'url' => $pulicUrlPath.$randomFileNameWithoutPath,
                    ];
                    $attachResponse = Attachment::create($attachData);
                    $note->attachments()->save($attachResponse);
                }
            }
        }        
    }
}
