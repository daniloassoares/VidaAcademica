<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danilo Soares | Analista de TI | Bacharel-Ciência da Computação (2020-2023), Pós-graduado Software. NOC, Datacenter&Cloud. Zabbix, Grafana, Dynatrace, Python, PHP.</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Header Moderno */
        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            margin-bottom: 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2, #f093fb);
            animation: gradient-shift 3s ease-in-out infinite;
        }

        @keyframes gradient-shift {
            0%, 100% { transform: translateX(-100%); }
            50% { transform: translateX(100%); }
        }

        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            color: white;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }

        .profile-img:hover {
            transform: scale(1.05) rotate(5deg);
        }

        .header h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .header p {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 20px;
        }

        .contact-quick {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: rgba(102, 126, 234, 0.1);
            border-radius: 20px;
            text-decoration: none;
            color: #667eea;
            transition: all 0.3s ease;
        }

        .contact-item:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }

        /* Grid Layout */
        .main-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
        }

        .card h2 {
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: #333;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card h2 i {
            color: #667eea;
        }

.privacy-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.privacy-overlay.active {
    opacity: 1;
    visibility: visible;
}

.privacy-modal {
    background: #2a2a2a;
    border-radius: 15px;
    padding: 35px;
    max-width: 450px;
    width: 90%;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    transform: translateY(30px);
    transition: transform 0.3s ease;
}

.privacy-overlay.active .privacy-modal {
    transform: translateY(0);
}

.privacy-modal h2 {
    color: #fff;
    font-size: 22px;
    margin-bottom: 15px;
    font-family: Arial, sans-serif;
}

.privacy-modal p {
    color: #ccc;
    line-height: 1.5;
    margin-bottom: 25px;
    font-family: Arial, sans-serif;
}

.privacy-btn {
    background: #000;
    color: #fff;
    border: none;
    padding: 12px 25px;
    border-radius: 25px;
    cursor: pointer;
    font-size: 14px;
    transition: background 0.3s ease;
}

.privacy-btn:hover {
    background: #333;
}

        /* Skills com Progress Bars */
        .skill-item {
            margin-bottom: 15px;
        }

        .skill-name {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .skill-bar {
            height: 8px;
            background: #e0e0e0;
            border-radius: 4px;
            overflow: hidden;
        }

        .skill-progress {
            height: 100%;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 4px;
            animation: fillBar 2s ease-out;
        }

        @keyframes fillBar {
            from { width: 0; }
        }

        /* Timeline para Experiência */
        .timeline {
            position: relative;
            padding-left: 20px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(180deg, #667eea, #764ba2);
        }

        .timeline-item {
            position: relative;
            margin-bottom: 30px;
            padding-left: 30px;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -25px;
            top: 5px;
            width: 12px;
            height: 12px;
            background: #667eea;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 0 0 3px #667eea;
        }

        .timeline-date {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 0.8rem;
            display: inline-block;
            margin-bottom: 8px;
        }

        .timeline-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .timeline-description {
            color: #666;
            font-size: 0.9rem;
        }

        /* Projetos em Destaque */
        .project-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .project-card {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
            border-radius: 15px;
            padding: 20px;
            transition: all 0.3s ease;
            border: 1px solid rgba(102, 126, 234, 0.2);
        }

        .project-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(102, 126, 234, 0.2);
        }

        .project-title {
            font-weight: 600;
            margin-bottom: 10px;
            color: #333;
        }

        .project-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .project-link:hover {
            color: #764ba2;
        }

        /* Seção Full Width */
        .full-width {
            grid-column: 1 / -1;
        }

        /* Certificações com Badges */
        .cert-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .cert-badge {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 15px;
            border-radius: 12px;
            text-align: center;
            font-weight: 500;
            transition: transform 0.3s ease;
        }

        .cert-badge:hover {
            transform: scale(1.05);
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 30px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            margin-top: 30px;
            color: #666;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .main-grid {
                grid-template-columns: 1fr;
            }
            
            .header h1 {
                font-size: 2rem;
            }
            
            .contact-quick {
                flex-direction: column;
                align-items: center;
            }
            
            .container {
                padding: 10px;
            }
        }

        /* Animações de entrada */
        .card {
            opacity: 0;
            transform: translateY(30px);
            animation: slideUp 0.6s ease forwards;
        }

        .card:nth-child(1) { animation-delay: 0.1s; }
        .card:nth-child(2) { animation-delay: 0.2s; }
        .card:nth-child(3) { animation-delay: 0.3s; }
        .card:nth-child(4) { animation-delay: 0.4s; }

        @keyframes slideUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Botão de Download CV */
        .download-btn {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            margin-top: 20px;
        }

        .download-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
    </style>
</head>
<body>
    
    <div class="privacy-overlay" id="privacyOverlay">
        <div class="privacy-modal">
            <h2>Política de privacidade</h2>
            <p>Utilizamos cookies e outras tecnologias semelhantes para melhorar a sua experiência no nosso site. Ao continuar navegando, você declara que está de acordo com a nossa política de privacidade. Válido para todos os sites da Hinshitsu Services.</p>
            <button class="privacy-btn" onclick="acceptPrivacy()">Li e aceito!</button>
        </div>
    </div>

    
    <div class="container">
        <!-- Header Principal -->
        <header class="header">
            <div class="profile-img">
                <i class="fas fa-user-tie"></i>
            </div>
            <h1>Danilo de Almeida Souza Soares</h1>
            <p>Analista de TI | Bacharel em Ciência da Computação (Licenciatura em Portugal) (2020-2023), Pós-graduado Qualidade de Software. NOC, Datacenter&Cloud, Zabbix, Grafana, Dynatrace, Python, PHP | Pós-Graduando em Engenharia de Software | Pós-Graduando no MBA Executivo em Gestão de Qualidade e Processos </p>
            
            <div class="contact-quick">
                <a href="tel:+5521974206850" class="contact-item">
                    <i class="fas fa-phone"></i>
                    (21) 97420-6850
                </a>
                <a href="mailto:daniloassoares@gmail.com" class="contact-item">
                    <i class="fas fa-envelope"></i>
                    daniloassoares@gmail.com
                </a>
                <a href="https://www.linkedin.com/in/danilo-de-a-s-soares-98596928" target="_blank" class="contact-item">
                    <i class="fab fa-linkedin"></i>
                    LinkedIn
                </a>
                <div class="contact-item">
                    <i class="fas fa-map-marker-alt"></i>
                    Bangu, Rio de Janeiro, RJ
                </div>
            </div>
            
            <a href="#" class="download-btn" onclick="alert('Funcionalidade de download será implementada! Acesse o meu LinkedIn, por favor!')">
                <i class="fas fa-download"></i>
                Download CV
            </a>
        </header>

        <!-- Grid Principal -->
        <div class="main-grid">
            <!-- Resumo Profissional -->
            <div class="card">
                <h2><i class="fas fa-user"></i> Resumo Profissional</h2>
                <p> Profissional com mais de 5 anos de experiência em Monitoramento de Servidores, Redes e Serviços de TI. Atuação em grandes empresas como Solutis, G&P e Global Hitss para os clientes Furnas, Eletrobrás, MPRJ e Caixa Econômica Federal. Experiência com Datacenter, suporte técnico, automação, Gestão de Mudanças, bases de dados (Oracle, SQL, DB2) e linguagens como Python e PHP. Gestão de Processos com BMC Remedy. Descendente de portugueses (bisavô José Alves Soares, natural de Aveiro), com processo de cidadania portuguesa em andamento e Visto de Procura de Trabalho na Embaixada (Consulado). Procuro oportunidades em gestão de TI, monitoramento de infraestrutura ou gestão de mudanças, contribuindo com a minha experiência técnica sólida em ambientes críticos. Disponível para trabalho presencial, híbrido ou remoto. Flexibilidade total para estabelecer residência em Portugal.</p>
            </div>

            <!-- Competências -->
            <div class="card">
                <h2><i class="fas fa-cogs"></i> Competências Técnicas</h2>
                <div class="skill-item">
                    <div class="skill-name">
                        <span>Monitoramento (Zabbix, Grafana, Check_MK, Dynatrace, Nagios)</span>
                        <span>90%</span>
                    </div>
                    <div class="skill-bar">
                        <div class="skill-progress" style="width: 90%"></div>
                    </div>
                </div>
                
                <div class="skill-item">
                    <div class="skill-name">
                        <span>Banco de Dados (SQL, Oracle, DB2)</span>
                        <span>75%</span>
                    </div>
                    <div class="skill-bar">
                        <div class="skill-progress" style="width: 75%"></div>
                    </div>
                </div>
                
                <div class="skill-item">
                    <div class="skill-name">
                        <span>Python & PHP</span>
                        <span>80%</span>
                    </div>
                    <div class="skill-bar">
                        <div class="skill-progress" style="width: 80%"></div>
                    </div>
                </div>
                
                <div class="skill-item">
                    <div class="skill-name">
                        <span>Automação, Inovação & Scripts</span>
                        <span>79%</span>
                    </div>
                    <div class="skill-bar">
                        <div class="skill-progress" style="width: 79%"></div>
                    </div>
                </div>
                
                <div class="skill-item">
                    <div class="skill-name">
                        <span>Gestão de Implantação & Projetos ITIL, Devops e Qualidade</span>
                        <span>88%</span>
                    </div>
                    <div class="skill-bar">
                        <div class="skill-progress" style="width: 88%"></div>
                    </div>
                </div>
            </div>

            <!-- Experiência Profissional -->
            <div class="card">
                <h2><i class="fas fa-briefcase"></i> Experiência Profissional</h2>
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-date">nov de 2023 - fev de 2025</div>
                        <div class="timeline-title">Global Hitss - Analista de Gestão de Mudanças e Implantação de Softwares</div>
                        <div class="timeline-description">Analista de Gestão de Projetos de Mudanças, Implantação (Deploy) e Atualizações (Updates) de Novas Funcionalidades e Requisitos de Softwares no Cliente Caixa Econômica Federal (CEPTI) com a gestão de todo o processo de Software da Implantação de novo sistema, nova funcionalidade, requisitos, redundância de sistema, certificação, suporte, melhorias, atualizações e desativação de software de sistemas. Acompanhamento de janelas do processo de Mudanças com a utilização do sistema BMC Remedy.</div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-date">mar de 2023 - nov de 2023</div>
                        <div class="timeline-title">Global Hitss - Analista Intermediário de Produção ou Analista de Demandas Internas</div>
                        <div class="timeline-description">Atendimento de Incidentes e Requisições dos clientes de maneira especializada e direcionada para Demandas Internas de ocorrências detalhadas pelo cliente com consulta, adição e edição de códigos que o cliente solicita para Banco de Dados SQL, DB2, Oracle, NoSQL e Big Data Hadoop em Tabelas e SGBDs específicos dos sistemas internos. Pedidos internos de execução de Scripts, Schedules e Automações de processos pelo BMC Control-M no Cliente Caixa Econômica Federal CEPTI.</div>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-date">set de 2022 - mar de 2023</div>
                        <div class="timeline-title">Global Hitss - Analista de Monitoração II</div>
                        <div class="timeline-description">Monitoramento de Servidores e Serviços no Cliente Caixa Econômica Federal CEPTI. Utilizando Grafana, Zabbix, NAVA, Graylog, painéis Java e PHP, IBM Cloud, IBM Control Center e sistemas internos de métricas do funcionamento de API's de serviços. Monitoração de serviços em Mainframe, Big Data Hadoop, Banco de dados DB2, sistema IBM Control Center e protocolo ICP de Certificação. Integração com São Paulo e Brasília. Relatório de dados coletados para acompanhamentos gerenciais e análise dos dados e incidentes acompanhados principalmente do PIX (Brazilian Swift) e outros serviços bancários e lotéricos.</div>
                    </div> </div> </div>
                    
            <div class="card">
                <div class="timeline">

                    <div class="timeline-item">
                        <div class="timeline-date">jul de 2022 - set de 2022</div>
                        <div class="timeline-title">G&P - Analista de Monitoração 4</div>
                        <div class="timeline-description">Monitoramento de Servidores e Serviços no Cliente Caixa Econômica Federal. Utilizando Grafana, Zabbix e sistemas internos de métricas do funcionamento de API's de serviços. Funcionamento 24x7 da Monitoração de serviços financeiros em Mainframe, Big Data Hadoop, Banco de dados DB2, sistema IBM Control Center e protocolo ICP de Certificação. Utilização do sistema de gerenciamento de incidentes BMC Remedy para abertura e verificação de chamados de incidentes e requerimentos. Comunicação utilizando o Microsoft Teams. Terminou o contrato de licitação no dia 12 de Setembro de 2022.</div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-date">dez de 2021 - ago de 2022</div>
                        <div class="timeline-title">Solutis Tecnologias - Analista de Suporte Computacional – Monitoring Analyst I</div>
                        <div class="timeline-description">Monitoramento de Servidores e Redes, usando Prompt de Comando Windows, Zabbix, Dynatrace, Nagios, Green4T, Admin Center Microsoft 365 Serviço Aviso de Integridade, HPE Data Protector Backup, análise de medidores de voltagem, umidade e temperatura, gráficos de falhas e tempo de resposta de serviços de aplicação interna do MPRJ, informações dos ILOs e IDRACs com recebimento do Active Directory Health Monitor toda manhã, abertura de protocolo de atendimento em sistema interno Cherwell e acionando pelo Microsoft Teams, telefone ou pessoalmente. O MPRJ não tinha Equipe de Monitoramento, então implantamos o projeto no início. Trabalhando na Gerência de Operações.</div>
                    </div>
                </div>

                    <div class="timeline-item">
                        <div class="timeline-date">jun de 2020 - dez de 2021</div>
                        <div class="timeline-title">Solutis Tecnologias - Técnico de Informática em Monitoramento de Servidores e Redes Eletrobras e Furnas – Monitoring Analyst I</div>
                        <div class="timeline-description">Monitoramento usando Prompt de Comando Windows, Zabbix, Check_MK, Trellis DCIM Vertiv, IBM Lotus Notes, VMWare vSphere, Pools de Discos Hitachi Command Suite 8, análise de medidores de voltagem, umidade e temperatura, abertura de protocolo de atendimento em sistema interno BMC Remedy. Escala 12x36 noite até manhã. Atendendo Eletrobras e Furnas no mesmo contrato. Diretamente no Datacenter da Eletrobras e cuidamos dos dois Datacenters fisicamente no controle de acesso e verificação presencial de problemas, além de auxiliar os analistas e técnicos nos problemas com cabeamento de rede, servidores, switches, storages, robots HP e IBM de fitas de backup, refrigeração, segurança e controle de incêndio.</div>
                    </div>
                </div>

            <!-- Formação Acadêmica -->
            <div class="card">
                <h2><i class="fas fa-graduation-cap"></i> Formação Acadêmica</h2>
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-date">2023 - Cursando</div>
                        <div class="timeline-title">MBA Executivo em Gestão da Qualidade de Processos</div>
                        <div class="timeline-description">Celso Lisboa</div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-date">2023 - Cursando</div>
                        <div class="timeline-title">Pós-Graduação em Engenharia de Software</div>
                        <div class="timeline-description">Celso Lisboa</div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-date">2020 - 2023</div>
                        <div class="timeline-title">Bacharelado em Ciência da Computação</div>
                        <div class="timeline-description">UNISUAM / Cruzeiro do Sul</div>
                    </div> </div> </div>
                    
            <div class="card">
                <div class="timeline">

                    <div class="timeline-item">
                        <div class="timeline-date">2014 - 2015</div>
                        <div class="timeline-title">Pós-Graduação em Metrologia e Qualidade Aplicada à Área de Software</div>
                        <div class="timeline-description">FAETERJ e INMETRO</div>
                    </div>
                    
                    <div class="timeline-item">
                        <div class="timeline-date">2013 - 2015</div>
                        <div class="timeline-title">Técnico Subsequente em Eletrônica <br> Registrado no CFT-BR nº 201600332-4 </div>
                        <div class="timeline-description">FAETEC</div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-date">2009 - 2012</div>
                        <div class="timeline-title">Tecnologia em Gestão de Recursos Humanos. <br> Registro Desativado CRA-RJ nº 03-01013</div>
                        <div class="timeline-description">Universidade Castelo Branco (UCB-Realengo)</div>
                    </div>
                </div>
            </div>

