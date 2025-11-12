<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NoticiaController extends Controller
{
    /**
     * 📄 Lista todas as notícias.
     */
    public function index()
    {
        $noticias = Noticia::with('categoria')->latest()->get();
        $categorias = Categoria::all();

        // ✅ Gera o próximo código automaticamente (01, 02, 03...)
        $ultimoCodigo = Noticia::max('codigo') ?? 0;
        $proximoCodigo = str_pad($ultimoCodigo + 1, 2, '0', STR_PAD_LEFT);

        return view('noticias.index', compact('noticias', 'categorias', 'proximoCodigo'));
    }

    /**
     * 📝 Exibe o formulário de criação de uma nova notícia.
     */
    public function create()
    {
        $categorias = Categoria::all();

        // ✅ Gera o próximo código automático (01, 02, 03...)
        $ultimoCodigo = Noticia::max('codigo') ?? 0;
        $proximoCodigo = str_pad($ultimoCodigo + 1, 2, '0', STR_PAD_LEFT);

        return view('noticias.create', compact('categorias', 'proximoCodigo'));
    }

    /**
     * 💾 Salva uma nova notícia.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'imagem' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'resumo' => 'nullable|string|max:255',
            'status' => 'nullable|boolean',
        ], [
            'categoria_id.required' => 'Selecione uma categoria.',
            'titulo.required' => 'O título é obrigatório.',
            'descricao.required' => 'A descrição é obrigatória.',
            'imagem.required' => 'A imagem é obrigatória.',
            'imagem.image' => 'O arquivo deve ser uma imagem válida.',
        ]);

        // ✅ Gera o código automático (01, 02, 03...)
        $ultimoCodigo = Noticia::max('codigo') ?? 0;
        $novoCodigo = str_pad($ultimoCodigo + 1, 2, '0', STR_PAD_LEFT);

        // ✅ Salva imagem no storage
        $imagemPath = $request->file('imagem')->store('noticias', 'public');

        // ✅ Cria a notícia
        Noticia::create([
            'codigo' => $novoCodigo,
            'categoria_id' => $validated['categoria_id'],
            'titulo' => $validated['titulo'],
            'resumo' => $validated['resumo'] ?? null,
            'descricao' => $validated['descricao'],
            'status' => $request->has('status') ? 1 : 0,
            'imagem' => $imagemPath,
        ]);

        return redirect()->route('noticias.index')
            ->with('success', '✅ Notícia cadastrada com sucesso!');
    }

    /**
     * ✏️ Exibe o formulário de edição de uma notícia existente.
     */
    public function edit(Noticia $noticia)
    {
        $categorias = Categoria::all();
        return view('noticias.edit', compact('noticia', 'categorias'));
    }

    /**
     * 🔄 Atualiza os dados de uma notícia existente.
     */
    public function update(Request $request, Noticia $noticia)
    {
        $validated = $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'titulo' => 'required|string|max:255',
            'descricao' => 'required|string',
            'imagem' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'resumo' => 'nullable|string|max:255',
            'status' => 'nullable|boolean',
        ], [
            'categoria_id.required' => 'Selecione uma categoria.',
            'titulo.required' => 'O título é obrigatório.',
            'descricao.required' => 'A descrição é obrigatória.',
            'imagem.image' => 'O arquivo deve ser uma imagem válida.',
        ]);

        $data = [
            'categoria_id' => $validated['categoria_id'],
            'titulo' => $validated['titulo'],
            'resumo' => $validated['resumo'] ?? null,
            'descricao' => $validated['descricao'],
            'status' => $request->has('status') ? 1 : 0,
        ];

        // ✅ Atualiza imagem se houver nova
        if ($request->hasFile('imagem')) {
            if ($noticia->imagem) {
                Storage::disk('public')->delete($noticia->imagem);
            }
            $data['imagem'] = $request->file('imagem')->store('noticias', 'public');
        }

        $noticia->update($data);

        return redirect()->route('noticias.index')
            ->with('success', '✏️ Notícia atualizada com sucesso!');
    }

    /**
     * ❌ Exclui uma notícia.
     */
    public function destroy(Noticia $noticia)
    {
        if ($noticia->imagem) {
            Storage::disk('public')->delete($noticia->imagem);
        }

        $noticia->delete();

        return redirect()->route('noticias.index')
            ->with('success', '🗑️ Notícia excluída com sucesso!');
    }
}
