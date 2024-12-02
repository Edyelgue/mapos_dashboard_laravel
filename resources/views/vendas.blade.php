@include('layouts.header')
<div class="flex flex-col lg:flex-row w-full">

    <div class="card bg-white border shadow-lg rounded-box grid h-full lg:w-1/6 flex-grow place-items-center mx-2 my-2 p-5">
        <h1 class="font-bold text-1xl">Selecione o Período</h1>
        <div class="container mt-5 w-full">

            <form method="GET" action="{{ route('vendas.index') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div class="flex flex-col border rounded">
                    <label for="data_inicio" class="mb-1">Data Início</label>
                    <input type="date" id="data_inicio" name="data_inicio" class="text-sm form-control w-full"
                           value="{{ request('data_inicio') }}" required">
                </div>

                <div class="flex flex-col border rounded">
                    <label for="data_fim" class="mb-1">Data Fim</label>
                    <input type="date" id="data_fim" name="data_fim" class="text-sm form-control w-full"
                           value="{{ request('data_fim') }}" required>
                </div>

                <div class="md:col-span-2 flex justify-center">
                    <button type="submit" class="btn btn-info text-gray-100 font-bold w-full md:w-auto">Filtrar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card bg-white border shadow-lg mb-4 rounded-box h-full lg:w-5/6 flex-grow place-items-center m-2" data-theme="light">
        <div class="container mt-5 w-full">
            <canvas id="vendasChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script>
    // Registra o plugin
    Chart.register(ChartDataLabels);

    var vendedores = @json($vendedores); // Passa o array de vendedores
    var vendas = @json($valoresVendas);  // Passa o array de vendas

    // Formatar os valoresVendas como número real e moeda antes de passar para o gráfico
    var vendasFormatted = vendas.map((valor) => {
        // Formata o valor como moeda para visualização, mas mantém o valor numérico real para o gráfico
        return {
            value: valor,
            formatted: valor.toLocaleString('pt-BR', {style: 'currency', currency: 'BRL', minimumFractionDigits: 2})
        };
    });

    var ctx = document.getElementById('vendasChart').getContext('2d');
    var vendasChart = new Chart(ctx, {
        type: 'bar', // Tipo de gráfico (barra)
        data: {
            labels: vendedores, // Labels dos vendedores
            datasets: [{
                label: 'Total de Vendas (R$)',
                data: vendasFormatted.map(item => item.value), // Passa os valores reais (não formatados como moeda)
                backgroundColor: 'rgba(54, 162, 235, 0.2)', // Cor de fundo das barras
                borderColor: 'rgba(54, 162, 235, 1)', // Cor da borda das barras
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
                            // Formata os valores exibidos na tooltip como moeda
                            return new Intl.NumberFormat('pt-BR', {
                                style: 'currency',
                                currency: 'BRL'
                            }).format(context.raw);
                        }
                    }
                },
                datalabels: {
                    color: '#1a1a1a', // Cor escura para os rótulos
                    anchor: 'end', // Posicionamento da âncora
                    align: 'top',  // Alinhamento do rótulo
                    formatter: (value) => {
                        // Formata o valor do rótulo como moeda
                        return new Intl.NumberFormat('pt-BR', {
                            style: 'currency',
                            currency: 'BRL'
                        }).format(value);  // Usa o valor bruto da barra
                    },
                    font: {
                        size: 12, // Tamanho da fonte
                        weight: 'bold' // Negrito para destacar
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grace: '15%',
                    ticks: {
                        callback: function (value) {
                            // Formata os valores do eixo Y como moeda
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
</script>
@include('layouts.footer')
