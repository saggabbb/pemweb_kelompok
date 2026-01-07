<h1>Buyer Dashboard</h1>

@if ($orders->isEmpty())
    <p>Belum ada order.</p>
@else
    @foreach ($orders as $order)
        <div style="margin-bottom: 16px;">
            <strong>Order #{{ $order->id }}</strong><br>
            Status: {{ $order->status }}<br>
            Total: Rp {{ number_format($order->total_price) }}<br>

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
