-- ============================================
-- SISTEMA DE COLETA DE DADOS CONSULARES
-- Script de criação do banco de dados MySQL
-- ============================================

-- Criar o banco de dados
CREATE DATABASE IF NOT EXISTS dados_consulares 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

-- Usar o banco de dados
USE dados_consulares;

-- ============================================
-- TABELA PRINCIPAL: processos_consulares
-- ============================================

CREATE TABLE processos_consulares (
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
    tipo_investimento ENUM('Carta Convite', 'Próprio Investimento') DEFAULT NULL,
    data_finalizou DATE,
    local ENUM('RJ', 'SP', 'BH', 'BSB', 'Outro') DEFAULT NULL,
    tempo_vfs INT DEFAULT NULL COMMENT 'Tempo em dias entre envio e consulado',
    tempo_consulado INT DEFAULT NULL COMMENT 'Tempo em dias no consulado',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Índices para melhor performance
    INDEX idx_nome (nome),
    INDEX idx_local (local),
    INDEX idx_tipo (tipo_investimento),
    INDEX idx_data_envio (data_envio_doc),
    INDEX idx_data_finalizou (data_finalizou)
);

-- ============================================
-- TABELA DE AUDITORIA (opcional)
-- ============================================

CREATE TABLE auditoria_processos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    processo_id INT,
    acao ENUM('INSERT', 'UPDATE', 'DELETE'),
    dados_anteriores JSON,
    dados_novos JSON,
    usuario VARCHAR(100) DEFAULT 'sistema',
    data_acao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (processo_id) REFERENCES processos_consulares(id) ON DELETE SET NULL
);

-- ============================================
-- TRIGGERS PARA CÁLCULO AUTOMÁTICO DE TEMPOS
-- ============================================

DELIMITER //

-- Trigger para calcular tempos automaticamente no INSERT
CREATE TRIGGER calculate_times_insert 
BEFORE INSERT ON processos_consulares
FOR EACH ROW
BEGIN
    -- Calcular tempo VFS (entre envio de doc e email do consulado)
    IF NEW.data_envio_doc IS NOT NULL AND NEW.email_consulado IS NOT NULL THEN
        SET NEW.tempo_vfs = DATEDIFF(NEW.email_consulado, NEW.data_envio_doc);
    END IF;
    
    -- Calcular tempo consulado (entre email consulado e finalização)
    IF NEW.email_consulado IS NOT NULL AND NEW.data_finalizou IS NOT NULL THEN
        SET NEW.tempo_consulado = DATEDIFF(NEW.data_finalizou, NEW.email_consulado);
    END IF;
END//

-- Trigger para calcular tempos automaticamente no UPDATE
CREATE TRIGGER calculate_times_update 
BEFORE UPDATE ON processos_consulares
FOR EACH ROW
BEGIN
    -- Calcular tempo VFS
    IF NEW.data_envio_doc IS NOT NULL AND NEW.email_consulado IS NOT NULL THEN
        SET NEW.tempo_vfs = DATEDIFF(NEW.email_consulado, NEW.data_envio_doc);
    ELSE
        SET NEW.tempo_vfs = NULL;
    END IF;
    
    -- Calcular tempo consulado
    IF NEW.email_consulado IS NOT NULL AND NEW.data_finalizou IS NOT NULL THEN
        SET NEW.tempo_consulado = DATEDIFF(NEW.data_finalizou, NEW.email_consulado);
    ELSE
        SET NEW.tempo_consulado = NULL;
    END IF;
END//

-- Trigger de auditoria para INSERT
CREATE TRIGGER audit_insert
AFTER INSERT ON processos_consulares
FOR EACH ROW
BEGIN
    INSERT INTO auditoria_processos (processo_id, acao, dados_novos)
    VALUES (NEW.id, 'INSERT', JSON_OBJECT(
        'nome', NEW.nome,
        'data_envio_doc', NEW.data_envio_doc,
        'local', NEW.local,
        'tipo_investimento', NEW.tipo_investimento
    ));
END//

