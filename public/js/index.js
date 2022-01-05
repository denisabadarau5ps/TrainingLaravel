/**
 * A function that takes a products array and renders it's html
 *
 * The products array must be in the form of
 * [{
 *     "title": "Product 1 title",
 *     "description": "Product 1 desc",
 *     "price": 1
 * },{
 *     "title": "Product 2 title",
 *     "description": "Product 2 desc",
 *     "price": 2
 * }]
 */
function renderList(products) {
    let html = `<tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Options</th>
                </tr>`;
    $.each(products, function (key, product) {
        html += `<tr>
                     <td>
                         <img height="100" width="100"
                         src="storage/images/${product.id}.${product.extension}"/>
                     </td>
                     <td> ${product.title} </td>
                     <td> ${product.description} </td>
                     <td> ${product.price} $ </td>
                     <td>
                         <a href="#${product.id}" class="button-products">trans('buttons.add')</a>
                     <td>
                 </tr>`;
    });
    return html;
}
