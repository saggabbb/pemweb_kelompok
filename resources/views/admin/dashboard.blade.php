<h1>Admin Dashboard</h1>

@foreach ($orders as $order)
    <p>
        Order #{{ $order->id }} -
        Buyer: {{ $order->buyer->name }} -
        Status: {{ $order->status }}
    </p>
@endforeach
