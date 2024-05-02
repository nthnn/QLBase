<template>
    <h3 class="border-bottom">📊 Data Analytics</h3>
    <p>QLBase includes powerful data analytics capabilities such as track identification, general tracking with event name and JSON payloads, page tracking with a specified page name and category, and making alias for users and anonymous users.</p>

    <div class="row">
        <div class="col-lg-6 col-md-6">
            <img src="@/assets/qlbase-cat-5.png" width="100%" />
        </div>

        <div class="col-lg-6 col-md-6">
            <br class="desktop-only" />
            <ol>
                <li><b>Identification Trackers:</b> QLBase provides robust features for precise data identification, allowing you to associate user actions with specific individuals or anonymous IDs.</li>
                <li><b>General Analytics Tracking:</b> The data tracking feature captures a variety of user interactions, encompassing general tracking with event names and JSON payloads. This allows you to monitor specific events or actions performed by users, along with additional data payloads for more contextual information.</li>
            </ol>
        </div>
    </div>

    <ol start="3">
        <li><b>Tracker Paging:</b> Paged tracking incorporates efficient data paging mechanisms, addressing the challenges associated with handling large datasets without compromising performance and is crucial for applications dealing with substantial datasets, preventing performance bottlenecks and enhancing user experience.</li>
        <li><b>Anonymous Users and Aliasing:</b> Data analytics and tracking also facilitates aliasing for both registered users and anonymous users, allowing you to create alternative identifiers or pseudonyms for them.</li>
    </ol>
    <br/>

    <h4 class="border-bottom">📡 Authentication API Calls</h4>
    <hr/>
    <div class="row">
        <div class="col-6">
            <RouterLink to="/sms-verification" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-right mb-1" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                    <path fill-rule="evenodd" d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                </svg>

                SMS Verficiation
            </RouterLink>
        </div>

        <div class="col-6">
            <div align="right">
                <RouterLink to="/database" class="btn btn-primary">
                    Database

                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-right mb-1" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708z"/>
                        <path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708z"/>
                    </svg>
                </RouterLink>
            </div>
        </div>
    </div>
</template>