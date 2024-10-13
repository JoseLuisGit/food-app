<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pedido: {{uniqid()}}</title>
    <style>
        h4 {
            margin: 0;
        }

        .w-full {
            width: 100%;
        }

        .w-half {
            width: 50%;
        }

        .margin-top {
            margin-top: 1.25rem;
        }

        .footer {
            font-size: 0.875rem;
            padding: 1rem;
            background-color: rgb(241 245 249);
        }

        table {
            width: 100%;
            border-spacing: 0;
        }

        table.products {
            font-size: 0.875rem;
        }

        table.products tr {
            background-color: rgb(96 165 250);
        }

        table.products th {
            color: #ffffff;
            padding: 0.5rem;
        }

        table tr.items {
            background-color: rgb(241 245 249);
        }

        table tr.items td {
            padding: 0.5rem;
            text-align: right;
        }

        .total {
            text-align: right;
            margin-top: 1rem;
            font-size: 0.875rem;
        }
    </style>
</head>

<body>
    <table class="w-full">
        <tr>
            <!--<td class="w-half">
                <img src="{{ asset('laraveldaily.png') }}" alt="laravel daily" width="200" />
            </td> -->
            <td class="w-half">
                <h2>Pedido para {{$product->name}}</h2>
                <h3>{{$date}}</h3>
            </td>
        </tr>
    </table>

    <div class="margin-top">
        <table class="w-full">
            <tr>
                <td class="w-half">
                    <div>
                        <h4>{{$product->name}}</h4>
                    </div>
                    <div>{{$product->description}}</div>
                    <div>{{$product->price}} Bs.</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="margin-top">
        @if(count($details) > 0)
            <table class="products">
                <tr>
                    <th>Extra</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                </tr>
                <tr class="items">
                    @foreach($details as $item)
                        <td>
                            {{ $item['name'] }}
                        </td>
                        <td>
                            {{ $item['price'] }} Bs.
                        </td>
                        <td>
                            {{ $item['quantity'] }}
                        </td>
                        <td>
                            {{$item['price'] * $item['quantity']}} Bs.
                        </td>
                    @endforeach
                </tr>
            </table>
        @else
            <div>
                No ha seleccionado un extra adicional
            </div>
        @endif
    </div>

    @php
        $total = $product->price;

        foreach ($details as $item) {
            $total += $item['price'] * $item['quantity'];
        }
    @endphp

    <div class="total">
        Total: {{$total}} Bs.
    </div>

</body>

</html>