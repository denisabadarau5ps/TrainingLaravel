/**
 * A function that render login form for admin
 * @returns {string}
 */
function login() {
    let html = `<h1>${trans('login.login')}</h1>
                <label for="username">${trans('login.username')} </label>
                <input type="text" id="username" name="username">
                <br>
                <span class="errors" id="usernameErrorMsg"></span>
                <br>
                <label for="password">${trans('login.password')} </label>
                <input type="password" name="password" id="password">
                <br>
                <span class="errors" id="passwordErrorMsg"></span>
                <br>
                <input type="submit" name="login" value=${trans('buttons.login')}>`;
    return html;
}
