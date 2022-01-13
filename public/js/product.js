/**
 * A function that render edit/add product form
 * @returns {string}
 */

function renderProductForm(product) {
    product = product || {};
    let html = `<h1>${trans('general.product')}</h1>
                <input type="text" id="title" placeholder=${trans('product.title')} value="${escapeHtml(product.title || '')}" >
                <br>
                <span class="errors" id="titleErrorMsg"></span>
                <br>
                <textarea id="description" placeholder=${trans('product.desc')}>${escapeHtml(product.description || '')}</textarea>
                <br>
                <span class="errors" id="descErrorMsg"></span>
                <br>
                <input type="number" id="price" placeholder=${trans('product.price')} value="${escapeHtml(product.price || '')}">
                <br>
                <span class="errors" id="priceErrorMsg"></span>
                <br>
                <input type="file" id="fileToUpload" style="margin-left: 20%;">
                <br>
                <span class="errors" id="fileErrorMsg"></span>
                <br>
                <input type="submit" name="save" value=${trans('buttons.save')}> <br><br>`;
    return html;
}
