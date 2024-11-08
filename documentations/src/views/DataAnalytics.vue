<template>
    <div class="row border-bottom">
        <div class="col-lg-8">
            <h3>📊 Data Analytics</h3>
        </div>

        <div class="col-lg-4 desktop-only" align="right">
            <div class="pt-2">
                <a href="https://github.com/nthnn/QLBase/blob/main/documentations/src/views/DataAnalytics.vue"
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

    <p class="mt-2">QLBase includes powerful data analytics capabilities such as track identification, general tracking with event name and JSON payloads, page tracking with a specified page name and category, and making alias for users and anonymous users.</p>

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

    <div align="center">
        <img src="@/assets/qlbase-cat-6.png" width="50%" />
    </div>

    <h4 class="border-bottom">📡 Authentication API Calls</h4>

    <b class="mt-4 mb-2 d-block border-bottom fw-bold">Identification: Create</b>
    <p>Create new identification tracker with a specified timestamp.</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=id_create</pre>

    <p>Payload Structure:</p>
    <ul>
        <li><i>id</i> &mdash; The identification string of tracker. (Should be a-z or A-Z and greater than or equals to 6 characters)</li>
        <li><i>anonymous</i> &mdash; The anonymous string of tracker. (Should be a-z or A-Z and greater than or equals to 6 characters)</li>
        <li><i>username</i> &mdash; The username string of tracker. (Should be a-z, A-Z, 0-9, and greater than or equals to 6 characters)</li>
        <li><i>datetime</i> &mdash; Timestamp of the identification on the record. (Should be in format <i>Y-m-d H:i:s</i>)</li>
        <li><i>data</i> &mdash; Base64 string that contains a JSON data as payload.</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"tracker"</span>: <span class="text-danger">"&lt;id&gt;"</span>,
    <span class="text-warning">"anon_id"</span>: <span class="text-danger">"&lt;anonymous&gt;"</span>,
    <span class="text-warning">"user_id"</span>: <span class="text-danger">"&lt;user&gt;"</span>,
    <span class="text-warning">"timestamp"</span>: <span class="text-danger">"&lt;datetime&gt;"</span>,
    <span class="text-warning">"payload"</span>: <span class="text-danger">"&lt;data&gt;"</span>
<span class="text-primary">}</span></pre>

    <b class="mt-4 mb-2 d-block border-bottom fw-bold">Identification: Create with Timestamp</b>
    <p>Create new identification tracker with current date and time as timestamp.</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=id_create_live_timestamp</pre>

    <p>Payload Structure:</p>
    <ul>
        <li><i>id</i> &mdash; The identification string of tracker. (Should be a-z or A-Z and greater than or equals to 6 characters)</li>
        <li><i>anonymous</i> &mdash; The anonymous string of tracker. (Should be a-z or A-Z and greater than or equals to 6 characters)</li>
        <li><i>username</i> &mdash; The username string of tracker. (Should be a-z, A-Z, 0-9, and greater than or equals to 6 characters)</li>
        <li><i>data</i> &mdash; Base64 string that contains a JSON data as payload.</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"tracker"</span>: <span class="text-danger">"&lt;id&gt;"</span>,
    <span class="text-warning">"anon_id"</span>: <span class="text-danger">"&lt;anonymous&gt;"</span>,
    <span class="text-warning">"user_id"</span>: <span class="text-danger">"&lt;user&gt;"</span>,
    <span class="text-warning">"payload"</span>: <span class="text-danger">"&lt;data&gt;"</span>
<span class="text-primary">}</span></pre>

    <b class="mt-4 mb-2 d-block border-bottom fw-bold">Identification: Delete by Anonymous ID</b>
    <p>Deletes an identification by a specified anonymous ID.</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=id_delete_by_anon_id</pre>

    <p>Payload Structure:</p>
    <ul>
        <li><i>id</i> &mdash; The identification string of the tracker to be deleted. (Should be a-z or A-Z and greater than or equals to 6 characters)</li>
        <li><i>anonymous</i> &mdash; The anonymous string of the tracker to be deleted. (Should be a-z or A-Z and greater than or equals to 6 characters)</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"tracker"</span>: <span class="text-danger">"&lt;id&gt;"</span>,
    <span class="text-warning">"anon_id"</span>: <span class="text-danger">"&lt;anonymous&gt;"</span>
