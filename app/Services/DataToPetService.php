<?php

declare(strict_types=1);

namespace App\Services;

use App\Interfaces\DataToPetServiceInterface;
use Illuminate\Http\Request;

class DataToPetService implements DataToPetServiceInterface
{
    public function parse(Request $request, int $id): array
    {
        return [
            'id' => $id,
            'category' => [
                'id' => $request->input('category_id'),
                'name' => $request->input('category_name')
            ],
            'name' => $request->input('name'),
            'photoUrls' => explode(',', $request->input('photoUrls')),
            'tags' => array_map(function($tag) {
                return ['id' => 0, 'name' => $tag];
            }, explode(',', $request->input('tags'))),
            'status' => $request->input('status')
        ];
    }

    public function isDataSetCorrectly(Request $request): bool
    {
        return !$request->input('id')
            || !$request->input('category_id')
            || !$request->input('category_name')
            || !$request->input('name')
            || !$request->input('photoUrls')
            || !$request->input('tags')
            || !$request->input('status');
    }
}
