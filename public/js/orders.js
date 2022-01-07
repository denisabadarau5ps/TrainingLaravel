/**
 *  A function that takes an orders array and renders it's html
 * @param orders
 * @returns {string}
 */
function renderOrders(orders) {
    let html = `<tr>
                    <th>${trans('orders.no')}</th>
                    <th>${trans('orders.name')}</th>
                    <th>${trans('orders.contact')}</th>
                    <th>${trans('orders.comments')}</th>
                    <th>${trans('orders.price')}</th>
                </tr>`;
    $.each(orders, function (key, order) {
        html += ` <tr>
                      <td>
                          <a href="#order/${order.id}">${order.id}</a>
                      </td>
                      <td> ${order.customer.name} </td>
                      <td> ${order.customer.contacts} </td>
                      <td> ${order.customer.comments} </td>
                      <td> ${order.total} $ </td>
                  </tr>`;
    });
    return html;
}
