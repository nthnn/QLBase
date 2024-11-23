<template>
    <div class="row border-bottom">
        <div class="col-lg-6">
            <h3>🗃️ Database System</h3>
        </div>

        <div class="col-lg-6 desktop-only" align="right">
            <div class="pt-2">
                <a href="https://github.com/nthnn/QLBase/blob/main/documentations/src/views/Database.vue"
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

    <p class="mt-2">QLBase offers a comprehensive database storage solution designed to meet the needs of modern applications. With its scalable and reliable architecture, QLBase provides users with robust data management capabilities, leveraging MySQL as the internal database engine.</p>

    <div class="row">
        <div class="col-lg-6 col-md-6">
            <div align="center">
                <img src="@/assets/qlbase-cat-7.png" width="85%" />
            </div>
        </div>

        <div class="col-lg-6 col-md-6">
            <br class="desktop-only" />
            <ol>
                <li><b>CRUD Operations:</b> QLBase supports essential CRUD (Create, Read, Update, Delete) operations, empowering users to manage their data efficiently within the MySQL database.</li>
                <li><b>Scalability:</b> QLBase's database storage is designed to scale seamlessly as data volumes grow within the MySQL environment, accommodating growing datasets without sacrificing performance or reliability.</li>
            </ol>
        </div>
    </div>

    <ol start="3">
        <li><b>Inter-API Communication:</b> The API provided by QLBase exposes data in JSON format, allowing seamless integration with client applications. This JSON-based API simplifies data exchange and enables interoperability with a wide range of programming languages and platforms.</li>
    </ol>
    <br/>

    <h4 class="border-bottom">📡 Authentication API Calls</h4>

    <b class="mt-4 mb-2 d-block border-bottom fw-bold">Database: Create</b>
    <p>Create new JSON-based data storage database.</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=db_create</pre>

    <p>Payload Structure:</p>
    <ul>
        <li><i>database</i> &mdash; The database name to be created. (Should be a-z or A-Z and greater than or equals to 6 characters)</li>
        <li><i>permissions</i> &mdash; The database mode permissions; must be only either &quot;w&quot;, &quot;r&quot;, &quot;wr&quot;, or &quot;rw&quot;. (&quot;w&quot; for writing permission and &quot;r&quot; for reading permission)</li>
        <li><i>data</i> &mdash; Base64 string that contains a JSON database.</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"name"</span>: <span class="text-danger">"&lt;database&gt;"</span>,
    <span class="text-warning">"mode"</span>: <span class="text-danger">"&lt;permissions&gt;"</span>,
    <span class="text-warning">"content"</span>: <span class="text-danger">"&lt;data&gt;"</span>
<span class="text-primary">}</span></pre>

    <b class="mt-4 mb-2 d-block border-bottom fw-bold">Database: Get by Name</b>
    <p>Fetch database permissions and stored data content by name.</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=db_get_by_name</pre>

    <p>Payload Structure:</p>
    <ul>
        <li><i>database</i> &mdash; The database name to be fetched. (Should be a-z or A-Z and greater than or equals to 6 characters)</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"name"</span>: <span class="text-danger">"&lt;database&gt;"</span>
<span class="text-primary">}</span></pre>

    <b>Response Data</b>
    <ul>
        <li>
            <i>value</i> &mdash; This key will contain a 2D array of fetched database informations.
            <table class="table table-hover">
                <tr>
                    <th>Array Index</th>
                    <th>Index Content</th>
                </tr>
                <tr>
                    <td>0</td>
                    <td>The database mode permissions; either "w", "r", "wr", or "rw". ("w" for writing permission and "r" for reading permission)</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Base64 string that contains a JSON database</td>
                </tr>
            </table>
        </li>
    </ul>

    <b class="mt-4 mb-2 d-block border-bottom fw-bold">Database: Set Mode</b>
    <p>Set new permissions to a database by name.</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=db_set_mode</pre>

    <p>Payload Structure:</p>
    <ul>
        <li><i>database</i> &mdash; The database name where the new permissions will be made. (Should be a-z or A-Z and greater than or equals to 6 characters)</li>
        <li><i>permissions</i> &mdash; The database mode new permissions; must be only either &quot;w&quot;, &quot;r&quot;, &quot;wr&quot;, or &quot;rw&quot;. (&quot;w&quot; for writing permission and &quot;r&quot; for reading permission)</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"name"</span>: <span class="text-danger">"&lt;database&gt;"</span>,
    <span class="text-warning">"mode"</span>: <span class="text-danger">"&lt;permissions&gt;"</span>
