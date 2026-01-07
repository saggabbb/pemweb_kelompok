<h1>Courier Dashboard</h1>

@if ($orders->isEmpty())
    <p>Belum ada order untuk dikirim.</p>
@else
    @foreach ($orders as $order)
        <div style="margin-bottom: 16px;">
            <strong>Order #{{ $order->id }}</strong><br>
            Buyer: {{ $order->buyer->name }}<br>
            Status: {{ $order->status }}<br>

            <ul>
                @foreach ($order->details as $detail)
                    <li>
                        {{ $detail->product->product_name }}
                        ({{ $detail->quantity }} pcs)
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach
@endif
