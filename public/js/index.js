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
function renderList(products, { current_page, last_page}) {
    let html = `<theader>
                        <tr>
                            <th>${trans('product.image')}</th>
                            <th>${trans('product.title')}</th>
                            <th>${trans('product.desc')}</th>
                            <th>${trans('product.price')}</th>
                            <th>${trans('product.options')}</th>
                        </tr>
                </theader>`;

    html += `<tbody id="bd">`;
    $.each(products, function (key, product) {
        html += `
                    <tr>
                         <td>
                             <img height="100" width="100"
                             src="storage/images/${product.id}.${product.extension}"
                             alt=${trans('product.image')}/>
                         </td>
                         <td> ${product.title} </td>
                         <td> ${product.description} </td>
                         <td> ${product.price} $ </td>
                          <td>
                      <a href="#${product.id}" class="button-products">${trans('buttons.add')}</a>
                   <td>
              </tr>`;

    });
    html += `</tbody>`;
    const lastPageDisabled = current_page >= last_page ? 'disabled' : '';
    const firstPageDisabled = current_page <= 1 ? 'disabled' : '';
    html +=`
    <button onclick="goToIndexPage(1)" ${firstPageDisabled}>&lt;&lt;</button>
    <button onclick="goToIndexPage(${current_page} - 1)" ${firstPageDisabled}>&lt;</button>
    ${getPaginationArray(current_page, 5, last_page)
        .map(pageNum => `<button onclick="goToIndexPage(${pageNum})" ${current_page === pageNum ? 'disabled' : ''}>${pageNum}</button>`)
        .join('')}
    <button onclick="goToIndexPage(${current_page} + 1)" ${lastPageDisabled}>&gt;</button>
    <button onclick="goToIndexPage(${last_page})" ${lastPageDisabled}>&gt;&gt;</button>
    `;
    return html;
}

function goToIndexPage(page) {
    window.location.hash = `#?page=${page}`;
}

function getPaginationArray(page, size, total) {
    const start = Math.max(page - size, 1);
    return Array(Math.min(size, total)).fill(0).map((it, index) => index + start);
}
