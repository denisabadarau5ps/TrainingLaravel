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
    let html = renderHeader();

    $.each(products, function (key, product) {
        html += renderProductsDetails(product);
        html += ` <td>
                      <a href="#${product.id}" class="button-products">${trans('buttons.add')}</a>
                   <td>
              </tr>`;
    });
    return html;
}