-- Trigger de auditoria para UPDATE
CREATE TRIGGER audit_update
AFTER UPDATE ON processos_consulares
FOR EACH ROW
BEGIN
    INSERT INTO auditoria_processos (processo_id, acao, dados_anteriores, dados_novos)
    VALUES (OLD.id, 'UPDATE', 
        JSON_OBJECT(
            'nome', OLD.nome,
            'data_envio_doc', OLD.data_envio_doc,
            'local', OLD.local,
            'tipo_investimento', OLD.tipo_investimento
        ),
        JSON_OBJECT(
            'nome', NEW.nome,
            'data_envio_doc', NEW.data_envio_doc,
            'local', NEW.local,
            'tipo_investimento', NEW.tipo_investimento
        )
    );
END//

DELIMITER ;

-- ============================================
-- VIEWS PARA RELATÓRIOS
-- ============================================

-- View com dados formatados para relatórios
CREATE VIEW vw_processos_relatorio AS
SELECT 
    id,
    nome,
    DATE_FORMAT(data_envio_doc, '%d/%m/%Y') as data_envio_formatada,
    DATE_FORMAT(data_recebimento_vfs, '%d/%m/%Y') as data_recebimento_formatada,
    DATE_FORMAT(vfs_informa_email, '%d/%m/%Y') as vfs_email_formatada,
    DATE_FORMAT(vfs_informa_pendencia, '%d/%m/%Y') as vfs_pendencia_formatada,
    DATE_FORMAT(vfs_criou_ref, '%d/%m/%Y') as vfs_ref_formatada,
    DATE_FORMAT(email_consulado, '%d/%m/%Y') as email_consulado_formatada,
    DATE_FORMAT(consulado_pendencia, '%d/%m/%Y') as consulado_pendencia_formatada,
    DATE_FORMAT(consulado_devolver, '%d/%m/%Y') as consulado_devolver_formatada,
    tipo_investimento,
    DATE_FORMAT(data_finalizou, '%d/%m/%Y') as data_finalizou_formatada,
    local,
    COALESCE(tempo_vfs, 0) as tempo_vfs_dias,
    COALESCE(tempo_consulado, 0) as tempo_consulado_dias,
    CASE 
        WHEN data_finalizou IS NOT NULL THEN 'Finalizado'
        WHEN consulado_devolver IS NOT NULL THEN 'Aguardando Devolução'
        WHEN email_consulado IS NOT NULL THEN 'No Consulado'
        WHEN vfs_criou_ref IS NOT NULL THEN 'VFS Processado'
        ELSE 'Em Andamento'
    END as status_processo,
    DATE_FORMAT(created_at, '%d/%m/%Y %H:%i') as data_criacao
FROM processos_consulares
ORDER BY created_at DESC;

-- View para estatísticas
CREATE VIEW vw_estatisticas AS
SELECT 
    COUNT(*) as total_processos,
    COUNT(CASE WHEN data_finalizou IS NOT NULL THEN 1 END) as processos_finalizados,
    COUNT(CASE WHEN data_finalizou IS NULL THEN 1 END) as processos_andamento,
    AVG(CASE WHEN tempo_vfs > 0 THEN tempo_vfs END) as tempo_medio_vfs,
    AVG(CASE WHEN tempo_consulado > 0 THEN tempo_consulado END) as tempo_medio_consulado,
    MAX(tempo_vfs) as maior_tempo_vfs,
    MAX(tempo_consulado) as maior_tempo_consulado,
    MIN(tempo_vfs) as menor_tempo_vfs,
    MIN(tempo_consulado) as menor_tempo_consulado
FROM processos_consulares;

-- View por local
CREATE VIEW vw_estatisticas_local AS
SELECT 
    local,
    COUNT(*) as total_processos,
    COUNT(CASE WHEN data_finalizou IS NOT NULL THEN 1 END) as finalizados,
    AVG(CASE WHEN tempo_vfs > 0 THEN tempo_vfs END) as tempo_medio_vfs,
    AVG(CASE WHEN tempo_consulado > 0 THEN tempo_consulado END) as tempo_medio_consulado
