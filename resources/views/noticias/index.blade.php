@extends('app')

@section('title', 'Notícias | Painel de Administração')

@section('content')
<!-- ✅ Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
    .container { animation: fadeIn 0.5s ease-in-out; }
    h1 { color: #233876; font-weight: 700; letter-spacing: -0.5px; }
    .btn-primary {
        background: #4a68ff; border: none; border-radius: 6px; font-weight: 500;
        font-size: 0.95rem; padding: 0.55rem 1rem; transition: all 0.3s ease;
    }
    .btn-primary:hover { background: #3b57e0; transform: translateY(-1px); }
    .section-divider {
        border: none; height: 1px; background-color: #000;
        margin: 0 0 1.8rem 0; box-shadow: 0 1px 2px rgba(0,0,0,0.08);
    }
    .card { border: none; border-radius: 15px; box-shadow: 0 5px 18px rgba(0,0,0,0.08); transition: all 0.3s ease-in-out; overflow: hidden; }
    .card:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(0,0,0,0.12); }
    .card-img-top { height: 180px; object-fit: cover; border-bottom: 1px solid #eee; }
    .badge { font-size: 0.8rem; font-weight: 600; border-radius: 6px; }
    .card-body { padding: 1rem 1.2rem; }
    .card-title { font-size: 1.1rem; font-weight: 600; color: #233876; margin-bottom: 0.4rem; }
    .card-text { font-size: 0.9rem; color: #555; }
    .card-footer { background: transparent; border-top: none; display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 1.2rem 1rem; }
    .btn-sm { border-radius: 6px; width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center; font-size: 0.9rem; margin: 0 2px; }
    .btn-warning { color: #fff; background: #f0ad4e; border: none; }
    .btn-warning:hover { background: #e69b2d; transform: scale(1.05); }
    .btn-danger { background: #dc3545; border: none; }
    .btn-danger:hover { background: #b52a36; transform: scale(1.05); }
    .modal-dialog { max-width: 900px; }
    .modal-content { border-radius: 12px; border: none; box-shadow: 0 6px 28px rgba(0,0,0,0.25); animation: modalFadeIn 0.3s ease-in-out; max-height: 85vh; overflow-y: auto; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes modalFadeIn { from { opacity: 0; transform: scale(0.9); } to { opacity: 1; transform: scale(1); } }
    .form-label { font-weight: 600; }
    .form-control, .form-select { border-radius: 10px; }
    .form-control:focus, .form-select:focus { border-color: #4a68ff; box-shadow: 0 0 0 1px rgba(74, 104, 255, 0.3); }
    .preview-img { max-width: 100%; height: 160px; object-fit: cover; border-radius: 10px; margin-top: 10px; border: 1px solid #ddd; }
</style>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1><i class="bi bi-megaphone me-2"></i>Lista de Notícias</h1>
        <button class="btn btn-primary" id="btnNovaNoticia" data-bs-toggle="modal" data-bs-target="#modalNovaNoticia">
            <i class="bi bi-plus-circle me-1"></i> Nova Notícia
        </button>
    </div>

    <hr class="section-divider">

    @if(session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    @if($noticias->count() > 0)
        <div class="row g-4">
            @foreach ($noticias as $noticia)
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100">
                        @if($noticia->imagem)
                            <img src="{{ asset('storage/' . $noticia->imagem) }}" class="card-img-top" alt="{{ $noticia->titulo }}">
                        @else
                            <img src="https://via.placeholder.com/300x180.png?text=Sem+Imagem" class="card-img-top" alt="Sem imagem">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $noticia->titulo }}</h5>
                            <p class="card-text mb-1">
                                <span class="badge bg-secondary">{{ $noticia->categoria->nome }}</span>
                            </p>
                            <p class="card-text text-muted" style="font-size: 0.85rem;">
                                {{ Str::limit($noticia->resumo, 80) }}
                            </p>
                            <p class="text-muted small mb-0">Código: <strong>{{ $noticia->codigo }}</strong></p>
                        </div>
                        <div class="card-footer">
                            <span class="badge bg-{{ $noticia->status ? 'success' : 'secondary' }}">
                                <i class="bi bi-{{ $noticia->status ? 'check-circle-fill' : 'slash-circle' }} me-1"></i>
                                {{ $noticia->status ? 'Ativo' : 'Não ativo' }}
                            </span>
                            <div>
                                <button 
                                    class="btn btn-warning btn-sm btn-editar"
                                    data-id="{{ $noticia->id }}"
                                    data-titulo="{{ $noticia->titulo }}"
                                    data-resumo="{{ $noticia->resumo }}"
                                    data-descricao="{{ $noticia->descricao }}"
                                    data-categoria="{{ $noticia->categoria_id }}"
                                    data-status="{{ $noticia->status }}"
                                    data-codigo="{{ $noticia->codigo }}"
                                    data-imagem="{{ $noticia->imagem ? asset('storage/' . $noticia->imagem) : '' }}"
                                    title="Editar"
                                >
                                    <i class="bi bi-pencil"></i>
                                </button>

                                <form action="{{ route('noticias.destroy', $noticia->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" title="Excluir" onclick="return confirm('Deseja excluir esta notícia?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center text-muted py-5">
            <i class="bi bi-inbox" style="font-size: 2rem;"></i>
            <p class="mt-2">Nenhuma notícia cadastrada ainda.</p>
        </div>
    @endif
</div>

<!-- 📰 MODAL NOVA/EDITAR NOTÍCIA -->
<div class="modal fade" id="modalNovaNoticia" tabindex="-1" aria-labelledby="modalNovaNoticiaLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content p-3">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Nova Notícia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formNoticia" action="{{ route('noticias.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">

                    <!-- ✅ Código e Título -->
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Código</label>
                            <input type="text" name="codigo" id="codigo" class="form-control" 
                                   value="{{ $proximoCodigo ?? '01' }}" readonly>
                            <small class="text-muted">Gerado automaticamente</small>
                        </div>
                        <div class="col-md-9 mb-3">
                            <label class="form-label">Título <span class="text-danger">*</span></label>
                            <input type="text" name="titulo" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Resumo</label>
                        <textarea name="resumo" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descrição Completa <span class="text-danger">*</span></label>
                        <textarea name="descricao" class="form-control" rows="4" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Categoria <span class="text-danger">*</span></label>
                        <select name="categoria_id" class="form-select" required>
                            <option value="">Selecione...</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Imagem <span class="text-danger">*</span></label>
                        <input type="file" name="imagem" id="imagemInput" class="form-control" accept="image/*" required>
                        <img id="previewImagem" class="preview-img d-none mt-2" alt="Preview">
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="status" name="status" value="1" checked>
                        <label class="form-check-label" for="status">Ativo / Não ativo</label>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formNoticia');
    const formMethod = document.getElementById('formMethod');
    const modal = new bootstrap.Modal(document.getElementById('modalNovaNoticia'));
    const modalTitle = document.querySelector('#modalNovaNoticia .modal-title');
    const codigoInput = document.getElementById('codigo');
    const tituloInput = form.querySelector('[name="titulo"]');
    const resumoInput = form.querySelector('[name="resumo"]');
    const descricaoInput = form.querySelector('[name="descricao"]');
    const categoriaSelect = form.querySelector('[name="categoria_id"]');
    const statusCheck = form.querySelector('[name="status"]');
    const imagemInput = document.getElementById('imagemInput');
    const previewImagem = document.getElementById('previewImagem');

    // 🟢 Nova notícia
    document.getElementById('btnNovaNoticia').addEventListener('click', () => {
        form.reset();
        previewImagem.classList.add('d-none');
        form.action = "{{ route('noticias.store') }}";
        formMethod.value = 'POST';
        modalTitle.innerHTML = '<i class="bi bi-plus-circle me-2"></i>Nova Notícia';
        codigoInput.value = "{{ $proximoCodigo ?? '01' }}";
        imagemInput.required = true;
    });

    // 🟠 Editar notícia
    document.querySelectorAll('.btn-editar').forEach(btn => {
        btn.addEventListener('click', () => {
            tituloInput.value = btn.dataset.titulo;
            resumoInput.value = btn.dataset.resumo;
            descricaoInput.value = btn.dataset.descricao;
            categoriaSelect.value = btn.dataset.categoria;
            statusCheck.checked = btn.dataset.status == 1;
            codigoInput.value = btn.dataset.codigo;

            if (btn.dataset.imagem) {
                previewImagem.src = btn.dataset.imagem;
                previewImagem.classList.remove('d-none');
            } else {
                previewImagem.classList.add('d-none');
            }

            form.action = `/noticias/${btn.dataset.id}`;
            formMethod.value = 'PUT';
            modalTitle.innerHTML = '<i class="bi bi-pencil-square me-2"></i>Editar Notícia';
            imagemInput.required = false;
            modal.show();
        });
    });

    // 🖼️ Preview da imagem
    imagemInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            previewImagem.src = URL.createObjectURL(file);
            previewImagem.classList.remove('d-none');
        } else {
            previewImagem.classList.add('d-none');
        }
    });
});
</script>
@endsection
