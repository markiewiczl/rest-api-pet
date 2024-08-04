<?php

declare(strict_types=1);

namespace App\Services;

use App\Interfaces\DataToPetServiceInterface;
use App\Interfaces\PetServiceInterface;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

class PetService implements PetServiceInterface
{
    private Client $client;

    public function __construct(
        private readonly DataToPetServiceInterface $dataToPet
    )
    {
        $this->client = new Client([
            'base_uri' => PetServiceInterface::PET_SERVICE_URL,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function getPets(string $status = 'available'): array
    {
        try {
            $response = $this->client->get('pet/findByStatus', [
                'query' => ['status' => $status]
            ]);

            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            throw new Exception('Error fetching pets', 0, $e);
        }
    }

    /**
     * @inheritDoc
     */
    public function getPet(int $id): array
    {
        try {
            $response = $this->client->get("pet/{$id}");

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            throw new Exception('Error fetching pet', 0, $e);
        }
    }

    /**
     * @inheritDoc
     */
    public function addPet(Request $request): array
    {
        if ($this->dataToPet->isDataSetCorrectly($request))
        {
            throw new Exception('All fields need to be fulfilled', 0);
        }

        $data = $this->dataToPet->parse($request, (int)$request->input('id'));

        try {
            $response = $this->client->post('pet', [
                'json' => $data
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            throw new Exception($e->getMessage(), 0, $e);
        }
    }

    /**
     * @inheritDoc
     */
    public function updatePet(Request $request, string $id): array
    {
        if ($this->dataToPet->isDataSetCorrectly($request))
        {
            throw new Exception('All fields need to be fulfilled', 0);
        }

        $data = $this->dataToPet->parse($request, (int)$id);

        try {
            $response = $this->client->put('pet', [
                'json' => $data
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            throw new Exception('Error updating pet', 0, $e);
        }
    }

    /**
     * @inheritDoc
     */
    public function deletePet(int $id): array
    {
        try {
            $response = $this->client->delete("pet/{$id}");

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            throw new Exception('Error deleting pet', 0, $e);
        }
    }
}
