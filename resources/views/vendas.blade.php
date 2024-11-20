@include('layouts.header')
<div class="flex w-full lg:flex-row h-full">
    <div class="card bg-base-300 rounded-box grid h-full w-1/6 flex-grow place-items-center m-1 p-5 place-items-center">
        <div class="container mt-5">
            <h1>Filtros</h1>
            <form method="GET" action="{{ route('vendas.index') }}" class="row g-3">
                <div class="col-md-5">
                    <label for="data_inicio" class="form-control">Data Início</label>
                    <input type="date" id="data_inicio" name="data_inicio" class="form-control"
                        value="{{ request('data_inicio') }}" required>
                </div>
                <div class="col-md-5">
                    <label for="data_fim" class="form-control">Data Fim</label>
                    <input type="date" id="data_fim" name="data_fim" class="form-control"
                        value="{{ request('data_fim') }}" required>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                </div>
            </form>


            <!-- Área para exibir os resultados
            @if(isset($vendas) && count($vendas) > 0)
                <h2 class="mt-5">Resultados:</h2>
                <ul class="list-group">
                    @foreach ($vendas as $venda)
                        <li class="list-group-item">
                            {{ $venda->vendedor }} - R$ {{ number_format($venda->valor_total, 2, ",", ".") }}
                        </li>
                    @endforeach
                </ul>
            @elseif(isset($vendas))
                <p class="mt-5 text-danger">Nenhum resultado encontrado para o período selecionado.</p>
            @endif -->
        </div>
    </div>
    <div class="card bg-base-300 rounded-box h-full w-5/6 flex-grow place-items-center m-1">
        container
    </div>
</div>
@include('layouts.footer')