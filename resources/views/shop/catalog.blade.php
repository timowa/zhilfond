@extends('layout')

@section('content')
    <div class="row" id="catalog">
        <h1>Всего продуктов: {{$products->total()}}</h1>
    @foreach($products as $product)
        <div class="col-md-4">
        <div class="card mb-4 rounded-3 shadow-sm">
          <div class="card-header py-3">
            <h4 class="my-0 fw-normal">{{$product->name}}</h4>
          </div>
          <div class="card-body">
            <h1 class="card-title pricing-card-title">${{$product->price}}<small class="text-body-secondary fw-light"></small></h1>
            <ul class="list-unstyled mt-3 mb-4">
              <li>Остаток: <span data-maxQty>{{$product->quantity}}</span></li>
            </ul>
               <div class="row">
                <div class="btn-group col-6" role="group" aria-label="Basic outlined example">
                  <button type="button" class="btn btn-outline-primary" data-btnMinus>-</button>
                  <input type="text" class="btn w-25 border border-primary" >
                  <button type="button" class="btn btn-outline-primary" data-btnPlus>+</button>
                </div>
                <div class="col-5">
                    <button type="button" class="btn btn-outline-primary" data-addToCartBtn data-productId="{{$product->id}}">Добавить в корзину</button>
                </div>
            </div>
          </div>
        </div>
      </div>

    @endforeach
</div>
    {{$products->links('vendor.pagination.bootstrap-4')}}
    <script>
        document.querySelectorAll('[data-btnPlus]').forEach(function(btnPlus) {
            btnPlus.addEventListener('click', function(e){
                let input = e.target.previousElementSibling,
                    count = input.value ?? 0,
                    max = parseInt(e.target.closest('.card-body').querySelector('[data-maxQty]').innerText)
                if (max > count++) {
                    input.value = count
                }

            })
        })
        document.querySelectorAll('[data-btnMinus]').forEach(function(btnMinus) {
            btnMinus.addEventListener('click', function(e){
                let input = e.target.nextElementSibling,
                    count = parseInt(input.value) ?? 0;
                if (count > 0) {
                    input.value = --count
                }

            })
        })
        document.querySelectorAll('[data-addToCartBtn]').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                let productId = e.target.dataset.productid,
                    qty = parseInt(e.target.closest('.card-body').querySelector('input').value)
                if (!isNaN(qty)) {
                    addToCart(productId, qty)
                }
            })
        })

        function addToCart(productId, qty) {
            $.ajax({
                       headers: {
                           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                       },
                       url: '{{route('addToCart')}}',
                       method: 'post',
                       data: {
                           productId: productId,
                           quantity: qty
                       },
                       success: function (data) {
                           if ($('[data-countInCart]').length > 0) {
                               $('[data-countInCart]').text(data)
                           }
                       }
                   })
        }
    </script>
@endsection
