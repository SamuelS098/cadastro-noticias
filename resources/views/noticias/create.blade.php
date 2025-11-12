@extends('app')

@section('title', 'Nova Notícia | Painel de Administração')

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

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="container">
    <h1><i class="bi bi-plus-circle me-2"></i>Nova Notícia</h1>

    <div class="card">
        <form action="{{ route('noticias.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- ✅ Código (Automático e Somente Leitura) -->
            <div class="mb-3">
                <label for="codigo" class="form-label">Código <span class="text-danger">*</span></label>
                <input type="text" name="codigo" id="codigo" class="form-control"
                       value="{{ $proximoCodigo ?? '001' }}" readonly>
                <small class="text-muted">Gerado automaticamente (não é necessário preencher)</small>
                @error('codigo') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <!-- ✅ Categoria -->
            <div class="mb-3">
                <label for="categoria_id" class="form-label">Categoria <span class="text-danger">*</span></label>
                <select name="categoria_id" id="categoria_id" class="form-select" required>
                    <option value="">Selecione uma categoria</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nome }}
                        </option>
                    @endforeach
                </select>
                @error('categoria_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <!-- ✅ Título -->
            <div class="mb-3">
                <label for="titulo" class="form-label">Título <span class="text-danger">*</span></label>
                <input type="text" name="titulo" id="titulo" class="form-control"
                       placeholder="Digite o título da notícia" value="{{ old('titulo') }}" required>
                @error('titulo') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <!-- ✅ Resumo -->
            <div class="mb-3">
                <label for="resumo" class="form-label">Resumo</label>
                <textarea name="resumo" id="resumo" class="form-control"
                          placeholder="Resumo breve da notícia">{{ old('resumo') }}</textarea>
                @error('resumo') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <!-- ✅ Descrição Completa -->
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição Completa <span class="text-danger">*</span></label>
                <textarea name="descricao" id="descricao" class="form-control"
                          placeholder="Digite o conteúdo completo da notícia" required>{{ old('descricao') }}</textarea>
                @error('descricao') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <!-- ✅ Imagem -->
            <div class="mb-3">
                <label for="imagem" class="form-label">Imagem da Notícia <span class="text-danger">*</span></label>
                <input type="file" name="imagem" id="imagem" class="form-control" accept="image/*" required>
                @error('imagem') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <!-- ✅ Status -->
            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" id="status" name="status" value="1"
                       {{ old('status') ? 'checked' : '' }}>
                <label class="form-check-label" for="status">Ativar notícia</label>
            </div>

            <!-- ✅ Botões -->
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('noticias.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Voltar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Salvar Notícia
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
