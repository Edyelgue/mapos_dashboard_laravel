<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.22/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Dashboards</title>
</head>

<body class="" data-theme="corporate">

    <div class="drawer lg:drawer-open">
        <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content flex flex-col items-center justify-center">
            <!-- Page content here -->
            <div class="w-full text-right">
                <label for="my-drawer-2" class="btn btn-warning drawer-button lg:hidden rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd"
                            d="M3 6.75A.75.75 0 0 1 3.75 6h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 6.75ZM3 12a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 12Zm0 5.25a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75a.75.75 0 0 1-.75-.75Z"
                            clip-rule="evenodd" />
                    </svg>
                </label>
            </div>
            <h1 class="font-bold text-3xl mt-4">Vendas</h1>

            <!-- Filtro -->
            <div class="h-full px-4 w-full items-center justify-center text-center mt-4">
                <div class="flex justify-between">
                    <form method="GET" action="{{ route('vendas.index') }}"
                        class="flex items-center space-x-4 border border-yellow-400 rounded-md p-4 shadow-lg">

                        <div class="flex flex-col">
                            <label for="data_inicio" class="mb-1 font-bold">Data Início</label>
                            <input type="date" id="data_inicio" name="data_inicio" class="text-sm form-control w-full"
                                value="{{ request('data_inicio') }}" required>
                        </div>

                        <div class="flex flex-col">
                            <label for="data_fim" class="mb-1 font-bold">Data Fim</label>
                            <input type="date" id="data_fim" name="data_fim" class="text-sm form-control w-full"
                                value="{{ request('data_fim') }}" required>
                        </div>

                        <button type="submit" class="btn btn-warning font-bold rounded-md">Filtrar</button>
                    </form>
                </div>

                <!-- Cards -->
                <div class="flex items-center justify-between mt-4">
                    <div class="w-1/2 rounded-lg border shadow-md p-2" data-theme="nord">
                        <h2 class="font-semibold sm:text-xl">Total Vendas</h2>
                        <p class="font-bold sm:text-2xl">
                        R$ {{ number_format($valorTotal, 2, ',', '.') ?? 'Nenhum dado disponível' }}
                        </p>
                    </div>

                    <div class="w-1/2 ml-4 rounded-lg border shadow-md p-2" data-theme="nord">
                        <h2 class="font-semibold sm:text-xl">Quantidade Vendas</h2>
                        <p class="font-bold sm:text-2xl">
                            {{ $vendasRealizadas }}
                        </p>
                    </div>
                </div>

                <!-- Gráficos -->
                <div class="mt-4 2xl:flex">
                    <div class="my-4 2xl:my-0 2xl:w-1/2 h-64 sm:h-96 rounded-lg 2xl:mr-2 border shadow-md items-center justify-center flex"
                        data-theme="nord">
                        <canvas id="vendasChart"></canvas>

                    </div>

                    <div class="my-4 2xl:my-0 2xl:w-1/2 h-64 sm:h-96 rounded-lg 2xl:ml-2 border shadow-md items-center justify-center flex"
                        data-theme="nord">
                        <canvas id="chartVendasPorVendedor"></canvas>
                    </div>
                </div>
            </div>

        </div>
        <div class="drawer-side">
            <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label>
            <ul class="menu bg-yellow-300 text-base-content min-h-full w-72 p-4">
                <h1 class="font-bold text-3xl">Dashboards</h1>
                <!-- Sidebar content here -->
                <li><a>Vendas</a></li>
                <li><a>Estoque</a></li>
                <li><a>Assistência</a></li>
                <li><a>Receitas</a></li>
                <li><a>Despesas</a></li>
                <li><a>Custos</a></li>
            </ul>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script>

        window.onload = function () {
            // Dados enviados pelo controller
            const vendedores = @json($vendedores);
            const valoresVendas = @json($valoresVendas);

            // Gráfico de vendas por vendedor (R$)
            const ctx = document.getElementById('vendasChart').getContext('2d');
            const vendasChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: vendedores,
                    datasets: [{
                        label: 'Vendas por Vendedor (R$)',
                        data: valoresVendas,
                        backgroundColor: 'rgba(255, 206, 86, 0.2)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return new Intl.NumberFormat('pt-BR', {
                                        style: 'currency',
                                        currency: 'BRL'
                                    }).format(context.raw);
                                }
                            }
                        },
                        datalabels: {
                            color: '#1a1a1a',
                            anchor: 'end',
                            align: 'top',
                            formatter: (value) => {
                                return new Intl.NumberFormat('pt-BR', {
                                    style: 'currency',
                                    currency: 'BRL'
                                }).format(value);
                            },
                            font: {
                                size: 12,
                                weight: 'bold'
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grace: '15%',
                            ticks: {
                                stepSize: 350,
                                callback: function (value) {
                                    return new Intl.NumberFormat('pt-BR', {
                                        style: 'currency',
                                        currency: 'BRL'
                                    }).format(value);
                                }
                            }
                        }
                    }
                }
            });

            // Gráfico de vendas por vendedor (quantidade)
            const vendedoresQtd = {!! json_encode(array_keys($quantidadeVendasPorVendedor)) !!};
            const vendasPorVendedorQtd = {!! json_encode(array_values($quantidadeVendasPorVendedor)) !!};

            const ctx2 = document.getElementById('chartVendasPorVendedor').getContext('2d');
            const chartVendasPorVendedor = new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: vendedoresQtd,
                    datasets: [{
                        label: 'Quantidade de Vendas',
                        data: vendasPorVendedorQtd,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)', // Verde claro
                        borderColor: 'rgb(75, 192, 192)', // Verde padrão
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

        };
    </script>
</body>

</html>
