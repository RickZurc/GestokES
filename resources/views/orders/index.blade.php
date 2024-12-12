@extends('layouts.admin')

@section('title', __('order.Orders_List'))
@section('content-header', __('order.Orders_List'))
@section('content-actions')
    <a href="{{route('cart.index')}}" class="btn btn-primary">{{ __('cart.title') }}</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-7"></div>
            <div class="col-md-5">
                <form action="{{route('orders.index')}}">
                    <div class="row">
                        <div class="col-md-5">
                            <input type="text" name="min_price" class="form-control" value="{{request('min_price')}}" />
                        </div>
                        <div class="col-md-5">
                            <input type="text" name="max_price" class="form-control" value="{{request('max_price')}}" />
                        </div>
                        <div class="col-md-5">
                            <input type="date" name="start_date" class="form-control" value="{{request('start_date')}}" />
                        </div>
                        <div class="col-md-5">
                            <input type="date" name="end_date" class="form-control" value="{{request('end_date')}}" />
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-outline-primary" type="submit">{{ __('order.submit') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Action</th>
                    <th>{{ __('order.ID') }}</th>
                    <th>{{ __('order.Customer_Name') }}</th>
                    <th>{{ __('order.Total') }}</th>
                    <th>{{ __('order.Received_Amount') }}</th>
                    <th>{{ __('order.Status') }}</th>
                    <th>Troco ao Cliente</th>
                    <th>{{ __('order.Created_At') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                    <td>
                        <a href="{{route('orders.show', $order)}}" class="btn btn-primary"><i class="fas fa-eye"></i></a>
                    </td>
                    <td>{{$order->id}}</td>
                    <td>{{$order->getCustomerName()}}</td>
                    <td>{{ config('settings.currency_symbol') }} {{$order->formattedTotal()}}</td>
                    <td>{{ config('settings.currency_symbol') }} {{$order->formattedReceivedAmount()}}</td>
                    <td>
                        @if($order->receivedAmount() == 0)
                            <span class="badge badge-danger">{{ __('order.Not_Paid') }}</span>
                        @elseif($order->receivedAmount() < $order->total())
                            <span class="badge badge-warning">{{ __('order.Partial') }}</span>
                        @elseif($order->receivedAmount() == $order->total())
                            <span class="badge badge-success">Pago a Inteiro</span>
                        @elseif($order->receivedAmount() > $order->total())
                            <span class="badge badge-info">{{ __('order.Change') }}</span>
                        @endif
                    </td>
                    <td>{{config('settings.currency_symbol')}} {{number_format($order->total() - $order->receivedAmount(), 2)}}</td>
                    <td>{{$order->created_at}}</td>
                    <td>
                        <button class="btn btn-danger btn-delete" data-url="{{route('orders.destroy', $order)}}"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th></th>
                    <th>{{ config('settings.currency_symbol') }} {{ number_format($total, 2) }}</th>
                    <th>{{ config('settings.currency_symbol') }} {{ number_format($receivedAmount, 2) }}</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
        {{ $orders->render() }}
    </div>
</div>
@endsection


@section('js')
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script type="module">
    $(document).ready(function() {
        $(document).on('click', '.btn-delete', function() {
            var $this = $(this);
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: "Eliminar Pedido",
                text: "Quer mesmo eliminar este pedido?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "Sim",
                cancelButtonText: "Não",
                reverseButtons: true
            }).then((result) => {

                if (result.value) {
                    $.post($this.data('url'), {
                        _method: 'DELETE',
                        _token: '{{csrf_token()}}'
                    }, function(res) {
                        $this.closest('tr').fadeOut(500, function() {
                            $(this).remove();
                            //present res.amount and res.totalAmount with 2 decimal places
                            $('tfoot th:nth-child(3)').text('€ ' + res.totalAmount.toFixed(2))
                            $('tfoot th:nth-child(4)').text('€ ' + res.amount.toFixed(2))
                        })


                    })
                }
            })
        })
    })
</script>
@endsection
