<template>
    <div class="row border-bottom">
        <div class="col-lg-8">
            <h3>👋 Introduction to API</h3>
        </div>

        <div class="col-lg-4 desktop-only" align="right">
            <div class="pt-2">
                <a href="https://github.com/nthnn/QLBase/blob/main/documentations/src/views/IntroToAPI.vue"
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

    <p class="mt-2">QLBase, an open-source decentralized backend solution and this section provides a practical insight into QLBase's functionality and APIs, to showcase its versatility for developers in the software development sphere. Beyond a conventional backend, QLBase stands out as a dynamic toolkit, addressing various facets of application development.</p>

    <h3 class="border-bottom">🚥 HTTP Headers</h3>
    <p>Do not forget to include the QLBase app's API key and ID to HTTP headers in your requests to authenticate and authorize the API calls:</p>
    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"QLBase-API-Key"</span>: <span class="text-danger">"&lt;API key&gt;"</span>,
    <span class="text-warning">"QLBase-App-ID"</span>: <span class="text-danger">"&lt;API ID&gt;"</span>
<span class="text-primary">}</span></pre>

    <h3 class="border-bottom">📩 API Responses</h3>
    <p>Every response from QLBase's API gateway includes a JSON key named <span class="bg-secondary border-gray border rounded p-1 d-inline">result</span> with a value of either <span class="bg-secondary border-gray border rounded p-1 d-inline">0</span> or <span class="bg-secondary border-gray border rounded p-1 d-inline">1</span>, indicating the success of the request processing. In the event that the <span class="bg-secondary border-gray border rounded p-1 d-inline">result</span> value is <span class="bg-secondary border-gray border rounded p-1 d-inline">0</span>, an additional key named <span class="bg-secondary border-gray border rounded p-1 d-inline">message</span> will be present, containing the error message.</p>
    <p>Below is an example of error response from an API call:</p>
    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"result"</span>: <span class="text-danger">"0"</span>,
    <span class="text-warning">"message"</span>: <span class="text-danger">"Insufficient parameter arity."</span>
