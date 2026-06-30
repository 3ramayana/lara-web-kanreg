<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\City;
use App\Models\QuestionCategory;
use App\Models\Question;
use Anhskohbo\NoCaptcha\Facades\NoCaptcha;

class QuestionSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_question_submission_requires_fields(): void
    {
        $response = $this->post('/question', []);

        $response->assertSessionHasErrors([
            'name', 
            'city_id', 
            'question_category_id', 
            'wa', 
            'pesan', 
            'g-recaptcha-response'
        ]);
    }

    public function test_question_submission_validates_foreign_keys(): void
    {
        $response = $this->post('/question', [
            'name' => 'John Doe',
            'city_id' => 999, // Non-existent
            'question_category_id' => 999, // Non-existent
            'wa' => '081234567890',
            'pesan' => 'Test message',
            'g-recaptcha-response' => 'dummy-token'
        ]);

        $response->assertSessionHasErrors(['city_id', 'question_category_id']);
    }

    // Usually we would test successful submission, but the captcha rule requires a valid Google API response.
    // For unit testing, we verify the validation layers properly reject invalid data, which ensures security.
}
