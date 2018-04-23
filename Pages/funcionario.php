<?php

$cc = new \Controllers\ClienteController();
$ec = new \Controllers\EnderecoController();

    if(isset($_GET) && isset($_GET['a']) && $_GET['a'] == 'd'){
        if(isset($_GET['id'])){
            $cc->deletarCliente($_GET['id']);
        }
    }

?>
<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-12">
            <table class="table table-hover">
                <thead class="thead-dark">
                    <th scope="col">ID</th>
                    <th scope="col">CPF</th>
                    <th scope="col">RG</th>
                    <th scope="col">NOME</th>
                    <th scope="col">SEXO</th>
                    <th scope="col">DATA NASCIMENTO</th>
                    <th scope="col">NÚMERO CELULAR</th>
                    <th scope="col">NUMERO FIXO</th>
                    <th scope="col">CRIADO EM</th>
                    <th scope="col">ESTADO</th>
                    <th scope="col">Endereço</th>
                    <th scope="col">Ações</th>
                </thead>
                <tbody>
                <?php foreach ($cc->findAll() as $key => $value) : ?>
                    <tr>
                        <td><?= $value->id ?></td>
                        <td><?= $value->cpf ?></td>
                        <td><?= $value->rg ?></td>
                        <td><?= $value->nome ?></td>
                        <td><?= $value->sexo ?></td>
                        <td><?php
                            $data = new \DateTime($value->dtnascimento);
                            echo $data->format('d-m-Y');
                            ?></td>
                        <td><?= $value->numcelular ?></td>
                        <td><?= $value->numfixo ?></td>
                        <td><?php
                            $data = new \DateTime($value->criadoem );
                            echo $data->format('d-m-Y H:i:s');

                            ?></td>
                        <td>
                            <?= $r = ($value->estado) ? "Ativo" : "Desativado"; ?>
                        </td>
                        <td><a title="Clique para editar" href="endereco?a=e&id=<?= $value->endereco_idendereco ?>"><?= $ec->find($value->endereco_idendereco)->logradouro ?></a></td>
                        <td><a href="cliente?a=e&id=<?= $value->id ?>"><i style="font-size: 1.6em;" class="ion-edit mr-2"></i></a>
                        <a href="cliente?a=d&id=<?= $value->id ?>"><i style="font-size: 1.8em; color: red;" class="ion-trash-b"></i></a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="container">
    <!------------------------------------------------------------------------------------------------------------------------------
    --- Formulário de edição
    -------------------------------------------------------------------------------------------------------------------------------->
    <?php
        if(isset($_GET['a']) && $_GET['a'] == 'e'):
            $value = $cc->find($_GET['id']);
    ?>
        <div class="row mt-5">
            <div class="col-md-12">
                <form action="Pages/trataform/trataform.php" method="post">
                    <input type="number" name="id" value="<?= $_GET['id'] ?>" hidden>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nome">Nome</label>
                            <input type="text" name="nome" id="nome" class="form-control" value="<?= $value->nome ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="cpf">CPF</label>
                            <input type="text" name="cpf" id="cpf" class="form-control" value="<?= $value->cpf ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="rg">RG</label>
                            <input type="text" name="rg" id="rg" class="form-control" value="<?= $value->rg ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <div class="form-check form-check-inline">
                                <label for="">Sexo:</label>
                                <div class="form-check" id="sexoradio">
                                    <input type="radio" name="sexo" id="sexom" class="form-check-input" value="M" checked>
                                    <label for="sexom">M</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" name="sexo" id="sexof" class="form-check-input" value="F">
                                    <label for="sexof">F</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="dtnasc">Data Nascimento</label>
                            <input type="date" name="dtnasc" id="dtnasc" class="form-control" value="<?= $value->dtnascimento ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="numcel">Número Celular</label>
                            <input type="text" name="numcelular" id="numcel" class="form-control" value="<?= $value->numcelular ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="numfixo">Número Fixo</label>
                            <input type="text" name="numfixo" id="numfixo" class="form-control" value="<?= $value->numfixo ?>">
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="estado">Estado</label>
                            <select name="estado" id="estado" class="form-control">
                                <option value="1">Ativo</option>
                                <option value="0">Desativado</option>
                            </select>
                        </div>
                        <div class="form-group col-md-8">
                            <label for="endereco">Endereço</label>
                            <select name="endereco" id="endereco" class="form-control">
                                <?php foreach ($ec->findAll() as $endereco): ?>
                                    <option value="<?= $endereco->id ?>"><?= $endereco->logradouro ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <button type="submit" name="editarCliente" class="btn btn-primary"><span class="ion-person-add mr-2"></span>Atualizar</button>
                    <a href="/cliente" class="btn btn-danger"><span class="ion-android-cancel mr-2"></span>Cancelar</a>
                </form>
            </div>
        </div>
    <?php else: ?>

    <!------------------------------------------------------------------------------------------------------------------------------
    --- Formulário de cadastro
    -------------------------------------------------------------------------------------------------------------------------------->
        <div class="row mt-5">
            <div class="col-md-12">
                <form action="Pages/trataform/trataform.php" method="post">
                    <input type="number" name="id" value="<?= $_GET['id'] ?>" hidden>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nome">Nome</label>
                            <input type="text" name="nome" id="nome" class="form-control">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="cpf">CPF</label>
                            <input type="text" name="cpf" id="cpf" class="form-control">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="rg">RG</label>
                            <input type="text" name="rg" id="rg" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <div class="form-check form-check-inline">
                                <label for="">Sexo:</label>
                                <div class="form-check" id="sexoradio">
                                    <input type="radio" name="sexo" id="sexom" class="form-check-input" value="M" checked>
                                    <label for="sexom">M</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" name="sexo" id="sexof" class="form-check-input" value="F">
                                    <label for="sexof">F</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="dtnasc">Data Nascimento</label>
                            <input type="date" name="dtnasc" id="dtnasc" class="form-control">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="numcel">Número Celular</label>
                            <input type="text" name="numcelular" id="numcel" class="form-control">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="numfixo">Número Fixo</label>
                            <input type="text" name="numfixo" id="numfixo" class="form-control">
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="estado">Estado</label>
                            <select name="estado" id="estado" class="form-control">
                                <option value="1">Ativo</option>
                                <option value="0">Desativado</option>
                            </select>
                        </div>
                        <div class="form-group col-md-8">
                            <label for="endereco">Endereço</label>
                            <select name="endereco" id="endereco" class="form-control">
                                <?php foreach ($ec->findAll() as $endereco): ?>
                                    <option value="<?= $endereco->id ?>"><?= $endereco->logradouro ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <button type="submit" name="cadastrarCliente" class="btn btn-primary"><span class="ion-person-add mr-2"></span>Cadastrar</button>
                </form>
            </div>
        </div>
    <?php endif; ?>

</div>