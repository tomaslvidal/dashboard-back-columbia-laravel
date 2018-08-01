<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class testJson extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
$response = $this->json('POST', 'http://columbiaapp.eviajes.online/api/users/add/voucher/3', ['voucher_id' => '5']);

        $response
            ->assertStatus(422)
            ->assertJson([
                'created' => true,
            ]);
    }
}