<span class="text-primary">}</span></pre>

    <h3 class="border-bottom">📱 Services</h3>
    <p>The section delves into QLBase's strengths in user account authentication, ensuring a secure foundation for managing accounts. The integration of SMS verification through OTP adds an extra layer of security to the user authentication process. QLBase's data analytics features come to the forefront, equipping developers with tools for streamlined data identification and manipulation. Database storage is made more accessible through QLBase's scalable solution, complemented by the file storage API that simplifies the management of files within applications.</p>
    <p>This section serves as a practical guide, elucidating QLBase's role as a flexible backend solution designed to meet the diverse needs of application development.</p>

    <h4 class="border-bottom">🔐 Authentication</h4>
    <p>QLBase provides a robust authentication system that allows you to create, retrieve, update, and delete user accounts securely.</p>
    <ul>
        <li>
            <b>User Registration</b>
            <p>Developers can easily integrate user registration, defining the necessary fields for user creation. This flexibility ensures that the registration process aligns with the unique needs of the application.</p>
        </li>
        <li>
            <b>Login and Authentication</b>
            <p>Users can securely log in using their credentials, with support for diverse authentication mechanisms. This ensures accessibility and convenience for users while maintaining the necessary security measures.</p>
        </li>
        <li>
            <b>Account Enabling/Disabling</b>
            <p>You can disable and enable user accounts as needed. When an account is disabled, the user cannot log in until it's enabled again. This feature is particularly useful for handling suspicious or inactive accounts.</p>
        </li>
        <li>
            <b>Updating and Deleting Accounts</b>
            <p>In QLBase, you can update user account details or delete accounts efficiently using either the user's username or email. This provides flexibility in managing user information based on the application's evolving requirements.</p></li>
        <li>
            <b>Account Fetching</b>
            <p>Flexibility in fetching user accounts; by specified username or email. Additionally, QLBase supports fetching all user information in a single request, providing a comprehensive overview of user accounts when needed.</p>
        </li>
    </ul>

    <h4 class="border-bottom">✉️ SMS Verification</h4>
    <p>Easily integrate SMS verification into your application using QLBase's OTP service. Protect your user accounts with one-time passwords sent via SMS. QLBase provides SMS verification functionality using an Arduino UNO with a SIM900 Shield as the underlying SMS hardware. This setup allows you to seamlessly integrate SMS verification into your application for added security. </p>
    <ul>
        <li>
            <b>OTP Generation</b>
            <p>Utilizing the Arduino UNO with the SIM900 Shield, QLBase facilitates the secure generation of unique six-digit OTPs, ensuring a robust mechanism for user verification.</p>
        </li>
        <li>
            <b>SMS Delivery</b>
            <p>The integration with Arduino's SIM900 allows QLBase to send SMS messages efficiently, providing users with the necessary OTP for verification purposes. Including support contact details adds an extra layer of assistance.</p>
        </li>
        <li>
            <b>Verification Endpoint</b>
            <p>Users can interact with the verification endpoint, providing the OTP received via SMS to confirm their phone numbers. This API-driven verification process enhances the user experience by integrating with your application's workflows.</p>
        </li>
    </ul>

    <h4 class="border-bottom">📊 Data Analytics</h4>
    <p>QLBase includes powerful data analytics capabilities such as track identification, general tracking with event name and JSON payloads, page tracking with a specified page name and category, and making alias for users and anonymous users.</p>
    <ul>
        <li>
            <b>Identification Trackers</b>
            <p>QLBase provides robust features for precise data identification, allowing you to associate user actions with specific individuals or anonymous IDs.</p>
        </li>
        <li>
            <b>General Analytics Tracking</b>
            <p>The data tracking feature captures a variety of user interactions, encompassing general tracking with event names and JSON payloads. This allows you to monitor specific events or actions performed by users, along with additional data payloads for more contextual information.</p>
        </li>
        <li>
            <b>Tracker Paging</b>
            <p>Paged tracking incorporates efficient data paging mechanisms, addressing the challenges associated with handling large datasets without compromising performance and is crucial for applications dealing with substantial datasets, preventing performance bottlenecks and enhancing user experience.</p>
        </li>
        <li>
            <b>Anonymous Users and Aliasing</b>
            <p>Data analytics and tracking also facilitates aliasing for both registered users and anonymous users, allowing you to create alternative identifiers or pseudonyms for them.</p>
        </li>
    </ul>

    <h4 class="border-bottom">🗃️ Database System</h4>
    <p>QLBase offers a comprehensive database storage solution designed to meet the needs of modern applications. With its scalable and reliable architecture, QLBase provides users with robust data management capabilities, leveraging MySQL as the internal database engine.</p>
    <ul>
        <li>
            <b>CRUD Operations</b>
            <p>QLBase supports essential CRUD (Create, Read, Update, Delete) operations, empowering users to manage their data efficiently within the MySQL database.</p>
        </li>
        <li>
            <b>Scalability</b>
            <p>QLBase's database storage is designed to scale seamlessly as data volumes grow within the MySQL environment, accommodating growing datasets without sacrificing performance or reliability.</p>
        </li>
        <li>
            <b>Inter-API Communication</b>
            <p>The API provided by QLBase exposes data in JSON format, allowing seamless integration with client applications. This JSON-based API simplifies data exchange and enables interoperability with a wide range of programming languages and platforms.</p>
        </li>
    </ul>

    <h4 class="border-bottom">☁️ Cloud Storage</h4>
    <p>QLBase incorporates a sophisticated cloud file storage system designed to streamline file management tasks within your application. With its cloud-based architecture, QLBase offers a reliable and scalable solution for storing and accessing files securely.</p>
    <ul>
        <li>
            <b>File Uploads</b>
            <p>QLBase simplifies the process of uploading files, allowing users to effortlessly upload various types of files, including images, documents, and media.</p>
        </li>
        <li>
            <b>File Retrieval</b>
            <p>Retrieve files securely using unique file identifiers generated by QLBase. With robust file retrieval capabilities, users can easily access uploaded files whenever needed, ensuring seamless integration with client applications and efficient file management workflows.</p>
        </li>
        <li>
            <b>Reliability</b>
            <p>QLBase leverages cloud infrastructure to provide scalable and reliable file storage capabilities. By utilizing cloud services, QLBase ensures that your application can handle growing volumes of files without compromising performance or reliability.</p>
        </li>
        <li>
            <b>Data Security and Compliance</b>
            <p>Security is paramount when it comes to file storage, and QLBase prioritizes data security and compliance with industry standards. QLBase employs robust encryption mechanisms to safeguard files at rest, ensuring that sensitive data remains protected against unauthorized access.</p>
        </li>
    </ul>

    <hr/>
    <div class="row">
        <div class="col-6">
            <RouterLink to="/contrib" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-right mb-1" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                    <path fill-rule="evenodd" d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                </svg>

                Contributing and Contributors
            </RouterLink>
        </div>

        <div class="col-6">
            <div align="right">
                <RouterLink to="/authentication" class="btn btn-primary">
                    Authentication

                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-right mb-1" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708z"/>
                        <path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708z"/>
                    </svg>
                </RouterLink>
            </div>
        </div>
    </div>
</template>