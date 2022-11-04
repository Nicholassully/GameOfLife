<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class GameOfLifeTest extends TestCase
{
    public function testThrowsErrorForEmptyGrid(): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectErrorMessage('Grid is empty');

        $gameOfLife = new GameOfLife();
        $gameOfLife->nextGrid([]);
    }

    /**
     * @dataProvider gridProvider
     */
    public function testGridCombinations(array $grid, array $expectedResults): void
    {
        $gameOfLife = new GameOfLife();
        $result = $gameOfLife->nextGrid($grid);

        self::assertEquals($expectedResults, $result);
    }

    public function gridProvider(): array
    {
        return [
            'Grid has one row and one column' => [
                'grid' =>  [
                    [1]
                ],
                'expectedResults' => [
                    [0]
                ],
            ],
            'Grid has one row and two columns' => [
                'grid' =>  [
                    [1,0]
                ],
                'expectedResults' => [
                    [0,0]
                ],
            ],
            'Grid has one column and two rows' => [
                'grid' =>  [
                    [1],
                    [0]
                ],
                'expectedResults' => [
                    [0],
                    [0]
                ],
            ],
            'One row all ones in the row' => [
                'grid' =>  [
                    [1,1,1,1]
                ],
                'expectedResults' => [
                    [0,1,1,0]
                ],
            ],
            'One row all zeros in the row' => [
                'grid' =>  [
                    [0,0,0,0]
                ],
                'expectedResults' => [
                    [0,0,0,0]
                ],
            ],
            'Three rows one column all with ones' => [
                'grid' =>  [
                    [1],
                    [1],
                    [1]
                ],
                'expectedResults' => [
                    [0],
                    [1],
                    [0]
                ],
            ],
            'Three rows one column all with zeros' => [
                'grid' =>  [
                    [0],
                    [0],
                    [0]
                ],
                'expectedResults' => [
                    [0],
                    [0],
                    [0]
                ],
            ],
            'In the next grid cell one stays alive' => [
                'grid' =>  [
                    [1,1,1],
                    [1,1,1]
                ],
                'expectedResults' => [
                    [1,0,1],
                    [1,0,1]
                ],
            ],
            'In the next grid cell one comes alive' => [
                'grid' =>  [
                    [0,1,0],
                    [1,1,1]
                ],
                'expectedResults' => [
                    [1,1,1],
                    [1,1,1]
                ],
            ],
            'In the next grid cell one in row one dies' => [
                'grid' =>  [
                    [1,1,1],
                    [0,0,1]
                ],
                'expectedResults' => [
                    [0,1,1],
                    [0,0,1]
                ],
            ],
            'In the next grid with many rows and columns' => [
                'grid' => [
                    [0,1,1,0],
                    [1,1,1,0],
                    [1,1,1,0]
                ],
                'expectedResults' => [
                    [1,0,1,0],
                    [0,0,0,1],
                    [1,0,1,0]
                ]
            ]
        ];
    }

    public function testCalculateTotalValueOfCellNeighbours(): void
    {
        $grid = [
            [1,1,1,0],
            [1,1,1,0],
            [1,1,1,0],
        ];

        $gameOfLife = new GameOfLife();

        $result = $gameOfLife->calculateTotalValueOfCellNeighbours($grid, 1, 1);
        self::assertEquals(8 ,$result);
    }

    public function testCellValueReturnOneForCellInGrid(): void
    {
        $grid = [
            [1,1,1,0],
            [1,1,1,0],
            [1,1,1,0],
        ];

        $gameOfLife = new GameOfLife();

        $result = $gameOfLife->cellValue($grid, 1, 1);
        self::assertEquals(1 ,$result);
    }

    public function testCellValueReturnZeroForCellInGrid(): void
    {
        $grid = [
            [1,1,1,0],
            [1,1,1,0],
            [1,1,1,0],
        ];

        $gameOfLife = new GameOfLife();

        $result = $gameOfLife->cellValue($grid, 2, 3);
        self::assertEquals(0 ,$result);
    }

    public function testCellValueReturnZeroForCellNotInGrid(): void
    {
        $grid = [
            [1,1,1,0],
            [1,1,1,0],
            [1,1,1,0],
        ];

        $gameOfLife = new GameOfLife();

        $result = $gameOfLife->cellValue($grid, -1, -1);
        self::assertEquals(0 ,$result);
    }
}