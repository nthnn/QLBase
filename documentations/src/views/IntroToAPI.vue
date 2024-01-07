<template>
    <h3 class="border-bottom">👋 Introduction to API</h3>
    <p>QLBase, an open-source decentralized backend solution and this section provides a practical insight into QLBase's functionality and APIs, to showcase its versatility for developers in the software development sphere. Beyond a conventional backend, QLBase stands out as a dynamic toolkit, addressing various facets of application development.</p>

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