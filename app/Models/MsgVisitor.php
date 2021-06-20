<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsgVisitor extends Model
{
    use HasFactory;

    public function getFormatedCreatedAt()
    {
        // dd($this->created_at->formatLocalized('%d de %B %Y'));
        setlocale(LC_TIME, "fr_FR");
        return strftime("%e %B %Y", strtotime($this->created_at));
    }
}
