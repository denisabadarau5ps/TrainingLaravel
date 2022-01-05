/**
 * A function that render all products from products table
 * @param products
 * @returns {string}
 */
function renderProducts(products) {
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
                         <a href="#products/${product.id}" class="button-products">trans('buttons.delete')</a>
                         <a href="#product/${product.id}" class="button-products">trans('buttons.edit')</a>
                     <td>
                </tr>`;
    });
    return html;
}
