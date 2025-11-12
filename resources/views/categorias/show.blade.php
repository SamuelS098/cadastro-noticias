<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Detalhes da Categoria | Painel de Administração</title>

    <!-- Bootstrap e Ícones -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

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

        .icon-header {
            font-size: 3rem;
            color: #4a68ff;
            background: #e9edff;
            padding: 15px;
            border-radius: 50%;
        }

        .btn-primary {
            background: #4a68ff;
            border: none;
            font-weight: 500;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .btn-primary:hover {
            background: #3d58e0;
            transform: translateY(-1px);
        }

        .btn-outline-danger {
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .btn-outline-danger:hover {
            background: #f8d7da;
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="container fade-in">
        <div class="col-md-8 col-lg-5 mx-auto">
            <div class="card text-center">
                <div class="mb-4">
                    <i class="bi bi-folder icon-header"></i>
                    <h2 class="titulo mt-3">Detalhes da Categoria</h2>
                    <p class="text-muted">Veja as informações completas da categoria selecionada</p>
                </div>

                <div class="mb-3 text-start">
                    <h5><i class="bi bi-tag"></i> Nome:</h5>
                    <p class="fs-5">{{ $categoria->nome }}</p>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('categorias.index') }}" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-arrow-left"></i> Voltar
                    </a>
                    <a href="{{ route('categorias.edit', $categoria->id) }}" class="btn btn-primary px-4">
                        <i class="bi bi-pencil-square"></i> Editar
                    </a>
                    <form action="{{ route('categorias.destroy', $categoria->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta categoria?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger px-4">
                            <i class="bi bi-trash"></i> Excluir
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
