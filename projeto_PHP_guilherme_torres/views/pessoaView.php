<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pessoas</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .json-view {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            background-color: #f8f9fa;
            margin: 20px auto;
            width: 100%;
            max-height: 300px;
            overflow-y: auto;
        }

        .table {
            margin-top: 20px;
        }

        .form-control,
        .btn {
            margin: 5px 0;
        }

        .list-unstyled {
            padding-left: 0;
        }

        .row {
            flex-wrap: unset;
        }

        .col-md-5 {
            max-width: 30%;
        }
    </style>
</head>

<body>
    <!-- Aviso filho repetido -->
    <?php
    session_start();
    if (isset($_SESSION['alert'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['alert']) ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php unset($_SESSION['alert']); ?>
    <?php endif; ?>

    <div class="mx-3 mt-5">
        <div class="row">
            <!-- Formulário para Cadastrar Novo Pai -->
            <div class="col-md-5">
                <fieldset class="border p-3">
                    <legend class="w-auto">Cadastrar Novo Pai</legend>
                    <form method="post" action="/index.php?pessoa=create">
                        <div class="form-group">
                            <label for="nome">Nome:</label>
                            <input id="nome" name="nome" type="text" required class="form-control" />
                        </div>
                        <button type="submit" class="btn btn-success" onclick="showJsonPreview({ id: '', nome: document.getElementById('nome').value })">Incluir</button>
                    </form>
                </fieldset>
            </div>

            <!-- Tabela de Pais -->
            <div class="col-md-5">
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nome do Pai</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($model->rows as $item): ?>
                            <tr>
                                <td id="<?= $item->id ?>">
                                    <?= htmlspecialchars($item->nome) ?>
                                    <form method="post" action="/index.php?pessoa=createChild" style="display:inline;" onsubmit="return showJsonPreview(event, <?= json_encode(['id_pai' => $item->id]) ?>)">
                                        <input type="hidden" name="id_pai" value="<?= $item->id ?>">
                                        <input type="text" id="nome_filho_<?= $item->id ?>" name="nome_filho" placeholder="Nome do Filho" required class="form-control d-inline-block" style="width: auto; margin-left: 10px;" />
                                        <button type="submit" class="btn btn-primary btn-sm">Adicionar</button>
                                    </form>
                                </td>
                                <td>
                                    <form method="post" action="/index.php?pessoa=deleteAll">
                                        <input type="hidden" name="id" value="<?= $item->id ?>">
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir Pai</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Tabela de Filhos -->
            <div class="col-md-5">
                <h3 class="text-center mt-5">Filhos</h3>
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nome do Filho</th>
                            <th>ID do Pai</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($model->children) && is_array($model->children)): ?>
                            <?php foreach ($model->children as $child): ?>
                                <tr>
                                    <td><?= htmlspecialchars($child->nome_filho) ?></td>
                                    <td><?= htmlspecialchars($child->id_pai) ?></td>
                                    <td>
                                        <form method="post" action="/index.php?pessoa=deleteChild" style="display:inline;">
                                            <input type="hidden" name="id_pai" value="<?= $child->id_pai ?>">
                                            <input type="hidden" name="nome_filho" value="<?= htmlspecialchars($child->nome_filho) ?>">
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este filho?');">Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center">Não há filhos cadastrados.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Visualização Json -->
    <div class="row">
        <div class="col-md-12">
            <h3 class="text-center">Visualização JSON</h3>
            <textarea class="json-view" id="jsonPreview" rows="10" readonly></textarea>
        </div>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        const pessoas = <?= json_encode(['pessoas' => $model->rows]) ?>;

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('jsonPreview').value = JSON.stringify(pessoas, null, 2);
        });
    </script>
</body>

</html>