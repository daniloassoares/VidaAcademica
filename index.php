<?php
// config.php - Configuração do banco de dados
class Database {
    private $host = 'localhost';
    private $db_name = 'dados_consulares';
    private $username = 'root'; // Altere conforme necessário
    private $password = ''; // Altere conforme necessário
    private $conn;
    
    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4",
                $this->username,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch(PDOException $exception) {
            echo "Erro de conexão: " . $exception->getMessage();
        }
        return $this->conn;
    }
}

// ProcessoConsular.php - Classe para gerenciar os dados
class ProcessoConsular {
    private $conn;
    private $table_name = "processos_consulares";
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function criar($dados) {
        $query = "INSERT INTO " . $this->table_name . " 
                  (nome, data_envio_doc, data_recebimento_vfs, vfs_informa_email, 
                   vfs_informa_pendencia, vfs_criou_ref, email_consulado, 
                   consulado_pendencia, consulado_devolver, tipo_investimento, 
                   data_finalizou, local) 
                  VALUES (:nome, :data_envio_doc, :data_recebimento_vfs, :vfs_informa_email,
                          :vfs_informa_pendencia, :vfs_criou_ref, :email_consulado,
                          :consulado_pendencia, :consulado_devolver, :tipo_investimento,
                          :data_finalizou, :local)";
        
        $stmt = $this->conn->prepare($query);
        
        foreach($dados as $key => $value) {
            $stmt->bindValue(':' . $key, empty($value) ? null : $value);
        }
        
        return $stmt->execute();
    }
    
    public function atualizar($id, $dados) {
        $query = "UPDATE " . $this->table_name . " 
                  SET nome = :nome, data_envio_doc = :data_envio_doc, 
                      data_recebimento_vfs = :data_recebimento_vfs, 
                      vfs_informa_email = :vfs_informa_email,
                      vfs_informa_pendencia = :vfs_informa_pendencia, 
                      vfs_criou_ref = :vfs_criou_ref, 
                      email_consulado = :email_consulado,
                      consulado_pendencia = :consulado_pendencia, 
                      consulado_devolver = :consulado_devolver, 
                      tipo_investimento = :tipo_investimento,
                      data_finalizou = :data_finalizou, local = :local 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        
        foreach($dados as $key => $value) {
            $stmt->bindValue(':' . $key, empty($value) ? null : $value);
        }
        
        return $stmt->execute();
    }
    
