/**
 * A function that renders the header for products table
 * @returns {string}
 */
function renderHeader() {
    let html = `
                    <tr>
                        <th>${trans('product.image')}</th>
                        <th>${trans('product.title')}</th>
                        <th>${trans('product.desc')}</th>
                        <th>${trans('product.price')}</th>
                        <th>${trans('product.options')}</th>
                    </tr>
              `;
    return html;
}

/**
 * A function that renders product details
 * @param product
 * @returns {string}
 */
function renderProductsDetails(product) {
    let html = `
                    <tr>
                         <td>
                             <img height="100" width="100"
                             src="storage/images/${product.id}.${product.extension}"
                             alt=${trans('product.image')}/>
                         </td>
                         <td> ${product.title} </td>
                         <td> ${product.description} </td>
                         <td> ${product.price} $ </td>
                   `;
    return html;
}

function trans(key, replace = {}) {
    var translation = key.split('.').reduce((t, i) => t[i] || null, window.translations);
    for (var placeholder in replace) {
        translation = translation.replace(`:${placeholder}`, replace[placeholder]);
    }
    return translation;
}

function escapeHtml(unsafe)
{
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

function getCurrentPage() {
    return ((window.location.hash.split('?') || [])[1]?.split('&')?.find((it) => it.match('page='))?.split('=') || [])[1] || 1
}
