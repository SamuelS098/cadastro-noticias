<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Exibe a lista de todas as categorias cadastradas.
     */
    public function index()
    {
        $categorias = Categoria::all();

        // 🔹 Gera o próximo código numérico (01, 02, 03, ...)
        $ultimoId = Categoria::max('id') ?? 0;
        $proximoCodigo = str_pad($ultimoId + 1, 2, '0', STR_PAD_LEFT);

        return view('categorias.index', compact('categorias', 'proximoCodigo'));
    }

    /**
     * Mostra o formulário de criação de uma nova categoria.
     */
    public function create()
    {
        $ultimoId = Categoria::max('id') ?? 0;
        $proximoCodigo = str_pad($ultimoId + 1, 2, '0', STR_PAD_LEFT);

        return view('categorias.create', compact('proximoCodigo'));
    }

    /**
     * Salva uma nova categoria no banco de dados.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:100',
        ]);

        // 🔹 Gera o código automático (01, 02, 03...)
        $ultimoId = Categoria::max('id') ?? 0;
        $novoCodigo = str_pad($ultimoId + 1, 2, '0', STR_PAD_LEFT);

        // 🔹 Cria e salva a nova categoria
        Categoria::create([
            'codigo' => $novoCodigo,
            'nome' => $request->nome,
        ]);

        return redirect()->route('categorias.index')
            ->with('success', 'Categoria criada com sucesso!');
    }

    /**
     * Exibe os detalhes de uma categoria específica.
     */
    public function show(Categoria $categoria)
    {
        return view('categorias.show', compact('categoria'));
    }

    /**
     * Mostra o formulário de edição de uma categoria específica.
     */
    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Atualiza os dados de uma categoria no banco de dados.
     */
    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nome' => 'required|string|max:100',
        ]);

        $categoria->update([
            'nome' => $request->nome,
        ]);

        return redirect()->route('categorias.index')
            ->with('success', 'Categoria atualizada com sucesso!');
    }

    /**
     * Remove uma categoria do banco de dados.
     */
    public function destroy(Categoria $categoria)
    {
        $categoria->delete();

        return redirect()->route('categorias.index')
            ->with('success', 'Categoria excluída com sucesso!');
    }
}
