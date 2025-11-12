<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = ['codigo', 'nome'];

    /**
     * Evento "booted" — executa ações automáticas quando o model é criado.
     */
    protected static function booted()
    {
        static::creating(function ($categoria) {
            // Se o campo "codigo" não foi preenchido manualmente
            if (empty($categoria->codigo)) {
                $ultimoId = self::max('id') ?? 0;
                $categoria->codigo = 'CAT' . str_pad($ultimoId + 1, 3, '0', STR_PAD_LEFT);
            }
        });
    }
}
