<template>
    <div class="row border-bottom">
        <div class="col-lg-8">
            <h1>🔐 Authentication</h1>
        </div>

        <div class="col-lg-4 desktop-only" align="right">
            <div class="pt-4">
                <a href="https://github.com/nthnn/QLBase/blob/main/documentations/src/views/Authentication.vue"
                    target="_blank" class="text-decoration-none">
                    <span style="margin-top: 2px !important; display: flex; float: right">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-github" viewBox="0 0 16 16">
                            <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27s1.36.09 2 .27c1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.01 8.01 0 0 0 16 8c0-4.42-3.58-8-8-8"/>
                        </svg>
                    </span>
                    <span class="float-right d-inline mx-2">Edit this on GitHub</span>
                </a>
            </div>
        </div>
    </div>

    <p class="mt-2">QLBase provides a robust authentication system designed to empower you in managing user accounts securely. Within this service, a range of APIs is offered to facilitate the following key functionalities:</p>

    <div class="row">
        <div class="col-lg-6 col-md-6">
            <img src="@/assets/qlbase-cat-3.png" width="100%" />
        </div>

        <div class="col-lg-6 col-md-6">
            <br class="desktop-only" />
            <ol>
                <li><b>User Registration:</b> Effortlessly register new users with customizable registration fields. QLBase streamlines the process, allowing you to tailor registration fields to meet specific application requirements.</li>
                <li><b>Secure User Login:</b> Ensure secure user logins by supporting various authentication methods, including traditional username/password combinations and the convenience of social logins. This flexibility caters to diverse user preferences, enhancing the overall user experience.</li>
            </ol>
        </div>
    </div>

    <ol start="3">
        <li><b>Account Management:</b> QLBase provides the capability to disable and enable user accounts as needed. When an account is disabled, the user is temporarily restricted from logging in until reenabled. This feature proves particularly valuable for handling suspicious or inactive accounts, offering a proactive approach to account security.</li>
        <li><b>Expanded Functionality:</b> Beyond the mentioned features, QLBase have varieties of action within its authentication-related APIs. These actions are designed to provide a comprehensive and adaptable toolkit, allowing developers to address specific use cases and tailor authentication processes according to their application's unique requirements.</li>
    </ol>
    <br/>

    <h4 class="border-bottom">📡 Authentication API Calls</h4>

    <b class="mt-4 mb-2 d-block border-bottom fw-bold">Auth New User</b>
    <p>Create a new user on account list of specified QLBase application key and ID.</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=new_user</pre>

    <p>Payload Structure:</p>
    <ul>
        <li><i>username</i> &mdash; The desired username for the new account.</li>
        <li><i>email</i> &mdash; The email address associated with the new account.</li>
        <li><i>password</i> &mdash; The MD5 hashed string of the user's chosen password.</li>
        <li><i>enabled</i> &mdash; A binary flag (0 or 1) indicating whether the account should be enabled (1) or disabled (0).</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"username"</span>: <span class="text-danger">"&lt;username&gt;"</span>,
    <span class="text-warning">"email"</span>: <span class="text-danger">"&lt;email&gt;"</span>,
    <span class="text-warning">"password"</span>: <span class="text-danger">"&lt;MD5 hashed string&gt;"</span>,
    <span class="text-warning">"enabled"</span>: <span class="text-danger">"0|1"</span>
<span class="text-primary">}</span></pre>

    <b class="mt-4 mb-2 d-block border-bottom fw-bold">Auth Update by Username</b>
    <p>Update QLBase application account informations by username of user.</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=update_by_username</pre>

    <p>Payload Structure</p>
    <ul>
        <li><i>username</i> &mdash; The username of the account to be updated.</li>
        <li><i>email</i> &mdash; The updated/new email address of the user to be updated.</li>
        <li><i>password</i> &mdash; The updated/new password hashed in MD5 encryption of the user to be updated.</li>
        <li><i>enabled</i> &mdash; A binary flag (0 or 1) indicating whether the account should be enabled (1) or disabled (0).</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"username"</span>: <span class="text-danger">"&lt;username&gt;"</span>,
    <span class="text-warning">"email"</span>: <span class="text-danger">"&lt;email&gt;"</span>,
    <span class="text-warning">"password"</span>: <span class="text-danger">"&lt;MD5 hashed string&gt;"</span>,
    <span class="text-warning">"enabled"</span>: <span class="text-danger">"0|1"</span>