<span class="text-primary">}</span></pre>

    <b class="mt-4 mb-2 d-block border-bottom fw-bold">Identification: Delete by User ID</b>
    <p>Deletes an identification by a specified username.</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=id_delete_by_user_id</pre>

    <p>Payload Structure:</p>
    <ul>
        <li><i>id</i> &mdash; The identification string of the tracker to be deleted. (Should be a-z or A-Z and greater than or equals to 6 characters)</li>
        <li><i>username</i> &mdash; The username string of the tracker to be deleted. (Should be a-z, A-Z, 0-9, and greater than or equals to 6 characters)</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"tracker"</span>: <span class="text-danger">"&lt;id&gt;"</span>,
    <span class="text-warning">"user_id"</span>: <span class="text-danger">"&lt;user&gt;"</span>
<span class="text-primary">}</span></pre>

    <b class="mt-4 mb-2 d-block border-bottom fw-bold">Identification: Delete by Timestamp</b>
    <p>Deletes an identification by a specified timestamp.</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=id_delete_by_timestamp</pre>

    <p>Payload Structure:</p>
    <ul>
        <li><i>id</i> &mdash; The identification string of the tracker to be deleted. (Should be a-z or A-Z and greater than or equals to 6 characters)</li>
        <li><i>datetime</i> &mdash; Timestamp of the identification on the record. (Should be in format <i>Y-m-d H:i:s</i>)</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"tracker"</span>: <span class="text-danger">"&lt;id&gt;"</span>,
    <span class="text-warning">"timestamp"</span>: <span class="text-danger">"&lt;datetime&gt;"</span>
<span class="text-primary">}</span></pre>

    <b class="mt-4 mb-2 d-block border-bottom fw-bold">Identification: Get by Anonymous ID</b>
    <p>Fetches an identification by a specified anonymous ID.</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=id_get_by_anon_id</pre>

    <p>Payload Structure:</p>
    <ul>
        <li><i>anonymous</i> &mdash; The anonymous string of the tracker to be deleted. (Should be a-z or A-Z and greater than or equals to 6 characters)</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"anon_id"</span>: <span class="text-danger">"&lt;anonymous&gt;"</span>
<span class="text-primary">}</span></pre>

    <b>Response Data</b>
    <ul>
        <li>
            <i>value</i> &mdash; This key will contain a 2D array of identification tracks. The array of identification tracks' order of items is as the following table below:
            <table class="table table-hover">
                <tr>
                    <th>Array Index</th>
                    <th>Index Content</th>
                </tr>
                <tr>
                    <td>0</td>
                    <td>Tracker identification string</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Username string</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Timestamp of the identification tracker with the format &quot;<i>YYYY-mm-dd hh:mm:ss</i>&quot;</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>The data payload in JSON form.</td>
                </tr>
            </table>
        </li>
    </ul>

    <b class="mt-4 mb-2 d-block border-bottom fw-bold">Identification: Get by User ID</b>
    <p>Fetches an identification by a specified username.</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=id_get_by_user_id</pre>

    <p>Payload Structure:</p>
    <ul>
        <li><i>username</i> &mdash; The username string of tracker. (Should be a-z, A-Z, 0-9, and greater than or equals to 6 characters)</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"user_id"</span>: <span class="text-danger">"&lt;username&gt;"</span>
