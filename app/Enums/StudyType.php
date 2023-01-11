<?php

namespace App\Enums;

enum StudyType: string
{
    case secondary = 'secondary';
    case postSecondary = 'post_secondary';
    case university = 'university';
    case postGrad = 'post_grad';

    case other = 'other';
}
