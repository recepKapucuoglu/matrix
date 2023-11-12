<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface MatrixRepositoryInterface
{
    public function createLayout($x,$y); 
    public function getAllListLayout();
    public function getLayoutValue($x,$y,$layoutId);
    public function generateMatrix($x, $y);
    public function MatrixResponseFormat($matrixResult);
}