<span class="text-primary">}</span></pre>

    <b class="mt-4 mb-2 d-block border-bottom fw-bold">Database: Get Mode</b>
    <p>Get designated permissions of a database by name.</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=db_get_mode</pre>

    <p>Payload Structure:</p>
    <ul>
        <li><i>database</i> &mdash; The database name to be fetched. (Should be a-z or A-Z and greater than or equals to 6 characters)</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"name"</span>: <span class="text-danger">"&lt;database&gt;"</span>
<span class="text-primary">}</span></pre>

    <b>Response Data</b>
    <ul>
        <li><i>value</i> &mdash; This key will contain database mode permissions of the specified database name; either "w", "r", "wr", or "rw". ("w" for writing permission and "r" for reading permission)</li>
    </ul>

    <b class="mt-4 mb-2 d-block border-bottom fw-bold">Database: Read Content</b>
    <p>Fetch the whole stored data from a specified database name.</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=db_read</pre>

    <p>Payload Structure:</p>
    <ul>
        <li><i>database</i> &mdash; The database name to be fetched. (Should be a-z or A-Z and greater than or equals to 6 characters)</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"name"</span>: <span class="text-danger">"&lt;database&gt;"</span>
<span class="text-primary">}</span></pre>

    <b>Response Data</b>
    <ul>
        <li><i>value</i> &mdash; This key will contain database in JSON object form.</li>
    </ul>

    <b class="mt-4 mb-2 d-block border-bottom fw-bold">Database: Write Content</b>
    <p>Overwrite the whole stored data contents of a specified database name.</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=db_write</pre>

    <p>Payload Structure:</p>
    <ul>
        <li><i>database</i> &mdash; The database name to be fetched. (Should be a-z or A-Z and greater than or equals to 6 characters)</li>
        <li><i>data</i> &mdash; Base64 string that contains a JSON database.</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"name"</span>: <span class="text-danger">"&lt;database&gt;"</span>,
    <span class="text-warning">"content"</span>: <span class="text-danger">"&lt;data&gt;"</span>
<span class="text-primary">}</span></pre>

    <b class="mt-4 mb-2 d-block border-bottom fw-bold">Database: Write Content</b>
    <p>Overwrite the whole stored data contents of a specified database name.</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=db_write</pre>

    <p>Payload Structure:</p>
    <ul>
        <li><i>database</i> &mdash; The database name to be fetched. (Should be a-z or A-Z and greater than or equals to 6 characters)</li>
        <li><i>data</i> &mdash; Base64 string that contains a JSON database.</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"name"</span>: <span class="text-danger">"&lt;database&gt;"</span>,
    <span class="text-warning">"content"</span>: <span class="text-danger">"&lt;data&gt;"</span>
<span class="text-primary">}</span></pre>

<b class="mt-4 mb-2 d-block border-bottom fw-bold">Database: Delete</b>
    <p>Delete a whole database by a specified name.</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=db_delete</pre>
    <div class="alert alert-danger">
        <p class="mb-0">This action cannot be reversed.</p>
    </div>

    <p>Payload Structure:</p>
    <ul>
        <li><i>database</i> &mdash; The database name to be fetched. (Should be a-z or A-Z and greater than or equals to 6 characters)</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"name"</span>: <span class="text-danger">"&lt;database&gt;"</span>
<span class="text-primary">}</span></pre>

    <b class="mt-4 mb-2 d-block border-bottom fw-bold">Database: Fetch All</b>
    <p>Fetch all database list of names and permissions.</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=db_fetch_all</pre>

    <b>Example Payload</b>
    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{}</span></pre>

    <b>Response Data</b>
    <ul>
        <li>
            <i>value</i> &mdash; This key will contain a 2D array of fetched database names and permissions.
            <table class="table table-hover">
                <tr>
                    <th>Array Index</th>
                    <th>Index Content</th>
                </tr>
                <tr>
                    <td>0</td>
                    <td>The name of the fetched database.</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>The database mode permissions; either "w", "r", "wr", or "rw". ("w" for writing permission and "r" for reading permission)</td>
                </tr>
            </table>
        </li>
    </ul>

    <div class="row">
        <div class="col-6">
            <RouterLink to="/data-analytics" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-right mb-1" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                    <path fill-rule="evenodd" d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                </svg>

                Data Analytics
            </RouterLink>
        </div>

        <div class="col-6">
            <div align="right">
                <RouterLink to="/file-storage" class="btn btn-primary">
                    File Storage

                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-right mb-1" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708z"/>
                        <path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708z"/>
                    </svg>
                </RouterLink>
            </div>
        </div>
    </div>
</template>