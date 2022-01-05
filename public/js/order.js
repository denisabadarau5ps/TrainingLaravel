function renderOrder(order) {
    let html = `<h1>Order #${ order.id } </h1>
                <h3>Created at: ${ order.created_at }</h3>`;
    html += `<table style="border-collapse:collapse;width:100%; border: 1px solid black; text-align: center">
                 <tr style="border-bottom: 1px solid black;">
                    <th>Image</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Price</th>
                </tr>`;
    $.each(order.products, function (key, product) {
        html += `<tr>
                     <td>
                         <img height="100" width="100"
                         src="storage/images/${product.id}.${product.extension}"/>
                     </td>
                     <td> ${ product.title }</td>
                     <td> ${ product.description }</td>
                     <td> ${ product.pivot.product_price }$</td>
                 </tr>`;
    });
    html += `</table>`;
    html += `<br>
             <h2>Total: ${ order.total}$</h2>
             <a href="#orders" class="button-products">trans('buttons.orders')</a>`;
    return html;
}