<span class="text-primary">}</span></pre>

    <b class="mt-4 mb-2 d-block border-bottom fw-bold">Auth Update by Email</b>
    <p>Update QLBase application account information by email of user.</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=update_by_email</pre>

    <p>Payload Structure</p>
    <ul>
        <li><i>username</i> &mdash; The updated/new username of the account to be updated.</li>
        <li><i>email</i> &mdash; The email address of the user to be updated.</li>
        <li><i>password</i> &mdash; The updated/new password hashed in MD5 encryption of the user to be updated.</li>
        <li><i>enabled</i> &mdash; A binary flag (0 or 1) indicating whether the account should be enabled (1) or disabled (0).</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"username"</span>: <span class="text-danger">"&lt;username&gt;"</span>,
    <span class="text-warning">"email"</span>: <span class="text-danger">"&lt;email&gt;"</span>,
    <span class="text-warning">"password"</span>: <span class="text-danger">"&lt;MD5 hashed string&gt;"</span>,
    <span class="text-warning">"enabled"</span>: <span class="text-danger">"0|1"</span>
<span class="text-primary">}</span></pre>

    <b class="mt-4 mb-2 d-block border-bottom fw-bold">Auth Delete by Username</b>
    <p>Delete QLBase application account information by username of user.</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=delete_by_username</pre>

    <b>Payload Structure</b>
    <ul>
        <li><i>username</i> &mdash; The username of the account to be deleted.</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"username"</span>: <span class="text-danger">"&lt;username&gt;"</span>
<span class="text-primary">}</span></pre>

    <b class="mt-4 mb-2 d-block border-bottom fw-bold">Auth Delete by Email</b>
    <p>Delete QLBase application account information by email of user.</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=delete_by_email</pre>

    <b>Payload Structure</b>
    <ul>
        <li><i>email</i> &mdash; The email of the account to be deleted.</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"email"</span>: <span class="text-danger">"&lt;email&gt;"</span>
<span class="text-primary">}</span></pre>

    <b class="mt-4 mb-2 d-block border-bottom fw-bold">Auth Get by Username</b>
    <p>Fetch QLBase application account informations specified by username of user.</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=get_by_username</pre>

    <b>Payload Structure</b>
    <ul>
        <li><i>username</i> &mdash; The username of the account to be fetched.</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"username"</span>: <span class="text-danger">"&lt;username&gt;"</span>
<span class="text-primary">}</span></pre>

    <b>Response Data</b>
    <ul>
        <li><i>email</i> &mdash; The email of the fetched user account.</li>
        <li><i>enabled</i> &mdash; Boolean value (either 0 or 1) that indicates if the account is enabled.</li>
        <li><i>last_modified</i> &mdash; Last modified date and time of the account in <span class="bg-secondary border-gray border rounded p-1 d-inline">yyyy-mm-dd hh:mm:ss</span> format.</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"result"</span>: <span class="text-danger">"1"</span>,
    <span class="text-warning">"value"</span>: <span class="text-primary">[</span>
        <span class="text-danger">"&lt;email&gt;"</span>,
        <span class="text-danger">"&lt;enabled&gt;"</span>
        <span class="text-danger">"&lt;last_modified&gt;"</span>
    <span class="text-primary">]</span>
<span class="text-primary">}</span></pre>

    <b class="mt-4 mb-2 d-block border-bottom fw-bold">Auth Get by Email</b>
    <p>Fetch QLBase application account informations specified by email of user.</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=get_by_email</pre>

    <b>Payload Structure</b>
    <ul>
        <li><i>email</i> &mdash; The email of the account to be fetched.</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"email"</span>: <span class="text-danger">"&lt;email&gt;"</span>
<span class="text-primary">}</span></pre>

    <b>Response Data</b>
    <ul>
        <li><i>username</i> &mdash; The username of the fetched user account.</li>
        <li><i>enabled</i> &mdash; Boolean value (either 0 or 1) that indicates if the account is enabled.</li>
        <li><i>last_modified</i> &mdash; Last modified date and time of the account in <span class="bg-secondary border-gray border rounded p-1 d-inline">yyyy-mm-dd hh:mm:ss</span> format.</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"result"</span>: <span class="text-danger">"1"</span>,
    <span class="text-warning">"value"</span>: <span class="text-primary">[</span>
        <span class="text-danger">"&lt;username&gt;"</span>,
        <span class="text-danger">"&lt;enabled&gt;"</span>
        <span class="text-danger">"&lt;last_modified&gt;"</span>
    <span class="text-primary">]</span>
<span class="text-primary">}</span></pre>

    <b class="mt-4 mb-2 d-block border-bottom fw-bold">Auth Enable User</b>
    <p>Enable specified QLBase application user account.</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=enable_user</pre>

    <b>Payload Structure</b>
    <ul>
        <li><i>username</i> &mdash; The username of the account to be enabled.</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"username"</span>: <span class="text-danger">"&lt;username&gt;"</span>
<span class="text-primary">}</span></pre>

    <b class="mt-4 mb-2 d-block border-bottom fw-bold">Auth Disable User</b>
    <p>Disable specified QLBase application user account.</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=disable_user</pre>

    <b>Payload Structure</b>
    <ul>
        <li><i>username</i> &mdash; The username of the account to be disabled.</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"username"</span>: <span class="text-danger">"&lt;username&gt;"</span>
