<template>
    <div class="row border-bottom">
        <div class="col-lg-6">
            <h3>☁️ Cloud Storage</h3>
        </div>

        <div class="col-lg-6 desktop-only" align="right">
            <div class="pt-2">
                <a href="https://github.com/nthnn/QLBase/blob/main/documentations/src/views/FileStorage.vue"
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

    <p class="mt-2">QLBase incorporates a sophisticated cloud file storage system designed to streamline file management tasks within your application. With its cloud-based architecture, QLBase offers a reliable and scalable solution for storing and accessing files securely.</p>

    <div class="row">
        <div class="col-lg-6 col-md-6">
            <div align="center">
                <img src="@/assets/qlbase-cat-8.png" width="85%" />
            </div>
        </div>

        <div class="col-lg-6 col-md-6">
            <br class="desktop-only" />
            <ol>
                <li><b>File Uploads:</b> QLBase simplifies the process of uploading files, allowing users to effortlessly upload various types of files, including images, documents, and media.</li>
                <li><b>File Retrieval:</b> Retrieve files securely using unique file identifiers generated by QLBase. With robust file retrieval capabilities, users can easily access uploaded files whenever needed, ensuring seamless integration with client applications and efficient file management workflows.</li>
            </ol>
        </div>
    </div>

    <ol start="3">
        <li><b>Reliability:</b> QLBase leverages cloud infrastructure to provide scalable and reliable file storage capabilities. By utilizing cloud services, QLBase ensures that your application can handle growing volumes of files without compromising performance or reliability.</li>
        <li><b>Data Security and Compliance:</b> Security is paramount when it comes to file storage, and QLBase prioritizes data security and compliance with industry standards. QLBase employs robust encryption mechanisms to safeguard files at rest, ensuring that sensitive data remains protected against unauthorized access.</li>
    </ol>
    <br/>

    <h4 class="border-bottom">📡 Authentication API Calls</h4>

    <b class="mt-4 mb-2 d-block border-bottom fw-bold">Storage: File Upload</b>
    <p>Uploads a file to be stored on the server. The file must be uploaded included in the form via POST method.</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=file_upload</pre>

    <b>Example Payload</b>
    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{}</span></pre>

    <div class="alert alert-warning">
        The POST request method should contain the file with the name <i>&quot;subject&quot; on the request data.</i>
    </div>

    <b>Response Data</b>
    <ul>
        <li><i>value</i> &mdash; The name in base-64 form of the file in the server. This is the key string used when performing actions to the associated file.</li>
    </ul>

    <b class="mt-4 mb-2 d-block border-bottom fw-bold">Storage: File Delete</b>
    <p>Delete a stored file on the server via assigned name.</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=file_delete</pre>

    <p>Payload Structure:</p>
    <ul>
        <li><i>assigned_name</i> &mdash; The assigned name of the file to be deleted.</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"name"</span>: <span class="text-danger">"&lt;assigned_name&gt;"</span>
<span class="text-primary">}</span></pre>

    <b class="mt-4 mb-2 d-block border-bottom fw-bold">Storage: File Fetch</b>
    <p>Fetch information from a stored file on the server via assigned name.</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=file_get</pre>

    <p>Payload Structure:</p>
    <ul>
        <li><i>assigned_name</i> &mdash; The assigned name of the file to be fetched.</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"name"</span>: <span class="text-danger">"&lt;assigned_name&gt;"</span>
<span class="text-primary">}</span></pre>

    <b>Response Data</b>
    <ul>
        <li>
            <i>value</i> &mdash; This key will contain a 2D array of fetched file information
            <table class="table table-hover">
                <tr>
                    <th>Array Index</th>
                    <th>Index Content</th>
                </tr>
                <tr>
                    <td>0</td>
                    <td>Original file name when it was uploaded</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>File mime type of the fetched file</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Checksum of the fetched file in SHA-512 hash</td>
                </tr>
            </table>
        </li>
    </ul>

    <b class="mt-4 mb-2 d-block border-bottom fw-bold">Storage: File Download</b>
    <p>Generate a CDP-accessible ticket for a specified stored file on the server via assigned name. If successful, the file will be accessible on <span class="bg-secondary px-1 border d-inline">api/cdp.php?ticket=&lt;generated_ticket&gt;</span></p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=file_download</pre>

    <p>Payload Structure:</p>
    <ul>
        <li><i>assigned_name</i> &mdash; The assigned name of the file for the ticket to be generated.</li>
        <li><i>expiring</i> &mdash; Boolean value to specify if the ticket will expire. (<i>0</i> for <i>false</i> and <i>1</i> for <i>true</i>)</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"name"</span>: <span class="text-danger">"&lt;assigned_name&gt;"</span>,
    <span class="text-warning">"should_expire"</span>: <span class="text-danger">"&lt;expiring&gt;"</span>
<span class="text-primary">}</span></pre>

    <b>Response Data</b>
    <ul>
        <li><i>value</i> &mdash; The ticket string in UUID form for the CDP-accessible file.</li>
    </ul>

    <b class="mt-4 mb-2 d-block border-bottom fw-bold">Storage: File Fetch All</b>
    <p>Fetch the assigned name, original file name, mime type, and the checksum of all the uploaded files.</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=file_fetch_all</pre>

    <b>Example Payload</b>
    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{}</span></pre>

    <b>Response Data</b>
    <ul>
        <li>
            <i>value</i> &mdash; This key will contain a 2D array of all the fetched file information
            <table class="table table-hover">
                <tr>
                    <th>Array Index</th>
                    <th>Index Content</th>
                </tr>
                <tr>
                    <td>0</td>
                    <td>Assigned file name for the fetched file</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Original file name when it was uploaded</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>File mime type of the fetched file</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Checksum of the fetched file in SHA-512 hash</td>
                </tr>
            </table>
        </li>
    </ul>

    <b class="mt-4 mb-2 d-block border-bottom fw-bold">CDP: Expire All</b>
    <p>Expire all the tickets generated for the CDP (Content Delivery Page). This action will revoke all the generated tickets including the no expiration tickets.</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=cdp_expire_all</pre>

    <b>Example Payload</b>
    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{}</span></pre>

    <b class="mt-4 mb-2 d-block border-bottom fw-bold">CDP: Expire Ticket</b>
    <p>Revoke a specified generated ticket for the CDP (Content Delivery Page).</p>
    <pre class="bg-secondary border-gray border rounded p-2">api/index.php?action=cdp_expire_ticket</pre>

    <p>Payload Structure:</p>
    <ul>
        <li><i>id</i> &mdash; The generated ticket to be revoked.</li>
    </ul>

    <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">{</span>
    <span class="text-warning">"ticket"</span>: <span class="text-danger">"&lt;id&gt;"</span>
<span class="text-primary">}</span></pre>

    <div class="row">
        <div class="col-6">
            <RouterLink to="/database" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-right mb-1" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                    <path fill-rule="evenodd" d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                </svg>

                Database
            </RouterLink>
        </div>

        <div class="col-6">
            <div align="right">
                <RouterLink to="/webapp" class="btn btn-primary">
                    Webapp Basics

                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-right mb-1" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708z"/>
                        <path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708z"/>
                    </svg>
                </RouterLink>
            </div>
        </div>
    </div>
</template>