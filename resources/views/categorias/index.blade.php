@extends('app')

@section('title', 'Categorias | Painel de Administração')

@section('content')
<!-- ✅ Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
    .container {
        animation: fadeIn 0.6s ease-in-out;
    }

    h1 {
        color: #233876;
        font-weight: 700;
        letter-spacing: -0.5px;
    }

    .btn-primary {
        background: #4a68ff;
        border: none;
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.95rem;
        padding: 0.55rem 1rem;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: #3b57e0;
        transform: translateY(-1px);
    }

    .section-divider {
        border: none;
        height: 1px;
        background-color: #000;
        margin: 0 0 1.8rem 0;
        box-shadow: 0 1px 2px rgba(0,0,0,0.08);
    }

    .table {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
    }

    thead tr {
        background-color: #474747 !important;
    }

    thead th {
        background-color: #474747 !important;
        color: #ffffff !important;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-align: center;
        font-weight: 600;
    }

    th, td {
        vertical-align: middle;
    }

    th:first-child, td:first-child {
        width: 140px;
        text-align: center;
    }

    th:last-child, td:last-child {
        text-align: center;
        width: 150px;
    }

    .table tbody tr:hover {
        background-color: #f2f6ff;
        transform: scale(1.01);
        transition: all 0.2s ease-in-out;
    }

    .alert-success {
        border-radius: 10px;
        font-weight: 500;
        box-shadow: 0 4px 12px rgba(0, 128, 0, 0.1);
        animation: fadeSlide 0.6s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeSlide {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .btn-sm {
        border-radius: 6px;
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
        margin: 0 2px;
    }

    .btn-warning {
        color: #fff;
        background: #f0ad4e;
        border: none;
    }

    .btn-warning:hover {
        background: #e69b2d;
        transform: scale(1.05);
    }

    .btn-danger {
        background: #dc3545;
        border: none;
    }

    .btn-danger:hover {
        background: #b52a36;
        transform: scale(1.05);
    }

    .modal-content {
        border: 1px solid #000;
        border-radius: 12px;
        box-shadow: 0 8px 28px rgba(0, 0, 0, 0.25);
        background: #fff;
        padding: 1rem 2rem;
        animation: modalFadeIn 0.3s ease-in-out;
    }

    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
    }

    .modal-header {
        border-bottom: none;
        text-align: center;
        flex-direction: column;
    }

    .modal-title {
        color: #233876;
        font-weight: 700;
        font-size: 1.4rem;
    }

    .form-label {
        font-weight: 600;
    }

    .form-control {
        border-radius: 10px;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        border-color: #4a68ff;
        box-shadow: 0 0 0 1px rgba(74, 104, 255, 0.35);
        outline: none;
    }

    .btn-close {
        position: absolute;
        right: 1rem;
        top: 1rem;
    }
</style>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1><i class="bi bi-folder2-open me-2"></i>Lista de Categorias</h1>
        <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#modalNovaCategoria">
            <i class="bi bi-plus-circle me-1"></i> Nova Categoria
        </button>
    </div>

    <hr class="section-divider">

    @if(session('success'))
        <div class="alert alert-success">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nome da Categoria</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categorias as $categoria)
                    <tr>
                        <td>{{ $categoria->codigo }}</td>
                        <td>{{ $categoria->nome }}</td>
                        <td>
                            <button 
                                class="btn btn-sm btn-warning btn-edit"
                                data-id="{{ $categoria->id }}"
                                data-codigo="{{ $categoria->codigo }}"
                                data-nome="{{ $categoria->nome }}"
                                title="Editar">
                                <i class="bi bi-pencil"></i>
                            </button>

                            <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Excluir"
                                    onclick="return confirm('Deseja realmente excluir esta categoria?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">
                            <i class="bi bi-inbox"></i> Nenhuma categoria cadastrada ainda.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- 🆕 Modal Nova Categoria -->
<div class="modal fade" id="modalNovaCategoria" tabindex="-1" aria-labelledby="modalNovaCategoriaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content fade-in">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-folder-plus me-2"></i>Nova Categoria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('categorias.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Código da Categoria</label>
                        <input type="text" name="codigo" class="form-control form-control-lg" value="{{ $proximoCodigo }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nome da Categoria <span class="text-danger">*</span></label>
                        <input type="text" name="nome" class="form-control form-control-lg" required maxlength="100" placeholder="Ex: Tecnologia, Esportes...">
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i>Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ✏️ Modal Editar Categoria -->
<div class="modal fade" id="modalEditarCategoria" tabindex="-1" aria-labelledby="modalEditarCategoriaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content fade-in">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Editar Categoria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarCategoria" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Código da Categoria</label>
                        <input type="text" id="editCodigo" name="codigo" class="form-control form-control-lg" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nome da Categoria <span class="text-danger">*</span></label>
                        <input type="text" id="editNome" name="nome" class="form-control form-control-lg" required maxlength="100">
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-1"></i>Atualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ✅ Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- 🧠 Script para abrir modal de edição com dados -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modalEditar = new bootstrap.Modal(document.getElementById('modalEditarCategoria'));
    const formEditar = document.getElementById('formEditarCategoria');
    const inputCodigo = document.getElementById('editCodigo');
    const inputNome = document.getElementById('editNome');

    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.getAttribute('data-id');
            const codigo = button.getAttribute('data-codigo');
            const nome = button.getAttribute('data-nome');

            inputCodigo.value = codigo;
            inputNome.value = nome;

            formEditar.action = `/categorias/${id}`;
            modalEditar.show();
        });
    });
});
</script>
@endsection
