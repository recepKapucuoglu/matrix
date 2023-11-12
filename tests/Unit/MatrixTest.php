<?php

namespace Tests\Unit;

use App\Repositories\MatrixRepository;
use PHPUnit\Framework\TestCase;

class MatrixTest extends TestCase
{
    public function testMatrixResponseFormat()
    {
        $matrixResult = [
            [1, 2, 3],
            [8, 9, 4],
            [7, 6, 5],
        ];
        $expectedResult = [
            '1,2,3',
            '8,9,4',
            '7,6,5',
        ];
        $matrixRepository = new MatrixRepository();
        $actualResult = $matrixRepository->MatrixResponseFormat($matrixResult);
        $this->assertEquals($expectedResult, $actualResult);
    }

    public function testGenerateMatrix()
    {
        $matrixRepo = new MatrixRepository();
        $matrixResult1 = $matrixRepo->generateMatrix(3, 3);
        $expectedResult1 = [
            [0, 1, 2],
            [7, 8, 3],
            [6, 5, 4],
        ];
        $this->assertEquals($expectedResult1, $matrixResult1);
        $matrixResult2 = $matrixRepo->generateMatrix(4, 3);
        $expectedResult2 = [
            [0, 1, 2, 3],
            [9, 10, 11, 4],
            [8, 7, 6, 5],
        ];
        $this->assertEquals($expectedResult2, $matrixResult2);
    }
}
