<div>
    <!-- Store name -->
    <h1>{{ $store_name }}</h1>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Client</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Country</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
                <th>Date Created</th>
                <th>Status</th>
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order['Order ID'] }}</td>
                <td>{{ $order['Client'] }}</td>
                <td>{{ $order['Email'] }}</td>
                <td>{{ $order['Phone'] }}</td>
                <td>{{ $order['Address'] }}</td>
                <td>{{ $order['Country'] }}</td>
                <td>
                    @foreach($order['Products'] as $product)
                    <p>{{ $product['Product Name'] }}</p>
                    @endforeach
                </td>
                <td>
                    @foreach($order['Products'] as $product)
                    <p>{{ $product['Quantity'] }}</p>
                    @endforeach
                </td>
                <td>
                    @foreach($order['Products'] as $product)
                    <p>{{ $product['Price'] }} DH</p>
                    @endforeach
                </td>
                <td>
                    @foreach($order['Products'] as $product)
                    <p>{{ $product['Total'] }} DH</p>
                    @endforeach
                </td>
                <td>{{ $order['Date Created'] }}</td>
                <td>{{ $order['Status'] }}</td>
                <td>{{ $order['Total Amount'] }} DH</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
</div>