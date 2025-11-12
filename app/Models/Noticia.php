<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',       // ✅ adicionado
        'categoria_id',
        'titulo',
        'resumo',
        'descricao',
        'status',
        'imagem',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
