<?php

namespace App\Repositories;

use App\Interfaces\MatrixRepositoryInterface;
use App\Models\Layout;
use Illuminate\Http\Request;

class MatrixRepository implements MatrixRepositoryInterface
{
    public function MatrixResponseFormat($matrixResult)
    {
        $MatrixResponseFormat = [];
        foreach ($matrixResult as $row) {
            $MatrixResponseFormat[] = implode(',', $row);
        }
        return $MatrixResponseFormat;
    }
    public function generateMatrix($x, $y)
    { 
        $top = 0;
        $left = 0;
        $right = $x - 1;
        $bottom = $y - 1;
        $direction = 0;
        $sayac = -1;
        $matrixResult = array_fill(0, $y, array_fill(0, $x, 0));

        while ($top <= $bottom && $left <= $right) {
            if ($direction == 0) {
                for ($i = $left; $i <= $right; $i++) {
                    $sayac++;
                    $matrixResult[$top][$i] = $sayac;
                }
                $top++;
                $direction = 1;
            } elseif ($direction == 1) {
                for ($i = $top; $i <= $bottom; $i++) {
                    $sayac++;
                    $matrixResult[$i][$right] = $sayac;
                }
                $right--;
                $direction = 2;
            } elseif ($direction == 2) {
                for ($i = $right; $i >= $left; $i--) {
                    $sayac++;
                    $matrixResult[$bottom][$i] = $sayac;
                }
                $bottom--;
                $direction = 3;
            } else {
                for ($i = $bottom; $i >= $top; $i--) {
                    $sayac++;
                    $matrixResult[$i][$left] = $sayac;
                }
                $left++;
                $direction = 0;
            }
        }
        return $matrixResult;
    }

    public function createLayout($x, $y)
    {
        $matrixResult = $this->generateMatrix($x, $y);
        $matrixDbFormat = json_encode($matrixResult);
        $data = Layout::create(['matrixTable' => $matrixDbFormat]);
        $matrixResponseFormat = $this->MatrixResponseFormat($matrixResult);
        return [
            'id' => $data->id,
            'created_at' => $data->created_at,
            'updated_at' => $data->updated_at,
            'matrixTable' => $matrixResponseFormat
        ];
    }
    public function getAllListLayout()
    {
        $layouts = Layout::all();
        $allLayouts = [];
        foreach ($layouts as $layout) {
            $matrixResult = json_decode($layout->matrixTable, true);
            $matrixResponseFormat = $this->MatrixResponseFormat($matrixResult);
            $allLayouts[] = [
                'id' => $layout->id,
                'created_at' => $layout->created_at,
                'updated_at' => $layout->updated_at,
                'matrixTable' => $matrixResponseFormat
            ];
        }
        return $allLayouts;
    }
    public function getLayoutValue($x, $y, $layoutId)
    {
        $layout = Layout::find($layoutId);
        $matrix = json_decode($layout->matrixTable, true);
        return $matrix[$y][$x];
    }
}