FROM processos_consulares
WHERE local IS NOT NULL
GROUP BY local
ORDER BY total_processos DESC;

-- ============================================
-- DADOS DE EXEMPLO
-- ============================================

INSERT INTO processos_consulares (
    nome, 
    data_envio_doc, 
    data_recebimento_vfs, 
    vfs_informa_email, 
    vfs_informa_pendencia, 
    vfs_criou_ref, 
    tipo_investimento, 
    local
) VALUES (
    'Danilo Soares',
    '2025-04-10',
    '2025-04-11',
    '2025-04-17',
    '2025-05-13',
    '2025-05-22',
    'Próprio Investimento',
    'RJ'
);

-- Exemplo adicional
INSERT INTO processos_consulares (
    nome, 
    data_envio_doc, 
    data_recebimento_vfs, 
    vfs_informa_email, 
    email_consulado,
    data_finalizou,
    tipo_investimento, 
    local
) VALUES (
    'Maria Silva',
    '2025-03-15',
    '2025-03-16',
    '2025-03-20',
    '2025-04-10',
    '2025-05-15',
    'Carta Convite',
    'SP'
);

-- ============================================
-- PROCEDURES ÚTEIS
-- ============================================

DELIMITER //

-- Procedure para buscar processos por período
CREATE PROCEDURE sp_processos_periodo(
    IN data_inicio DATE,
    IN data_fim DATE
)
BEGIN
    SELECT * FROM vw_processos_relatorio
    WHERE STR_TO_DATE(data_envio_formatada, '%d/%m/%Y') BETWEEN data_inicio AND data_fim
    ORDER BY STR_TO_DATE(data_envio_formatada, '%d/%m/%Y') DESC;
END//

-- Procedure para relatório de performance
CREATE PROCEDURE sp_relatorio_performance()
BEGIN
    SELECT 
        'Estatísticas Gerais' as secao,
        CONCAT('Total de Processos: ', total_processos) as informacao
    FROM vw_estatisticas
    
    UNION ALL
    
    SELECT 
        'Estatísticas Gerais',
        CONCAT('Processos Finalizados: ', processos_finalizados)
    FROM vw_estatisticas
    
    UNION ALL
    
    SELECT 
        'Tempos Médios',
        CONCAT('Tempo Médio VFS: ', ROUND(tempo_medio_vfs, 1), ' dias')
    FROM vw_estatisticas
    WHERE tempo_medio_vfs IS NOT NULL
    
    UNION ALL
    
    SELECT 
        'Tempos Médios',
        CONCAT('Tempo Médio Consulado: ', ROUND(tempo_medio_consulado, 1), ' dias')
    FROM vw_estatisticas
    WHERE tempo_medio_consulado IS NOT NULL;
END//

DELIMITER ;

-- ============================================
-- COMANDOS ÚTEIS PARA TESTES
-- ============================================

-- Verificar estrutura da tabela
-- DESCRIBE processos_consulares;

-- Ver todos os processos
-- SELECT * FROM vw_processos_relatorio;

-- Ver estatísticas
-- SELECT * FROM vw_estatisticas;

-- Ver estatísticas por local
-- SELECT * FROM vw_estatisticas_local;

-- Executar relatório de performance
-- CALL sp_relatorio_performance();

-- Buscar processos de um período
-- CALL sp_processos_periodo('2025-03-01', '2025-05-31');

-- ============================================
-- USUÁRIO PARA APLICAÇÃO (OPCIONAL)
-- ============================================

-- Criar usuário específico para a aplicação
-- CREATE USER 'consulares_app'@'localhost' IDENTIFIED BY 'senha_segura_123';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON dados_consulares.processos_consulares TO 'consulares_app'@'localhost';
-- GRANT SELECT ON dados_consulares.vw_* TO 'consulares_app'@'localhost';
-- FLUSH PRIVILEGES;

-- ============================================
-- FIM DO SCRIPT
-- ============================================

SELECT 'Banco de dados criado com sucesso!' as status;