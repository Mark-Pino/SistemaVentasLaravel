@extends('dashboard.body.main')

@section('container')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            @if (session()->has('success'))
                <div class="alert text-white bg-success" role="alert">
                    <div class="iq-alert-text">{{ session('success') }}</div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="ri-close-line"></i>
                    </button>
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert text-white bg-danger" role="alert">
                    <div class="iq-alert-text">{{ session('success') }}</div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="ri-close-line"></i>
                    </button>
                </div>
            @endif
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="mb-3">Lista de Productos</h4>
                    <p class="mb-3 mr-3">Un panel de control de productos te permite recopilar y visualizar datos de productos de <br> manera sencilla para optimizar la experiencia del producto y garantizar la retención del producto. </p>
                </div>
                <div>
                <a href="{{ route('products.importView') }}" class="btn btn-success add-list">Importar</a>
                <a href="{{ route('products.exportData') }}" class="btn btn-warning add-list">Exportar</a>
                <a href="{{ route('products.create') }}" class="btn btn-primary add-list">Agregar Producto</a>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <form action="{{ route('products.index') }}" method="get">
                <div class="d-flex flex-wrap align-items-center justify-content-between ml-1">
                    <div class="form-group row">
                        <label for="row" class="col-sm-3 align-self-center">Filas:</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="row" onchange="this.form.submit()">
                                <option value="10" @if(request('row') == '10')selected="selected"@endif>10</option>
                                <option value="25" @if(request('row') == '25')selected="selected"@endif>25</option>
                                <option value="50" @if(request('row') == '50')selected="selected"@endif>50</option>
                                <option value="100" @if(request('row') == '100')selected="selected"@endif>100</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-sm-2 align-self-center" for="search">Buscar:</label>
                        <div class="input-group col-sm-10">
                            <input type="text" id="search" class="form-control" name="search" placeholder="Producto" value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button type="submit" class="input-group-text bg-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Buscar"><i class="fa-solid fa-magnifying-glass font-size-20"></i></button>
                                <a href="{{ route('products.index') }}" class="input-group-text bg-danger"
                                data-toggle="tooltip" data-placement="top" title="" data-original-title="Borrar"><i class="fa-solid fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-12">
            <div class="table-responsive rounded mb-3">
                <table class="table mb-0">
                    <thead class="bg-white text-uppercase">
                        <tr class="ligth ligth-data">
                            <th>#</th>
                            <th>Foto</th>
                            <th>@sortablelink('product_name', 'Nombre')</th>
                            <th>@sortablelink('category.name', 'Categoria')</th>
                            <th>@sortablelink('supplier.name', 'Proveedor')</th>
                            <th>@sortablelink('selling_price', 'Precio')</th>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody class="ligth-body">
                        @forelse ($products as $product)
                        <tr>
                            <td>{{ (($products->currentPage() * 10) - 10) + $loop->iteration  }}</td>
                            <td>
                                <img class="avatar-60 rounded" src="{{ $product->product_image ? asset('storage/products/'.$product->product_image) : asset('assets/images/product/default.webp') }}">
                            </td>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>{{ $product->supplier->name }}</td>
                            <td>{{ $product->selling_price }}</td>
                            <td>
                                @if ($product->expire_date > Carbon\Carbon::now()->format('Y-m-d'))
                                    <span class="badge rounded-pill bg-success">Valido</span>
                                @else
                                    <span class="badge rounded-pill bg-danger">Invalido</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="margin-bottom: 5px">
                                    @method('delete')
                                    @csrf
                                    <div class="d-flex align-items-center list-action">
                                        <a class="btn btn-info mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Ver"
                                            href="{{ route('products.show', $product->id) }}"><i class="ri-eye-line mr-0"></i>
                                        </a>
                                        <a class="btn btn-success mr-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Editar"
                                            href="{{ route('products.edit', $product->id) }}"><i class="ri-pencil-line mr-0"></i>
                                        </a>
                                            <button type="submit" class="btn btn-warning mr-2 border-none" onclick="return confirm('Are you sure you want to delete this record?')" data-toggle="tooltip" data-placement="top" title="" data-original-title="Eliminar"><i class="ri-delete-bin-line mr-0"></i></button>
                                    </div>
                                </form>
                            </td>
                        </tr>

                        @empty
                        <div class="alert text-white bg-danger" role="alert">
                            <div class="iq-alert-text">Datos no encontrados.</div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <i class="ri-close-line"></i>
                            </button>
                        </div>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $products->links() }}
        </div>
    </div>
    <!-- Page end  -->
</div>

@endsection
