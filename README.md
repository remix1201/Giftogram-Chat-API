# Giftogram Chat API

## Name: Ross Baker

### Duration: ~3.5 hours (hand-coded and added an API test page for fun!)

### Notes:

1. Document root should be `src`.
2. API Test page `src/test/index.html`.
3. Password for each user is `test`.
4. Please modify `APP.local.apiPath` in `src/test/app.local.js` to reflect your API endpoint. _This would not typically be included in favor of `app.local.js.example` but for this test I've made an exception._
5. `GET` requests should not contain a request body (According to the HTTP/1.1 specification). I've used query parameters to achieve the desired result while using GET requests for endpoints `/view_messages` and `/list_all_users` as requested.

### General steps:

1. Review requirements
2. Setup environment (MAMP Pro, Apache 2.4.54, PHP 8.3, MySQL 5.7.39).
3. Created project directory structure and editor (VSCode).
4. Design database schema and access (phpMyAdmin / MySQLWorkbench).
5. Create config for db connection (`config/database.php`).
6. Define root path constant for ease of use (`config/config.php`).
7. Create models for interacting with db (`app/models/UserModel.php`, `app/models/MessageModel.php`).
8. Create controllers to handle business logic and interact with models (`app/controllers/UserController.php`, `app/controllers/MessageController.php`).
9. Create validation classes (`app/helpers/Validator.php`).
10. Create response view classes (`app/views/ResponseView.php`).
11. Create router classes to direct HTTP requests to the appropriate controller methods (`app/core/Router.php`).
12. Create .htaccess file in the src directory to handle URL rewriting (`src/.htaccess`).
13. Create endpoint (`src/index.php`).
14. Testing / Bonus: Create a simple frontend for testing the API (`src/test/index.html`) and reset `RewriteEngine` in `.htaccess` since I added test as subfolder in `src`.
15. Fix issues as needed, rinse, and repeat.
16. Create `readme.md` and `.gitignore`.
17. Export database.
18. Create GitHub repo, commit, and send off!

### Issues and Future Improvements:

1. Implement server environment variables to protect sensitive credentials.
2. Implement session management for logged in state / message sending.
3. Implement CORS if the API will be accessed from different origins.
4. Implement CSRF tokens for Registering or sending messages to protect against Cross-Site Request Forgery attacks.
5. Implement rate limiting on the API endpoints.
6. Implement password strength validation at registration.
7. Implement authentication or authorization mechanism for API endpoints.
8. Implement additional metadata, like timestamps and request IDs for better traceability and debugging.
9. Implement paging for responses to improve the usability and performance.
10. Implement websockets for realtime chat (actually build chat app front end).
11. While this API provides a functional approach to handling specific actions it aligns more closely with RPC API style rather than a truly RESTful API. I aligned the error_code in the json response with the closest corresponding http status code to align better with RESTful principles.
12. Version the API since it is RPC based and changes will often be breaking instead of representational.
13. I don't typically like to use verbs in the endpoint. I prefer that the HTTP method is the verb representing the action and the URL is a noun representing the resource. Example: `POST users` instead of `/register`.
14. I'm limited by time here.. :upside_down_face:
