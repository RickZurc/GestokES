<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concurso de Bebidas</title>
    <style>
        /* Estilo básico */
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
        }

        .titulo-tabela {
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #004e89;
            text-align: center;
        }

        /* Estilo da Tabela */
        .competicao-tabela {
            width: 90%;
            max-width: 800px;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
        }

        .competicao-tabela thead {
            background-color: #004e89;
            color: #fff;
        }

        .competicao-tabela th,
        .competicao-tabela td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .competicao-tabela th {
            font-size: 1.2em;
            font-weight: bold;
        }

        .competicao-tabela td figure {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
        }

        .competicao-tabela img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-bottom: 8px;
        }

        .competicao-tabela a {
            color: #2a9d8f;
            text-decoration: none;
            font-weight: bold;
        }

        .competicao-tabela a:hover {
            color: #004e89;
            text-decoration: underline;
        }

        /* Linhas Alternadas para Leitura e Acessibilidade */
        .competicao-tabela tbody tr:nth-child(odd) {
            background-color: #e6f4f1;
        }

        .competicao-tabela tbody tr:nth-child(even) {
            background-color: #ffffff;
        }

        /* Efeito de Hover */
        .competicao-tabela tbody tr:hover {
            background-color: #bde0fe;
            transition: background-color 0.3s;
        }

        /* Responsividade */
        @media (max-width: 600px) {
            .competicao-tabela th, .competicao-tabela td {
                padding: 10px;
                font-size: 0.9em;
            }
            .competicao-tabela img {
                width: 50px;
                height: 50px;
            }
        }

    </style>
</head>
<body>
    <h1 class="titulo-tabela" aria-label="Concurso de Bebidas">Concurso de Bebidas</h1>
    <h3>Sistema de Pontos: Cerveja 1 ponto; Caneca 2 pontos ; Shot 2 pontos</h3>
    <table class="competicao-tabela">
    <thead>
        <tr>
            <th scope="col">Ranking</th>
            <th scope="col">Tunas</th>
            <th scope="col">Cerveja</th>
            <th scope="col">Canecas</th>
            <th scope="col">Shots</th>
            <th scope="col">Pontos</th>
            {{-- <th scope="col">Instagram</th> --}}
        </tr>
    </thead>
    <tbody>
        <div id="concurso"></div>
        <!--~concurso></~concurso-->
    </tbody>
</table>
</body>
</html>