<?php
            // Ótimo desempenho acadêmico. Experiência de Profissional Autônomo como Técnico em Montagem, Manutenção e Configuração de Computadores e Redes (2007-2022), experiência em Serviços TI, Atendimento, Manutenção de Hardware, Impressoras, Automação e Softwares, conhecimentos de cursos complementares em Fibra Óptica, Redes, UML, Java, Administração Financeira, software de gestão de departamento pessoal, informática, inglês intermediário, manutenção e projetos de Eletrônica, experiência em atendimento, organização de dados, conseguir atenção de clientes e atendimento de recepção. À procura de oportunidades em minhas áreas de formação que sejam úteis para o desenvolvimento profissional e econômico da empresa interessada em meus serviços.
?>

            <!-- Certificações -->
            <div class="card full-width">
                <h2><i class="fas fa-certificate"></i> Certificações</h2>
                <div class="cert-grid">
                    <div class="cert-badge">
                        <i class="fab fa-microsoft"></i><br>
                        MD-100 Microsoft Windows 10
                    </div>
                    <div class="cert-badge">
                        <i class="fas fa-headset"></i><br>
                        HDI Support Center Analyst (SCA) - Introdução ao ITIL
                    </div>
                    <div class="cert-badge">
                        <i class="fas fa-bolt"></i><br>
                        NR-10 (precisa ser renovada)
                    </div>
                </div>
            </div>

            <!-- Projetos Desenvolvidos -->
            <div class="card">
                <h2><i class="fas fa-code"></i> Projetos Desenvolvidos</h2>
                <div class="project-card">
                    <div class="project-title">Sistema de Cálculo de Tempo para o Visto de Procura de Trabalho para Portugal</div>
                    <p>Aplicação web desenvolvida para auxiliar no cálculo de tempo necessário para visto de procura de trabalho em Portugal.</p>
                    <a href="https://hinshitsu.site/visto/" target="_blank" class="project-link">
                        <i class="fas fa-external-link-alt"></i>
                        Acessar Sistema
                    </a>
                </div>
                <br>
                <h3><i class="fas fa-code"></i> Desenvolvi Três Projetos que deixei para o Monitoramento do MPRJ como um diferencial: </h3>

                <div class="project-card">
                    <div class="project-title">Projeto Livro de Ocorrências em Microsoft OneNote</div>
                    <p>A ideia era seguir o funcionamento como do Etherpad Lite, só que usando o Microsoft OneNote para registro dos ocorridos do dia e registrando quem escreveu, além das aberturas de ocorrências.</p>
                        <div class="project-link">
                            <i class="fas fa-lock"></i>
                        Projeto Empresarial Interno
                    </div>
                </div>

                <div class="project-card">
                    <div class="project-title">Projeto Gerador de Template Pronto na Intranet em PHP e XAMPP</div>
                    <p>A ideia era desenvolver uma forma automática para preencher as informações que eram necessárias para registrar nos incidentes, então preencher o template e informar de maneira automatizada para só registrar.</p>
                        <div class="project-link">
                            <i class="fas fa-lock"></i>
                        Projeto Empresarial Interno
                    </div>
                </div>

                <div class="project-card">
                    <div class="project-title">Projeto Automação em Parte da Abertura de Chamados utilizando a ferramenta One Step do Cherwell</div>
                    <p>A ideia era fazer o sistema registrar sozinho o que era desejado depois do preenchimento no outro sistema, porém alguns funcionavam e outros não. Mesmo assim garantiria um pouco do que era necessário.</p>
                        <div class="project-link">
                            <i class="fas fa-lock"></i>
                        Projeto Empresarial Interno
                    </div>
                </div>

            </div>

            <!-- Hinshitsu Serviços e Vendas -->
            <div class="card">
                <h2><i class="fas fa-store"></i> Hinshitsu Serviços e Vendas</h2>
                <div class="project-card">
                    <div class="project-title">Hinshitsu Vendas</div>
                    <p>Loja online especializada na venda de livros, revistas, mangás e jogos através da plataforma Shopee ou Whatsapp.</p>
                    <a href="https://hinshitsu.site/vendas/" target="_blank" class="project-link">
                        <i class="fas fa-shopping-cart"></i>
                        Visitar Loja
                    </a> 
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer">
            <p>© <?php echo date("Y"); ?> Danilo de Almeida Souza Soares. Todos os direitos reservados.
            <a href="https://hinshitsu.site/" target="_blank" class="project-link">
                        <i class="fas fa-external-link-alt"></i>
                        Hinshitsu Services </p>
                    </a>            
            <p>Desenvolvido com <i class="fas fa-heart" style="color: #e74c3c;"></i> pela Tecnologia e muito café ☕</p>
        </footer>
    </div>

    <script>
        // Animação suave para as barras de habilidade
        document.addEventListener('DOMContentLoaded', function() {
            const skillBars = document.querySelectorAll('.skill-progress');
            
            const observerOptions = {
                threshold: 0.5,
                rootMargin: '0px 0px -100px 0px'
            };
            
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animationPlayState = 'running';
                    }
                });
            }, observerOptions);
            
            skillBars.forEach(bar => {
                bar.style.animationPlayState = 'paused';
                observer.observe(bar);
            });
        });

        // Smooth scroll para links internos
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Efeito de digitação no título (opcional)
        function typeWriter(element, text, speed = 100) {
            let i = 0;
            element.innerHTML = '';
            
            function typing() {
                if (i < text.length) {
                    element.innerHTML += text.charAt(i);
                    i++;
                    setTimeout(typing, speed);
                }
            }
            typing();
        }

        // Adicionar alguns micro-interactions
        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(-10px) scale(1)';
            });
        });
        
        function showPrivacyModal() {
    document.getElementById('privacyOverlay').classList.add('active');
}

function hidePrivacyModal() {
    document.getElementById('privacyOverlay').classList.remove('active');
}

function acceptPrivacy() {
    localStorage.setItem('privacy', 'accepted');
    hidePrivacyModal();
}

// Fecha clicando fora
document.getElementById('privacyOverlay').onclick = function(e) {
    if (e.target === this) hidePrivacyModal();
}

// Auto-exibe se não foi aceito
if (!localStorage.getItem('privacy')) {
    setTimeout(showPrivacyModal, 1000);
}
        
    </script>
</body>
</html>