    public function excluir($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    public function buscarTodos() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function buscarPorId($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    public function obterEstatisticas() {
        $query = "SELECT * FROM vw_estatisticas";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    private function calcularDias($dataInicio, $dataFim) {
        if (empty($dataInicio) || empty($dataFim)) return null;
        $inicio = new DateTime($dataInicio);
        $fim = new DateTime($dataFim);
        return $inicio->diff($fim)->days;
    }
    
    private function formatarData($data) {
        if (empty($data)) return '-';
        return date('d/m/Y', strtotime($data));
    }
}

// Inicialização
$database = new Database();
$db = $database->getConnection();
$processo = new ProcessoConsular($db);

// Processamento de formulários
$mensagem = '';
$editando = false;
$dadosEdicao = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';
    
    switch($acao) {
        case 'criar':
            $dados = [
                'nome' => $_POST['nome'],
                'data_envio_doc' => $_POST['dataEnvioDoc'],
                'data_recebimento_vfs' => $_POST['dataRecebimentoVfs'],
                'vfs_informa_email' => $_POST['vfsInformaEmail'],
                'vfs_informa_pendencia' => $_POST['vfsInformaPendencia'],
                'vfs_criou_ref' => $_POST['vfsCriouRef'],
                'email_consulado' => $_POST['emailConsulado'],
                'consulado_pendencia' => $_POST['consuladoPendencia'],
                'consulado_devolver' => $_POST['consuladoDevolver'],
                'tipo_investimento' => $_POST['tipoInvestimento'],
                'data_finalizou' => $_POST['dataFinalizou'],
                'local' => $_POST['local']
            ];
            
            if ($processo->criar($dados)) {
                $mensagem = "Registro adicionado com sucesso!";
            } else {
                $mensagem = "Erro ao adicionar registro.";
            }
            break;
            
        case 'atualizar':
            $id = $_POST['id'];
            $dados = [
                'nome' => $_POST['nome'],
                'data_envio_doc' => $_POST['dataEnvioDoc'],
                'data_recebimento_vfs' => $_POST['dataRecebimentoVfs'],
                'vfs_informa_email' => $_POST['vfsInformaEmail'],
                'vfs_informa_pendencia' => $_POST['vfsInformaPendencia'],
                'vfs_criou_ref' => $_POST['vfsCriouRef'],
                'email_consulado' => $_POST['emailConsulado'],
                'consulado_pendencia' => $_POST['consuladoPendencia'],
                'consulado_devolver' => $_POST['consuladoDevolver'],
                'tipo_investimento' => $_POST['tipoInvestimento'],
                'data_finalizou' => $_POST['dataFinalizou'],
                'local' => $_POST['local']
            ];
            
            if ($processo->atualizar($id, $dados)) {
                $mensagem = "Registro atualizado com sucesso!";
            } else {
                $mensagem = "Erro ao atualizar registro.";
            }
            break;
            
        case 'excluir':
            $id = $_POST['id'];
            if ($processo->excluir($id)) {
                $mensagem = "Registro excluído com sucesso!";
            } else {
                $mensagem = "Erro ao excluir registro.";
            }
            break;
    }
    
    // Redirect para evitar resubmissão
    if (!empty($mensagem)) {
        header("Location: " . $_SERVER['PHP_SELF'] . "?msg=" . urlencode($mensagem));
        exit;
    }
}

// Verificar se está editando
if (isset($_GET['editar'])) {
    $editando = true;
    $dadosEdicao = $processo->buscarPorId($_GET['editar']);
}

// Obter dados para exibição
$registros = $processo->buscarTodos();
$estatisticas = $processo->obterEstatisticas();

// Funções auxiliares
function formatarData($data) {
    if (empty($data)) return '-';
    return date('d/m/Y', strtotime($data));
}

function calcularDias($dataInicio, $dataFim) {
    if (empty($dataInicio) || empty($dataFim)) return '-';
    $inicio = new DateTime($dataInicio);
    $fim = new DateTime($dataFim);
    return $inicio->diff($fim)->days . ' dias';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Coleta de Dados Consulares</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .content {
            padding: 40px;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 10px;
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .alert.error {
            background: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }

        .form-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(102, 126, 234, 0.1);
        }

        .form-section h2 {
            color: #667eea;
            margin-bottom: 25px;
            font-size: 1.8rem;
            font-weight: 600;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .form-group {
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
            font-size: 0.95rem;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 15px;
            border: 2px solid #e1e5e9;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
        }

        .form-group input:focus, .form-group select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-left: 10px;
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-1px);
        }

        .table-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(102, 126, 234, 0.1);
        }

        .table-section h2 {
            color: #667eea;
            margin-bottom: 25px;
            font-size: 1.8rem;
            font-weight: 600;
        }

        .table-container {
            overflow-x: auto;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            min-width: 1200px;
        }

        th, td {
            padding: 15px 12px;
            text-align: left;
            border-bottom: 1px solid #e1e5e9;
            font-size: 0.9rem;
        }

        th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: 600;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        tr:nth-child(even) {
            background: rgba(102, 126, 234, 0.05);
        }

        tr:hover {
            background: rgba(102, 126, 234, 0.1);
            transform: scale(1.01);
            transition: all 0.2s ease;
        }

        .edit-btn {
            background: #28a745;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.8rem;
            transition: all 0.3s ease;
            margin-right: 5px;
            text-decoration: none;
            display: inline-block;
        }

        .edit-btn:hover {
            background: #218838;
            transform: scale(1.05);
        }