<span class="text-primary">}</span></pre>

    <b>Response Data</b>
    <ul>
        <li>
            <i>value</i> &mdash; This key will contain a 2D array of identification tracks. The array of identification tracks' order of items is as the following table below:
            <table class="table table-hover">
                <tr>
                    <th>Array Index</th>
                    <th>Index Content</th>
                </tr>
                <tr>
                    <td>0</td>
                    <td>Tracker identification string</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Anonymous ID string</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Timestamp of the identification tracker with the format &quot;<i>YYYY-mm-dd hh:mm:ss</i>&quot;</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>The data payload in JSON form.</td>
                </tr>
            </table>
        </li>
    </ul>

    <b class="mt-4 mb-2 d-block border-bottom fw-bold">Identification: Get by Timestamp</b>
    <p>Fetches an identification by a specified timestamp.</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=id_get_by_timestamp</pre>

    <p>Payload Structure:</p>
    <ul>
        <li><i>datetime</i> &mdash; Timestamp of the identification on the record. (Should be in format <i>Y-m-d H:i:s</i>)</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"timestamp"</span>: <span class="text-danger">"&lt;datetime&gt;"</span>
<span class="text-primary">}</span></pre>

    <b>Response Data</b>
    <ul>
        <li>
            <i>value</i> &mdash; This key will contain a 2D array of identification tracks. The array of identification tracks' order of items is as the following table below:
            <table class="table table-hover">
                <tr>
                    <th>Array Index</th>
                    <th>Index Content</th>
                </tr>
                <tr>
                    <td>0</td>
                    <td>Tracker identification string</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Anonymous ID string</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Username string</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>The data payload in JSON form.</td>
                </tr>
            </table>
        </li>
    </ul>

    <b class="mt-4 mb-2 d-block border-bottom fw-bold">Identification: Fetch All</b>
    <p>Fetches all recorded identification trackers.</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=id_fetch_all</pre>

    <b>Example Payload</b>
    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{}</span></pre>

    <b>Response Data</b>
    <ul>
        <li>
            <i>value</i> &mdash; This key will contain a 2D array of all identification tracks recorded. The array of identification tracks' order of items is as the following table below:
            <table class="table table-hover">
                <tr>
                    <th>Array Index</th>
                    <th>Index Content</th>
                </tr>
                <tr>
                    <td>0</td>
                    <td>Tracker identification string</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Anonymous ID string</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Username string</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Timestamp of the identification tracker with the format &quot;<i>YYYY-mm-dd hh:mm:ss</i>&quot;</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>The data payload in JSON form.</td>
                </tr>
            </table>
        </li>
    </ul>

    <b class="mt-4 mb-2 d-block border-bottom fw-bold">Track: Create New</b>
    <p>Creates a new tracker for data analytics with a specified timestamp.</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=track_create</pre>

    <p>Payload Structure:</p>
    <ul>
        <li><i>id</i> &mdash; The identification string of tracker. (Should be a-z or A-Z and greater than or equals to 6 characters)</li>
        <li><i>anonymous</i> &mdash; The anonymous string of tracker. (Should be a-z or A-Z and greater than or equals to 6 characters)</li>
        <li><i>username</i> &mdash; The username string of tracker. (Should be a-z, A-Z, 0-9, and greater than or equals to 6 characters)</li>
        <li><i>tag</i> &mdash; The event name string of tracker. (Should be a-z, A-Z, 0-9, and greater than or equals to 6 characters)</li>
        <li><i>datetime</i> &mdash; Timestamp of the identification on the record. (Should be in format Y-m-d H:i:s)</li>
        <li><i>data</i> &mdash; Base64 string that contains a JSON data as payload.</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"tracker"</span>: <span class="text-danger">"&lt;id&gt;"</span>,
    <span class="text-warning">"anon_id"</span>: <span class="text-danger">"&lt;anonymous&gt;"</span>,
    <span class="text-warning">"user_id"</span>: <span class="text-danger">"&lt;username&gt;"</span>,
    <span class="text-warning">"event"</span>: <span class="text-danger">"&lt;tag&gt;"</span>,
    <span class="text-warning">"timestamp"</span>: <span class="text-danger">"&lt;datetime&gt;"</span>,
    <span class="text-warning">"payload"</span>: <span class="text-danger">"&lt;data&gt;"</span>
