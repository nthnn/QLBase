<template>
    <h3 class="border-bottom">🔐 Authentication</h3>
    <p>QLBase provides a robust authentication system designed to empower you in managing user accounts securely. Within this service, a range of APIs is offered to facilitate the following key functionalities:</p>

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

    <h4 class="border-bottom">🧾 Creating User Accounts</h4>
    <p>To register a new user account in the QLBase app, you can utilize the dedicated API endpoint. The following comprehensive guide walks you through the process, providing details on the target URL, payload structure, example response, and required HTTP headers.</p>

    <b>Action URL</b>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=new_user</pre>

    <b>Payload Structure</b>
    <p>To create a new user, you need to provide a JSON payload with the following fields:</p>
    <ul>
        <li><b>username</b> &mdash; The desired username for the new account.</li>
        <li><b>email</b> &mdash; The email address associated with the new account.</li>
        <li><b>password</b> &mdash; The MD5 hashed string of the user's chosen password.</li>
        <li><b>enabled</b> &mdash; A binary flag (0 or 1) indicating whether the account should be enabled (1) or disabled (0).</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"username"</span>: <span class="text-danger">"&lt;username&gt;"</span>,
    <span class="text-warning">"email"</span>: <span class="text-danger">"&lt;email&gt;"</span>,
    <span class="text-warning">"password"</span>: <span class="text-danger">"&lt;MD5 hashed string&gt;"</span>,
    <span class="text-warning">"enabled"</span>: <span class="text-danger">"0|1"</span>
<span class="text-primary">}</span></pre>

    <b>Example Response</b>
    <p>Upon successful registration, the API will return a JSON response with a result key indicating the success status:</p>
    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"result"</span>: <span class="text-danger">"1"</span>,
    <span class="text-muted">// Successfully registered!</span>
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