        .delete-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.8rem;
            transition: all 0.3s ease;
        }

        .delete-btn:hover {
            background: #c82333;
            transform: scale(1.05);
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(102, 126, 234, 0.1);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 10px;
        }

        .stat-label {
            color: #6c757d;
            font-size: 1rem;
            font-weight: 500;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.3;
        }

        @media (max-width: 768px) {
            .content {
                padding: 20px;
            }
            
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .header h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📋 Sistema de Coleta de Dados Consulares</h1>
            <p>Gerencie processos consulares de forma eficiente e organizada</p>
        </div>

        <div class="content">
            <?php if (isset($_GET['msg'])): ?>
                <div class="alert">
                    <?php echo htmlspecialchars($_GET['msg']); ?>
                </div>
            <?php endif; ?>

            <!-- Estatísticas -->
            <div class="stats">
                <div class="stat-card">
                    <div class="stat-number"><?php echo $estatisticas['total_processos'] ?? 0; ?></div>
                    <div class="stat-label">Total de Registros</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo round($estatisticas['tempo_medio_vfs'] ?? 0); ?></div>
                    <div class="stat-label">Tempo Médio VFS (dias)</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo round($estatisticas['tempo_medio_consulado'] ?? 0); ?></div>
                    <div class="stat-label">Tempo Médio Consulado (dias)</div>
                </div>
            </div>

            <!-- Formulário -->
            <div class="form-section">
                <h2>📝 <?php echo $editando ? 'Editar Registro' : 'Adicionar Novo Registro'; ?></h2>
                <form method="POST">
                    <input type="hidden" name="acao" value="<?php echo $editando ? 'atualizar' : 'criar'; ?>">
                    <?php if ($editando): ?>
                        <input type="hidden" name="id" value="<?php echo $dadosEdicao['id']; ?>">
                    <?php endif; ?>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="nome">Nome Completo</label>
                            <input type="text" id="nome" name="nome" required 
                                   value="<?php echo $editando ? htmlspecialchars($dadosEdicao['nome']) : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="dataEnvioDoc">Data Envio Documentos</label>
                            <input type="date" id="dataEnvioDoc" name="dataEnvioDoc" required
                                   value="<?php echo $editando ? $dadosEdicao['data_envio_doc'] : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="dataRecebimentoVfs">Data Recebimento VFS</label>
                            <input type="date" id="dataRecebimentoVfs" name="dataRecebimentoVfs"
                                   value="<?php echo $editando ? $dadosEdicao['data_recebimento_vfs'] : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="vfsInformaEmail">VFS Informa Email Recebimento</label>
                            <input type="date" id="vfsInformaEmail" name="vfsInformaEmail"
                                   value="<?php echo $editando ? $dadosEdicao['vfs_informa_email'] : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="vfsInformaPendencia">VFS Informa Não Possuir Pendência</label>
                            <input type="date" id="vfsInformaPendencia" name="vfsInformaPendencia"
                                   value="<?php echo $editando ? $dadosEdicao['vfs_informa_pendencia'] : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="vfsCriouRef">VFS Criou Número de Referência</label>
                            <input type="date" id="vfsCriouRef" name="vfsCriouRef"
                                   value="<?php echo $editando ? $dadosEdicao['vfs_criou_ref'] : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="emailConsulado">Email Informa Recebimento Consulado</label>
                            <input type="date" id="emailConsulado" name="emailConsulado"
                                   value="<?php echo $editando ? $dadosEdicao['email_consulado'] : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="consuladoPendencia">Consulado Informa Ter Pendência</label>
                            <input type="date" id="consuladoPendencia" name="consuladoPendencia"
                                   value="<?php echo $editando ? $dadosEdicao['consulado_pendencia'] : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="consuladoDevolver">Consulado Informa Devolver Passaporte</label>
                            <input type="date" id="consuladoDevolver" name="consuladoDevolver"
                                   value="<?php echo $editando ? $dadosEdicao['consulado_devolver'] : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="tipoInvestimento">Carta Convite ou Próprio Investimento</label>
                            <select id="tipoInvestimento" name="tipoInvestimento">
                                <option value="">Selecione...</option>
                                <option value="Carta Convite" <?php echo ($editando && $dadosEdicao['tipo_investimento'] == 'Carta Convite') ? 'selected' : ''; ?>>Carta Convite</option>
                                <option value="Próprio Investimento" <?php echo ($editando && $dadosEdicao['tipo_investimento'] == 'Próprio Investimento') ? 'selected' : ''; ?>>Próprio Investimento</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="dataFinalizou">Data Finalizou</label>
                            <input type="date" id="dataFinalizou" name="dataFinalizou"
                                   value="<?php echo $editando ? $dadosEdicao['data_finalizou'] : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="local">Local VFS</label>
                            <select id="local" name="local">
                                <option value="">Selecione...</option>
                                <option value="RJ" <?php echo ($editando && $dadosEdicao['local'] == 'RJ') ? 'selected' : ''; ?>>Rio de Janeiro (RJ)</option>
                                <option value="SP" <?php echo ($editando && $dadosEdicao['local'] == 'SP') ? 'selected' : ''; ?>>São Paulo (SP)</option>
                                <option value="BH" <?php echo ($editando && $dadosEdicao['local'] == 'BH') ? 'selected' : ''; ?>>Belo Horizonte (BH)</option>
                                <option value="BSB" <?php echo ($editando && $dadosEdicao['local'] == 'BSB') ? 'selected' : ''; ?>>Brasília (BSB)</option>
                                <option value="Outro" <?php echo ($editando && $dadosEdicao['local'] == 'Outro') ? 'selected' : ''; ?>>Outro</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn-primary">
                        <?php echo $editando ? '💾 Salvar Alterações' : '➕ Adicionar Registro'; ?>
                    </button>
                    <?php if ($editando): ?>
                        <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="btn-secondary">❌ Cancelar</a>
                    <?php endif; ?>
                    <button type="reset" class="btn-secondary">🗑️ Limpar</button>
                </form>
            </div>

            <!-- Tabela de Dados -->
            <div class="table-section">
                <h2>📊 Registros Salvos</h2>
                <?php if (empty($registros)): ?>
                    <div class="empty-state">
                        <div style="font-size: 4rem; margin-bottom: 20px; opacity: 0.3;">📄</div>
                        <h3>Nenhum registro encontrado</h3>
                        <p>Adicione seu primeiro registro usando o formulário acima.</p>
                    </div>
                <?php else: ?>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Data Envio Doc.</th>
                                    <th>Data Receb. VFS</th>
                                    <th>VFS Email</th>
                                    <th>VFS Sem Pendência</th>
                                    <th>VFS Núm. Ref.</th>
                                    <th>Email Consulado</th>
                                    <th>Consulado Pendência</th>
                                    <th>Consulado Devolver</th>
                                    <th>Tipo</th>
                                    <th>Data Finalizou</th>
                                    <th>Tempo VFS</th>
                                    <th>Tempo Consulado</th>
                                    <th>Local</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($registros as $registro): ?>
                                    <tr>
                                        <td><strong><?php echo htmlspecialchars($registro['nome']); ?></strong></td>
                                        <td><?php echo formatarData($registro['data_envio_doc']); ?></td>
                                        <td><?php echo formatarData($registro['data_recebimento_vfs']); ?></td>
                                        <td><?php echo formatarData($registro['vfs_informa_email']); ?></td>
                                        <td><?php echo formatarData($registro['vfs_informa_pendencia']); ?></td>
                                        <td><?php echo formatarData($registro['vfs_criou_ref']); ?></td>
                                        <td><?php echo formatarData($registro['email_consulado']); ?></td>
                                        <td><?php echo formatarData($registro['consulado_pendencia']); ?></td>
                                        <td><?php echo formatarData($registro['consulado_devolver']); ?></td>
                                        <td><?php echo $registro['tipo_investimento'] ?: '-'; ?></td>
                                        <td><?php echo formatarData($registro['data_finalizou']); ?></td>
                                        <td><?php echo $registro['tempo_vfs'] ? $registro['tempo_vfs'] . ' dias' : '-'; ?></td>
                                        <td><?php echo $registro['tempo_consulado'] ? $registro['tempo_consulado'] . ' dias' : '-'; ?></td>
                                        <td>
                                            <?php if ($registro['local']): ?>
                                                <span style="background: #667eea; color: white; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">
                                                    
                                            <?php echo $registro['local']; ?>
                                                </span>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo $_SERVER['PHP_SELF']; ?>?editar=<?php echo $registro['id']; ?>" class="edit-btn">✏️ Editar</a>
                                            <form method="POST" style="display: inline;" onsubmit="return confirm('Tem certeza que deseja excluir este registro?');">
                                                <input type="hidden" name="acao" value="excluir">
                                                <input type="hidden" name="id" value="<?php echo $registro['id']; ?>">
                                                <button type="submit" class="delete-btn">🗑️ Excluir</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        // Adicionar funcionalidades JavaScript
        document.addEventListener('DOMContentLoaded', function() {
            // Animação suave para os cards de estatística
            const statCards = document.querySelectorAll('.stat-card');
            statCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });

            // Melhorar a experiência do usuário com validação
            const form = document.querySelector('form');
            const requiredFields = form.querySelectorAll('input[required]');
            
            requiredFields.forEach(field => {
                field.addEventListener('blur', function() {
                    if (this.value.trim() === '') {
                        this.style.borderColor = '#dc3545';
                        this.style.boxShadow = '0 0 0 3px rgba(220, 53, 69, 0.1)';
                    } else {
                        this.style.borderColor = '#28a745';
                        this.style.boxShadow = '0 0 0 3px rgba(40, 167, 69, 0.1)';
                    }
                });
            });

            // Adicionar feedback visual para botões
            const buttons = document.querySelectorAll('button, .edit-btn');
            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                });
            });

            // Auto-save para localStorage (opcional - comentado pois pode não ser necessário)
            /*
            const formInputs = document.querySelectorAll('input, select');
            formInputs.forEach(input => {
                input.addEventListener('change', function() {
                    localStorage.setItem('form_' + this.name, this.value);
                });
                
                // Restaurar valores salvos
                const savedValue = localStorage.getItem('form_' + input.name);
                if (savedValue && !input.value) {
                    input.value = savedValue;
                }
            });
            */

            // Melhorar a responsividade da tabela
            const table = document.querySelector('table');
            if (table && window.innerWidth < 768) {
                table.style.fontSize = '0.8rem';
            }

            // Adicionar indicador de loading para formulários
            const submitBtn = document.querySelector('button[type="submit"]');
            if (submitBtn) {
                form.addEventListener('submit', function() {
                    submitBtn.innerHTML = '⏳ Processando...';
                    submitBtn.disabled = true;
                });
            }
        });

        // Função para confirmar exclusão com mais detalhes
        function confirmarExclusao(nome) {
            return confirm(`Tem certeza que deseja excluir o registro de ${nome}?\n\nEsta ação não pode ser desfeita.`);
        }

        // Função para exportar dados (placeholder para futura implementação)
        function exportarDados() {
            alert('Funcionalidade de exportação será implementada em breve!');
        }

        // Adicionar funcionalidade de busca/filtro (placeholder)
        function filtrarTabela() {
            // Implementar filtro de busca na tabela
            console.log('Filtro será implementado');
        }
    </script>
