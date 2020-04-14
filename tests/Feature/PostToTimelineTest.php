<?php

namespace Tests\Feature;

use App\Post;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostToTimelineTest extends TestCase
{

    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    /** @test */
    public function a_user_can_post_a_text_post()
    {
        $this->actingAs($user = factory(User::class)->create(), 'api');

        $response = $this->post('/api/posts', [
            'body' => 'test body'
        ]);

        $post = Post::first();

        $this->assertCount(1, Post::all());
        $this->assertEquals($user->id, $post->user_id);
        $this->assertEquals('test body', $post->body);

        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'type' => 'posts',
                    'post_id' => $post->id,
                    'attributes' => [
                        'posted_by' => [
                            'data' => [
                                'attributes' => [
                                    'name' => $user->name
                                ]
                            ]
                        ],
                        'body' => 'test body',
                    ]
                ],
                'links' => [
                    'self' => url('/posts/' . $post->id),
                ]
            ]);
    }

    /** @test */
    public function a_user_can_post_a_text_post_with_an_image1()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($user = factory(User::class)->create(), 'api');

        $file = UploadedFile::fake()->image('user-post.jpg');

        $response = $this->post('/api/posts', [
            'body' => 'test body',
            'image' => $file,
            'width' => 200,
            'height' => 200,
        ]);

        Storage::disk('public')->assertExists('post-images/' . $file->hashName());
        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'attributes' => [
                        'body' => 'test body',
                        'image' => url('post-images/' . $file->hashName())
                    ]
                ]
            ]);
    }
}
