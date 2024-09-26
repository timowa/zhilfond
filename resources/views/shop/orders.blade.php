@extends('layout')

@section('content')
    <h1>Список заказов</h1>
    <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Товары</th>
              <th>Сумма</th>
            </tr>
          </thead>
          <tbody>
          @php($total = 0)
          @foreach($orders as $order)
              @php($orderTotal = $order->getTotal())
              @php($total += $orderTotal)
              <tr>
              <td>{{$order->id}}</td>
              <td>{{$order->getJoinProductNames(', ') }}</td>
              <td>${{$orderTotal}}</td>
            </tr>
          @endforeach
        <tr>
            <td colspan="3">Итого: ${{$total}}</td>
        </tr>
        </table>
@endsection