<span class="text-primary">}</span></pre>

    <b class="mt-4 mb-2 d-block border-bottom fw-bold">Track: Create New with Timestamp</b>
    <p>Creates a new tracker for data analytics with the current time and date as timestamp.</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=track_create_live_timestamp</pre>

    <p>Payload Structure:</p>
    <ul>
        <li><i>id</i> &mdash; The identification string of tracker. (Should be a-z or A-Z and greater than or equals to 6 characters)</li>
        <li><i>anonymous</i> &mdash; The anonymous string of tracker. (Should be a-z or A-Z and greater than or equals to 6 characters)</li>
        <li><i>username</i> &mdash; The username string of tracker. (Should be a-z, A-Z, 0-9, and greater than or equals to 6 characters)</li>
        <li><i>tag</i> &mdash; The event name string of tracker. (Should be a-z, A-Z, 0-9, and greater than or equals to 6 characters)</li>
        <li><i>data</i> &mdash; Base64 string that contains a JSON data as payload.</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"tracker"</span>: <span class="text-danger">"&lt;id&gt;"</span>,
    <span class="text-warning">"anon_id"</span>: <span class="text-danger">"&lt;anonymous&gt;"</span>,
    <span class="text-warning">"user_id"</span>: <span class="text-danger">"&lt;username&gt;"</span>,
    <span class="text-warning">"event"</span>: <span class="text-danger">"&lt;tag&gt;"</span>,
    <span class="text-warning">"payload"</span>: <span class="text-danger">"&lt;data&gt;"</span>
<span class="text-primary">}</span></pre>

    <b class="mt-4 mb-2 d-block border-bottom fw-bold">Track: Delete by Anonymous ID</b>
    <p>Delete tracker record by anonymous ID.</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=track_delete_by_anon_id</pre>

    <p>Payload Structure:</p>
    <ul>
        <li><i>id</i> &mdash; The identification string of the tracker to be deleted. (Should be a-z or A-Z and greater than or equals to 6 characters)</li>
        <li><i>anonymous</i> &mdash; The anonymous string of the tracker to be deleted. (Should be a-z or A-Z and greater than or equals to 6 characters)</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"tracker"</span>: <span class="text-danger">"&lt;id&gt;"</span>,
    <span class="text-warning">"anon_id"</span>: <span class="text-danger">"&lt;anonymous&gt;"</span>
<span class="text-primary">}</span></pre>

    <b class="mt-4 mb-2 d-block border-bottom fw-bold">Track: Delete by User ID</b>
    <p>Delete tracker record by user ID.</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=track_delete_by_user_id</pre>

    <p>Payload Structure:</p>
    <ul>
        <li><i>id</i> &mdash; The identification string of the tracker to be deleted. (Should be a-z or A-Z and greater than or equals to 6 characters)</li>
        <li><i>user</i> &mdash; The username string of the tracker to be deleted. (Should be a-z or A-Z and greater than or equals to 6 characters)</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"tracker"</span>: <span class="text-danger">"&lt;id&gt;"</span>,
    <span class="text-warning">"user_id"</span>: <span class="text-danger">"&lt;user&gt;"</span>
<span class="text-primary">}</span></pre>

    <b class="mt-4 mb-2 d-block border-bottom fw-bold">Track: Delete by Event</b>
    <p>Delete tracker record(s) by event tag.</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=track_delete_by_event</pre>

    <p>Payload Structure:</p>
    <ul>
        <li><i>id</i> &mdash; The identification string of the tracker to be deleted. (Should be a-z or A-Z and greater than or equals to 6 characters)</li>
        <li><i>tag</i> &mdash; The event name string of the tracker to be deleted. (Should be a-z or A-Z and greater than or equals to 6 characters)</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"tracker"</span>: <span class="text-danger">"&lt;id&gt;"</span>,
    <span class="text-warning">"event"</span>: <span class="text-danger">"&lt;tag&gt;"</span>
<span class="text-primary">}</span></pre>

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