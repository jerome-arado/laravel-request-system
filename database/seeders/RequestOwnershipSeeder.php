<?php

namespace Database\Seeders;

use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Database\Seeder;

class RequestOwnershipSeeder extends Seeder
{
    public function run(): void
    {
        $studentA = User::where('email', 'student.a@example.test')->first();
        $studentB = User::where('email', 'student.b@example.test')->first();

        // Assign Maria Santos's and Ana Reyes's requests to Student A
        ServiceRequest::whereIn('requester_email', [
            'maria.santos@example.com',
            'ana.reyes@example.com',
        ])->update(['user_id' => $studentA->id]);

        // Assign Juan Dela Cruz's request to Student B
        ServiceRequest::where('requester_email', 'juan.delacruz@example.com')
            ->update(['user_id' => $studentB->id]);
    }
}