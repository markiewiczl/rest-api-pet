<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Services\DataToPetService;
use Illuminate\Http\Request;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DataToPetServiceTest extends TestCase
{
    private DataToPetService $object;

    protected function setUp(): void
    {
        $this->object = new DataToPetService();
    }

    #[DataProvider('requestDataProvider')]
    public function testParseWorkingCorrectly(MockObject|Request $request, array $result)
    {
        $expectedResult = $this->object->parse($request, 1);

        $this->assertSame($expectedResult, $result);
    }

    #[DataProvider('requestDataProvider')]
    public function testDataIsCheckedCorrectly(MockObject|Request $request, array $result, bool $isDataSetCorrectly)
    {
        $expectedResult = $this->object->isDataSetCorrectly($request);

        $this->assertSame($expectedResult, $isDataSetCorrectly);
    }

    public static function requestDataProvider(): array
    {
        $requestWithData = (new self('createMockRequestWithData'))->createMockRequestWithData();
        $requestWithoutData = (new self('createMockRequestWithoutData'))->createMockRequestWithoutData();

        return [
            [
                $requestWithData,
                [
                    'id' => 1,
                    'category' => [
                        'id' => '1',
                        'name' => 'test_category_name'
                    ],
                    'name' => 'test_name',
                    'photoUrls' => ['test_photo_url'],
                    'tags' => [[
                        'id' => 0,
                        'name' => 'test_tag_name'
                    ]],
                    'status' => 'available'
                ],
                true
            ],
            [
                $requestWithoutData,
                [
                    'id' => 1,
                    'category' => [
                        'id' => '',
                        'name' => ''
                    ],
                    'name' => '',
                    'photoUrls' => [''],
                    'tags' => [[
                        'id' => 0,
                        'name' => ''
                    ]],
                    'status' => ''
                ],
                false
            ]
        ];
    }

    private function createMockRequestWithData(): Request
    {
        $request = $this->createMock(Request::class);

        $request->expects($this->exactly(6))
            ->method('input')
            ->willReturnOnConsecutiveCalls(
                '1',
                'test_category_name',
                'test_name',
                'test_photo_url',
                'test_tag_name',
                'available'
            );

        return $request;
    }

    private function createMockRequestWithoutData(): Request
    {
        $request = $this->createMock(Request::class);

        $request->expects($this->any())
            ->method('input')
            ->willReturn(
                ''
            );

        return $request;
    }
}