<span class="text-primary">}</span></pre>

    <b class="mt-4 mb-2 d-block border-bottom fw-bold">Auth Is User Enabled</b>
    <p>Check if the specified QLBase application user account is either enabled or disabled.</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=is_user_enabled</pre>

    <b>Payload Structure</b>
    <ul>
        <li><i>username</i> &mdash; The username of the account to be check if enabled.</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"username"</span>: <span class="text-danger">"&lt;username&gt;"</span>
<span class="text-primary">}</span></pre>

    <b>Response Data</b>
    <ul>
        <li><i>enabled</i> &mdash; Boolean value (either 0 or 1) that indicates if the account is enabled.</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"result"</span>: <span class="text-danger">"1"</span>,
    <span class="text-warning">"value"</span>: <span class="text-danger">"&lt;enabled&gt;"</span>,
<span class="text-primary">}</span></pre>

    <b class="mt-4 mb-2 d-block border-bottom fw-bold">Auth Login Username</b>
    <p>Log-in a specified QLBase application user account using username and an MD5-hashed password string.</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=login_username</pre>

    <b>Payload Structure</b>
    <ul>
        <li><i>username</i> &mdash; The username of the account to be logged in.</li>
        <li><i>password</i> &mdash; The MD5 hashed password string of the account to be logged in.</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"username"</span>: <span class="text-danger">"&lt;username&gt;"</span>,
    <span class="text-warning">"password"</span>: <span class="text-danger">"&lt;password&gt;"</span>
<span class="text-primary">}</span></pre>

    <b>Response Data</b>
    <ul>
        <li><i>logged_in</i> &mdash; Boolean value (either 0 or 1) that indicates if the account was successfully logged in.</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"result"</span>: <span class="text-danger">"1"</span>,
    <span class="text-warning">"value"</span>: <span class="text-danger">"&lt;logged_in&gt;"</span>
<span class="text-primary">}</span></pre>

    <b class="mt-4 mb-2 d-block border-bottom fw-bold">Auth Login Email</b>
    <p>Log-in a specified QLBase application user account using email and an MD5-hashed password string.</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=login_email</pre>

    <b>Payload Structure</b>
    <ul>
        <li><i>email</i> &mdash; The email of the account to be logged in.</li>
        <li><i>password</i> &mdash; The MD5 hashed password string of the account to be logged in.</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"email"</span>: <span class="text-danger">"&lt;email&gt;"</span>,
    <span class="text-warning">"password"</span>: <span class="text-danger">"&lt;password&gt;"</span>
<span class="text-primary">}</span></pre>

    <b>Response Data</b>
    <ul>
        <li><i>logged_in</i> &mdash; Boolean value (either 0 or 1) that indicates if the account was successfully logged in.</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"result"</span>: <span class="text-danger">"1"</span>,
    <span class="text-warning">"value"</span>: <span class="text-danger">"&lt;logged_in&gt;"</span>
<span class="text-primary">}</span></pre>

<b class="mt-4 mb-2 d-block border-bottom fw-bold">Auth Fetch All Users</b>
    <p>Fetch all the QLBase application user informations including username, email, enability, and timestamp of creation.</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=fetch_all_users</pre>

    <b>Example Payload</b>
    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{}</span></pre>

    <b>Response Data</b>
    <ul>
        <li>
            <i>value</i> &mdash; This key will contain a 2D array of users that contains arrays of user informations. The user information order is as the following table below:
            <table class="table table-hover">
                <tr>
                    <th>Array Index</th>
                    <th>Index Content</th>
                </tr>
                <tr>
                    <td>0</td>
                    <td>Username of the account</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Email of the user account</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Boolean value to represent if the account is either enabled or disabled.</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Timestamp of the account creation with the format &quot;<i>YYYY-mm-dd hh:mm:ss</i>&quot;</td>
                </tr>
            </table>
        </li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"result"</span>: <span class="text-danger">"1"</span>,
    <span class="text-warning">"value"</span>: <span class="text-primary">[</span>...<span class="text-primary">]</span>
<span class="text-primary">}</span></pre>

    <hr/>
    <div class="row">
        <div class="col-6">
            <RouterLink to="/intro-api" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-right mb-1" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                    <path fill-rule="evenodd" d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                </svg>

                Introduction to APIs
            </RouterLink>
        </div>

        <div class="col-6">
            <div align="right">
                <RouterLink to="/sms-verification" class="btn btn-primary">
                    SMS Verification

                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-right mb-1" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708z"/>
                        <path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708z"/>
                    </svg>
                </RouterLink>
            </div>
        </div>
    </div>
</template>