<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Editar Categoria | Painel de Administração</title>

    <!-- Bootstrap e Ícones -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Estilos customizados -->
    <style>
        body {
            background: linear-gradient(135deg, #eef3ff, #e3eafc);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: "Inter", system-ui, sans-serif;
        }

        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            background: #fff;
            transition: all 0.3s ease-in-out;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(0, 0, 0, 0.1);
        }

        .titulo {
            font-weight: 700;
            color: #233876;
        }

        .subtitulo {
            color: #6c757d;
            font-size: 0.95rem;
        }

        .icon-header {
            font-size: 3rem;
            color: #f0ad4e;
            background: #fff3cd;
            padding: 15px;
            border-radius: 50%;
        }

        .btn-primary {
            background: #4a68ff;
            border: none;
            font-weight: 500;
            transition: background 0.3s ease, transform 0.2s ease;
            border-radius: 10px;
        }

        .btn-primary:hover {
            background: #3d58e0;
            transform: translateY(-1px);
        }

        .btn-outline-secondary {
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .btn-outline-secondary:hover {
            background: #f0f2f8;
        }

        .form-label {
            font-weight: 600;
        }

        .form-control {
            border: 1px solid #ced4da;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        /* Foco com destaque azul */
        .form-control:focus {
            border-color: #4a68ff;
            box-shadow: 0 0 0 1px rgba(74, 104, 255, 0.35);
            outline: none;
        }

        .alert-danger {
            border-radius: 10px;
            font-size: 0.9rem;
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .btn i {
            margin-right: 6px;
        }
    </style>
</head>

<body>
    <div class="container fade-in">
        <div class="col-md-8 col-lg-5 mx-auto">
            <div class="card">
                <div class="text-center mb-4">
                    <i class="bi bi-pencil-square icon-header"></i>
                    <h2 class="titulo mt-3">Editar Categoria</h2>
                    <p class="subtitulo">Atualize as informações da categoria selecionada</p>
                </div>

                {{-- Exibição de erros de validação --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong><i class="bi bi-exclamation-triangle"></i> Atenção:</strong>
                        <ul class="mt-2 mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Formulário de edição --}}
                <form action="{{ route('categorias.update', $categoria->id) }}" method="POST" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome da Categoria</label>
                        <input
                            type="text"
                            id="nome"
                            name="nome"
                            class="form-control form-control-lg"
                            value="{{ old('nome', $categoria->nome) }}"
                            required
                            maxlength="100"
                            placeholder="Ex: Tecnologia, Esportes, Finanças"
                        >
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('categorias.index') }}" class="btn btn-outline-secondary px-4">
                            <i class="bi bi-arrow-left"></i> Voltar
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save"></i> Atualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
