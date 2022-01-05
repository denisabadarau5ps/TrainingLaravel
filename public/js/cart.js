/**
 * A function that takes the cart array and renders it's html and renders checkout form too
 * @param products
 * @returns {*|string}
 */
function renderCart(products) {
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
                        <a href="#cart/${product.id}" class="button-products">trans('buttons.remove')</a>
                    <td>
                </tr>`;
    });
    htmlForm = `<input type="text" id="name" name="name"
                 placeholder="trans('customer.name')" >
                 <br>
                 <span class="errors" id="nameErrorMsg"></span>
                 <br>
                 <input type="email" id="contacts" name="contacts"
                 placeholder="trans('customer.contacts')" >
                 <br>
                 <span class="errors" id="contactsErrorMsg"></span>
                 <br>
                 <textarea id="comments" name="comments" rows="5"
                 placeholder="trans('customer.comments')"></textarea>
                 <br>
                 <span class="errors" id="commentsErrorMsg"></span>
                 <br>
                 <input type="submit" name="checkout" value="trans('buttons.checkout')">`;
    if(products.length !== 0) {
        $('.cart .checkout').html(htmlForm);
    }
    return html;
}
