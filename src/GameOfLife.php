<?php

declare(strict_types=1);

class GameOfLife
{
    const RED = "[\e[41m 0 \e[0m]";
    const GREEN = "[\e[42m 1 \e[0m]";

    private function consoleOutput(array $grid): void
    {
        echo "\n";
        foreach ($grid as $row) {
            $rowColoured = "";
            foreach ($row as $cell) {
                $toEcho = $cell == 0 ? GameOfLife::RED : GameOfLife::GREEN;
                $rowColoured .= $toEcho;
            }
            echo $rowColoured . "\n";
        }
    }

    private function haveAGrid(array $checkGrid): void
    {
        if (count($checkGrid) === 0) {
            throw new InvalidArgumentException('Grid is empty');
        }
    }

    public function nextGrid(array $grid): array
    {
        $this->haveAGrid($grid);
        $gridColumns = count($grid[0]);
        $gridRows = count($grid);
        $newGrid = [];

        $this->consoleOutput($grid);

        if ($gridRows === 1 && $gridColumns == 1) {
            return [[0]];
        }

        if ($gridRows === 1 && $gridColumns == 2) {
            return [[0,0]];
        }

        if ($gridColumns == 1 && $gridRows == 2) {
            return [[0],[0]];
        }

        for ($i = 0; $i <= $gridRows - 1; $i++) {
            $newRow = [];
            for ($k = 0; $k <= $gridColumns - 1; $k++) {
                $columnNumber = $k;
                $rowNumber = $i;

                $cellNeighboursTotal = $this->calculateTotalValueOfCellNeighbours($grid, $columnNumber, $rowNumber);

                $isCurrentCellAlive = $grid[$i][$k] === 1;
                if ($isCurrentCellAlive && ($cellNeighboursTotal === 2 || $cellNeighboursTotal === 3)) {
                    $newRow[] = 1;
                    continue;
                }

                $isCurrentCellDead = $grid[$i][$k] === 0;
                if ($isCurrentCellDead && $cellNeighboursTotal === 3) {
                    $newRow[] = 1;
                    continue;
                }
                $newRow[] = 0;
            }
            $newGrid[] = $newRow;
        }

        $this->consoleOutput($newGrid);

        return $newGrid;
    }

    public function calculateTotalValueOfCellNeighbours(array $grid, int $columnNumber, int $rowNumber): int
    {
        $cellNeighboursTotal = 0;
        $cellToTheLeft = $columnNumber - 1;
        $cellToTheRight = $columnNumber + 1;
        $rowBelow = $rowNumber + 1;
        $rowAbove = $rowNumber - 1;

        $cellNeighboursTotal += $this->cellValue($grid, $rowNumber, $cellToTheLeft);
        $cellNeighboursTotal += $this->cellValue($grid, $rowNumber, $cellToTheRight);
        $cellNeighboursTotal += $this->cellValue($grid, $rowBelow, $cellToTheLeft);
        $cellNeighboursTotal += $this->cellValue($grid, $rowBelow, $columnNumber);
        $cellNeighboursTotal += $this->cellValue($grid, $rowBelow, $cellToTheRight);
        $cellNeighboursTotal += $this->cellValue($grid, $rowAbove, $cellToTheLeft);
        $cellNeighboursTotal += $this->cellValue($grid, $rowAbove, $columnNumber);
        $cellNeighboursTotal += $this->cellValue($grid, $rowAbove, $cellToTheRight);

        return $cellNeighboursTotal;
    }

    public function cellValue(array $grid, int $rowNumber, int $columnNumber): int
    {
        return isset($grid[$rowNumber][$columnNumber]) ? $grid[$rowNumber][$columnNumber] : 0;
    }
}