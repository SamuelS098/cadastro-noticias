@extends('app')

@section('title', 'Editar Notícia | Painel de Administração')

@section('content')
<!-- ✅ Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
    .container {
        max-width: 800px;
        margin-top: 30px;
        animation: fadeIn 0.4s ease-in-out;
    }

    h1 {
        color: #233876;
        font-weight: 700;
        margin-bottom: 1.5rem;
    }

    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 18px rgba(0, 0, 0, 0.08);
        padding: 1.5rem;
    }

    label {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.4rem;
    }

    input, select, textarea {
        border-radius: 8px;
    }

    textarea {
        min-height: 150px;
    }

    .btn-primary {
        background: #4a68ff;
        border: none;
        border-radius: 6px;
        font-weight: 500;
        padding: 0.55rem 1.2rem;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: #3b57e0;
        transform: translateY(-1px);
    }

    .btn-secondary {
        background: #6c757d;
        border: none;
        border-radius: 6px;
        font-weight: 500;
        padding: 0.55rem 1.2rem;
    }

    .form-check-input {
        cursor: pointer;
        transform: scale(1.1);
    }

    .img-preview {
        max-height: 200px;
        border-radius: 10px;
        margin-top: 10px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="container">
    <h1><i class="bi bi-pencil-square me-2"></i>Editar Notícia</h1>

    <div class="card">
        <form action="{{ route('noticias.update', $noticia->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" name="titulo" id="titulo" class="form-control" 
                       value="{{ old('titulo', $noticia->titulo) }}" required>
                @error('titulo') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="resumo" class="form-label">Resumo</label>
                <textarea name="resumo" id="resumo" class="form-control">{{ old('resumo', $noticia->resumo) }}</textarea>
                @error('resumo') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="descricao" class="form-label">Conteúdo Completo</label>
                <textarea name="descricao" id="descricao" class="form-control">{{ old('descricao', $noticia->descricao) }}</textarea>
                @error('descricao') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label for="categoria_id" class="form-label">Categoria</label>
                <select name="categoria_id" id="categoria_id" class="form-select" required>
                    <option value="">Selecione uma categoria</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" 
                            {{ old('categoria_id', $noticia->categoria_id) == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nome }}
                        </option>
                    @endforeach
                </select>
                @error('categoria_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <!-- ✅ IMAGEM - não obrigatória no edit -->
            <div class="mb-3">
                <label for="imagem" class="form-label">Imagem da Notícia (opcional)</label>
                <input type="file" name="imagem" id="imagem" class="form-control" accept="image/*" onchange="previewImage(event)">
                @error('imagem') <small class="text-danger">{{ $message }}</small> @enderror

                @if($noticia->imagem)
                    <div class="mt-2">
                        <p class="mb-1 text-muted">Imagem atual:</p>
                        <img src="{{ asset('storage/' . $noticia->imagem) }}" class="img-preview" id="currentImage" alt="Imagem atual">
                    </div>
                @endif

                <img id="preview" class="img-preview d-none" alt="Prévia da nova imagem">
            </div>

            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" id="status" name="status" value="1" 
                       {{ old('status', $noticia->status) ? 'checked' : '' }}>
                <label class="form-check-label" for="status">Ativar notícia</label>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('noticias.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Voltar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Atualizar Notícia
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // 🔄 Preview da nova imagem
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('preview');
        const current = document.getElementById('currentImage');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                if (current) current.classList.add('d-none');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
