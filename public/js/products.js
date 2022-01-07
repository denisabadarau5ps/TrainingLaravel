/**
 * A function that render all products from products table
 * @param products
 * @returns {string}
 */
function renderProducts(products) {
    let html = renderHeader();

    $.each(products, function (key, product) {
        html += renderProductsDetails(product);
        html += `<td>
                     <a href="#products/${product.id}" class="button-products">${trans('buttons.delete')}</a>
                     <a href="#product/${product.id}" class="button-products">${trans('buttons.edit')}</a>
                 <td>
            </tr>`;
    });
    return html;
}
