<?php

declare(strict_types=1);

namespace App\Interfaces;

use Illuminate\Http\Request;

interface PetServiceInterface
{
    public const PET_SERVICE_URL = 'https://petstore.swagger.io/v2/';

    /**
     * Returns array of pets
     *
     * @return array
     */
    public function getPets(): array;

    /**
     * Get pet by id
     *
     * @param int $id
     * @return array
     */
    public function getPet(int $id): array;

    /**
     * Add new pet
     *
     * @param Request $request
     * @return array
     */
    public function addPet(Request $request): array;

    /**
     * Update pet by id
     *
     * @param array $data
     * @return array
     */
    public function updatePet(Request $request, int $id): array;

    /**
     * Removing pet by id
     *
     * @param int $id
     * @return array
     */
    public function deletePet(int $id): array;
}
