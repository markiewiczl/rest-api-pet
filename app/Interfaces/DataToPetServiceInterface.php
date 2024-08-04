<?php
declare(strict_types=1);

namespace App\Interfaces;

use Illuminate\Http\Request;

interface DataToPetServiceInterface
{
    /** Parse request data to pet array format
     *
     * @param Request $request
     * @param int $id
     * @return array
     */
    public function parse(Request $request, int $id): array;

    /**
     * Check is all fields fulfilled
     *
     * @param Request $request
     * @return bool
     */
    public function isDataSetCorrectly(Request $request): bool;
}
