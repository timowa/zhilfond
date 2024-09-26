@extends('layout')

@section('content')
    <div class="container">
  <main>
    <div class="row g-5">
      <div class="col-md-5 col-lg-4">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-primary">Ваша корзина</span>
          <span class="badge bg-primary rounded-pill">{{$countInCart}}</span>
        </h4>
        <ul class="list-group mb-3">
            @php($totalSum = 0)
            @foreach($cart as $item)
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0">{{$item['product']['name']}}</h6>
              <small class="text-body-secondary">Количество: {{$item['quantity']}}</small>
            </div>
               <div>
              <h6 class="my-0">${{$item['product']['price']}}</h6>
                   @php($totalSum += $item['quantity'] * $item['product']['price'])
              <small class="text-body-secondary">${{$item['quantity'] * $item['product']['price']}}</small>
            </div>

          </li>
            @endforeach
          <li class="list-group-item d-flex justify-content-between">
            <span>Total (USD)</span>
            <strong>${{$totalSum}}</strong>
          </li>
        </ul>

        <form class="card p-2" action="{{route('shop.createOrder')}}">
          <div class="input-group">
            <button type="submit" class="btn btn-primary">Оформить заказ</button>
          </div>
        </form>
      </div>
    </div>
  </main>

</div>
@endsection
