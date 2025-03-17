<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = ['draft', 'published'];
        $authorIds = User::where('role', 'admin')->pluck('user_id')->toArray();

        if (empty($authorIds)) {
            $this->command->warn('No users with the role "admin" found. Seeder will not create announcements.');
            return;
        }

        for ($i = 0; $i < 50; $i++) {
            $randomDaysAgo = [0, 1, 7, 30, rand(2, 25)];
            $publishedAt = Carbon::now()->subDays($randomDaysAgo[array_rand($randomDaysAgo)]);

            Announcement::create([
                'id' => Str::uuid(),
                'title' => 'Announcement ' . ($i + 1),
                'description' => 'This is the content of announcement ' . ($i + 1),
                'status' => $statuses[array_rand($statuses)],
                'published_at' => rand(0, 1) ? $publishedAt : null,
                'author_id' => $authorIds[array_rand($authorIds)],
            ]);
        }
    }
}
