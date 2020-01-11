<div class="print-area">
        <table class="table table-hover">
            <caption><h4 style="color:red;">{{$client->name}}</h4></caption>
            <thead>
            <tr>
                <th>@lang('site.name')</th>
                <th>@lang('site.quantity')</th>
                <th>@lang('site.price')</th>
            </tr>
            </thead>

            <tbody class="show-order-list">

            @foreach($products as $product)
                <tr>
                <td>{{$product->name}}</td>
                <td>{{$product->pivot->quantity}}</td>
                <td>{{$product->sales_price * $product->pivot->quantity}}</td>
                </tr>
                @endforeach

            </tbody>

        </table><!-- end of table -->

        <h4>@lang('site.total') : <span class="total-price">{{$order->total_price}}</span></h4>




</div>