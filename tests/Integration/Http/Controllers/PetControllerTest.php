<?php

namespace Tests\Integration\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;
use App\Services\PetService;

class PetControllerTest extends TestCase
{
    use RefreshDatabase;

    private PetService $petService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->petService = $this->createMock(PetService::class);

        $this->app->instance(PetService::class, $this->petService);
    }

    public function testShowReturnsViewWithPet()
    {
        $this->petService
            ->expects($this->once())
            ->method('getPet')
            ->with(1)
            ->willReturn(
                [
                    'id' => 1,
                    'name' => 'Fido',
                    'category' => ['id' => 1, 'name' => 'Dog'],
                    'photoUrls' => ['http://example.com/fido.jpg'],
                    'tags' => [['id' => 0, 'name' => 'friendly']],
                    'status' => 'available'
                ]
            );

        $response = $this->get('/pets/1');

        $response->assertStatus(200);
        $response->assertViewIs('pets.show');
        $response->assertViewHas('pet');
    }

    public function testCreateReturnsView()
    {
        $response = $this->get('/pets/create');

        $response->assertStatus(200);
        $response->assertViewIs('pets.create');
    }

    public function testStoreRedirectsToIndex()
    {
        $this->petService
            ->expects($this->once())
            ->method('addPet')
            ->with($this->isInstanceOf(Request::class))
            ->willReturn(
                [
                    'id' => 1,
                    'name' => 'Fido',
                    'category' => ['id' => 1, 'name' => 'Dog'],
                    'photoUrls' => ['http://example.com/fido.jpg'],
                    'tags' => [['id' => 0, 'name' => 'friendly']],
                    'status' => 'available'
                ]
            );

        $response = $this->post('/pets', [
            'id' => 1,
            'category_id' => 1,
            'category_name' => 'Dog',
            'name' => 'Fido',
            'photoUrls' => 'http://example.com/fido.jpg',
            'tags' => 'friendly',
            'status' => 'available',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('pets.index'));
    }

    public function testEditReturnsViewWithPet()
    {
        $this->petService
            ->expects($this->once())
            ->method('getPet')
            ->with(1)
            ->willReturn(
                [
                    'id' => 1,
                    'name' => 'Fido',
                    'category' => ['id' => 1, 'name' => 'Dog'],
                    'photoUrls' => ['http://example.com/fido.jpg'],
                    'tags' => [['id' => 0, 'name' => 'friendly']],
                    'status' => 'available'
                ]
            );

        $response = $this->get('/pets/1/edit');

        $response->assertStatus(200);
        $response->assertViewIs('pets.edit');
        $response->assertViewHas('pet');
    }

    public function testUpdateRedirectsToIndex()
    {
        $this->petService
            ->expects($this->once())
            ->method('updatePet')
            ->with($this->isInstanceOf(Request::class), '1')
            ->willReturn(
                [
                    'id' => 1,
                    'name' => 'Fido Updated',
                    'category' => ['id' => 1, 'name' => 'Dog'],
                    'photoUrls' => ['http://example.com/fido-updated.jpg'],
                    'tags' => [['id' => 0, 'name' => 'friendly']],
                    'status' => 'available'
                ]
            );

        $response = $this->put('/pets/1', [
            'id' => 1,
            'category_id' => 1,
            'category_name' => 'Dog',
            'name' => 'Fido Updated',
            'photoUrls' => 'http://example.com/fido-updated.jpg',
            'tags' => 'friendly',
            'status' => 'available',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('pets.index'));
    }

    public function testDestroyRedirectsToIndex()
    {
        $this->petService
            ->expects($this->once())
            ->method('deletePet')
            ->with(1)
            ->willReturn(['message' => 'Pet deleted']);

        $response = $this->delete('/pets/1');

        $response->assertStatus(302);
        $response->assertRedirect(route('pets.index'));
    }
}