</body>
</html>

<?php
// SQL para criar as tabelas necessárias (comentado - executar apenas uma vez)
/*
CREATE DATABASE IF NOT EXISTS dados_consulares CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE dados_consulares;

CREATE TABLE IF NOT EXISTS processos_consulares (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    data_envio_doc DATE,
    data_recebimento_vfs DATE,
    vfs_informa_email DATE,
    vfs_informa_pendencia DATE,
    vfs_criou_ref DATE,
    email_consulado DATE,
    consulado_pendencia DATE,
    consulado_devolver DATE,
    tipo_investimento ENUM('Carta Convite', 'Próprio Investimento'),
    data_finalizou DATE,
    local ENUM('RJ', 'SP', 'BH', 'BSB', 'Outro'),
    tempo_vfs INT GENERATED ALWAYS AS (
        CASE 
            WHEN data_envio_doc IS NOT NULL AND data_recebimento_vfs IS NOT NULL 
            THEN DATEDIFF(data_recebimento_vfs, data_envio_doc)
            ELSE NULL 
        END
    ) STORED,
    tempo_consulado INT GENERATED ALWAYS AS (
        CASE 
            WHEN data_recebimento_vfs IS NOT NULL AND data_finalizou IS NOT NULL 
            THEN DATEDIFF(data_finalizou, data_recebimento_vfs)
            ELSE NULL 
        END
    ) STORED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- View para estatísticas
CREATE OR REPLACE VIEW vw_estatisticas AS
SELECT 
    COUNT(*) as total_processos,
    AVG(tempo_vfs) as tempo_medio_vfs,
    AVG(tempo_consulado) as tempo_medio_consulado,
    COUNT(CASE WHEN data_finalizou IS NOT NULL THEN 1 END) as processos_finalizados,
    COUNT(CASE WHEN tipo_investimento = 'Carta Convite' THEN 1 END) as carta_convite,
    COUNT(CASE WHEN tipo_investimento = 'Próprio Investimento' THEN 1 END) as proprio_investimento
FROM processos_consulares;
*/
?>