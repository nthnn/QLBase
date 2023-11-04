<template>
    <h1 class="border-bottom">🤝 Contributing and Contributors</h1>
    <p>All contributions are welcome to make QLBase even better. Whether you want to report a bug, suggest new features, or contribute code, your contributions are highly appreciated.</p>
    <br/>

    <h3 class="border-bottom">🐞 Issue Reporting</h3>
    <p>If you come across a bug, have a feature request, or wish to propose enhancements, we kindly encourage you to initiate the process by opening an issue on our <a href="https://github.com/nthnn/QLBase/issues" target="_blank" class="text-decoration-none">GitHub Issue Tracker</a>. Your feedback is invaluable in helping us refine and enhance the QLBase. To ensure we can address your concern effectively, we kindly request that you include as much pertinent information as possible. This may encompass a detailed description of the issue or feature request, and if applicable, specific steps to replicate the problem.</p>
    <p>Your thorough input enables us to better understand and resolve the matter swiftly, contributing to the overall improvement of QLBase. Thank you for your contributions and for helping us create a more robust and user-friendly environment.</p>
    <br/>

    <h3 class="border-bottom">🛠️ Pull Requests</h3>
    <p>If you're eager to get involved and contribute your coding expertise to QLBase, we're thrilled to have you on board! To ensure a smooth and collaborative process, here's an outlined the following steps that you can follow:</p>
    <ol>
        <li>
            <p>Fork the QLBase repository to your GitHub account. And then clone it to your local machine.</p>
            <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">git</span> clone https://github.com/&lt;your username&gt;/QLBase.git</pre>
        </li>
        <li>
            <p>Create a new branch for your changes:</p>
            <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">git</span> checkout -b feature/&lt;your feature name&gt;</pre>
        </li>
        <li>You can now make changes to the repository.</li>
        <li>
            <p>Commit your changes:</p>
            <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">git</span> add -A
<span class="text-primary">git</span> commit -m &quot;Add your meaningful commit message here&quot;</pre>
        </li>
        <li>
            <p>Push your changes to your forked repository:</p>
            <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">git</span> push origin feature/&lt;your feature name&gt;</pre>
        </li>
        <li>Create a pull request (PR) from your branch to the main branch of the QLBase repository.</li>
        <li>Your PR will be reviewed, and any necessary changes will be discussed and implemented.</li>
        <li>Once your PR is approved, it will be merged into the main branch, and your contribution will be part of QLBase.</li>
    </ol>
    <br/>

    <h3 class="border-bottom">👥Contributors</h3>
    <p>Finally, this section acknowledges and celebrates the individuals who have made significant contributions to the development and success of the project. Meet the dedicated and talented team members, developers, and collaborators who have played key roles in bringing QLBase to life and advancing its objectives.</p>
    <ul>
        <li><a href="https://github.com/nthnn" target="_blank" class="text-decoration-none">Nathanne Isip</a> &mdash; Original Author, Developer</li>
        <li><a href="https://instagram.com/lady.selenee" target="_blank" class="text-decoration-none">Lady Selene</a> &mdash; Artist, Illustrator</li>
    </ul>

    <hr/>
    <div class="row">
        <div class="col-6">
            <RouterLink to="/firmware" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-right mb-1" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                    <path fill-rule="evenodd" d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                </svg>

                The Firmware
            </RouterLink>
        </div>

        <div class="col-6">
            <div align="right">
                <RouterLink to="/intro-api" class="btn btn-primary">
                    Introduction to APIs

                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-right mb-1" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708z"/>
                        <path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708z"/>
                    </svg>
                </RouterLink>
            </div>
        </div>
    </div>
</template>