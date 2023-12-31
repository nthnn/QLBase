<template>
    <h1 class="border-bottom">🚀 Deployment</h1>
    <div class="row">
        <div class="col-md-6">
            <p>Deploying QLBase is a straightforward and hassle-free process that can be executed on virtually any system, provided it possesses the capability to run both the Apache and MySQL server, two fundamental components for QLBase to operate seamlessly.</p>
            <p>To initiate the deployment, all you need to do is follow the comprehensive instructional guide outlined below, ensuring that each step is executed with precision and attention to detail.</p>
            <p>The user-friendly nature of QLBase's deployment procedure, combined with the clear and concise instructions, makes it accessible even for those with limited technical expertise, ensuring a smooth and successful setup on your system.</p>
        </div>

        <div class="col-md-6">
            <img src="@/assets/qlbase-cat-1.png" width="100%" />
        </div>
    </div>
    <br/>

    <h3 class="border-bottom">💼 Software Requirements</h3>
    <p>QLBase requires several software from downloading its repository to building and running.</p>
    <ul>
        <li><a href="https://git-scm.com" target="_blank" class="text-decoration-none">Git</a> &mdash; Free and open source distributed version control system designed to handle everything.</li>
        <li><a href="https://go.dev" target="_blank" class="text-decoration-none">Go Compiler</a> &mdash; Open-source programming language supported by Google.</li>
        <li><a href="https://github.com/nthnn/QLBase" target="_blank" class="text-decoration-none">Qrepo</a> &mdash; Simple and easy-to-use all-for-one build tool for Windows, Linux, and macOS.</li>
        <li><a href="https://nodejs.org/en" target="_blank" class="text-decoration-none">NodeJS</a> &mdash; An open-source, cross-platform JavaScript runtime environment.</li>
        <li><a href="https://www.apachefriends.org" target="_blank" class="text-decoration-none">XAMPP</a> &mdash; Completely free, easy to install Apache distribution containing MariaDB, PHP, and Perl.</li>
    </ul>
    <br/>

    <h3 class="border-bottom">📥 Downloading the Repository</h3>
    <p>Open any terminal on your system and then follow the steps below:</p>
    <ol>
        <li>
            <p>Clone the QLBase repository from GitHub.</p>
            <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">git</span> clone https://github.com/nthnn/QLBase</pre>
        </li>
        <li>
            <p>Change the working directory to the cloned folder.</p>
            <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">cd</span> QLBase</pre>
        </li>
    </ol>
    <p>If nothing went wrong, you have now downloaded the QLBase repository and should proceed to the section below.</p>
    <br/>

    <h3 class="border-bottom">🏗️ Building from Source</h3>
    <p>To simplify the deployment process of QLBase, a <span class="bg-secondary border-gray border rounded p-1 d-inline">deploy.sh</span> bash script is provided. This script is designed to package all the deployment-important files and assets and builds the back-end apps, ensuring a smooth deployment experience.</p>
    <ol>
        <li>
            <p>Ensure your Go compiler and NodeJS installation first before proceeding.</p>
            <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">go</span> version
<span class="text-primary">node</span> -v</pre>
        </li>
        <li>
            <p>Before running the deployment Bash script, it is important to set the appropriate file permissions first. It can be done by typing the following:</p>
            <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">sudo</span> chmod -R 777 ./deploy.sh</pre>
        </li>
        <li>
            <p>Now, run the deployment script and wait for it to finish. This script will build all the back-end software, documentations, and will compile all necessary files into a zip file output.</p>
            <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">./deploy.sh</span></pre>
            <p>If it runs successfully, it will generate a zip file named <span class="bg-secondary border-gray border rounded p-1 d-inline">qlbase.zip</span>. Extract this zip file to the root of your Apache server and proceed to the next step.</p>
        </li>
        <li>
            <p>Open the file named <span class="bg-secondary border-gray border rounded p-1 d-inline">config.ini</span> inside the folder <span class="bg-secondary border-gray border rounded p-1 d-inline">bin</span>. The file contains the following configurations:</p>
            <pre class="bg-secondary border-gray border rounded p-2"><span class="text-warning">[database]</span>
<span class="text-danger">server</span>=<span class="text-success">localhost</span>
<span class="text-danger">username</span>=<span class="text-success">root</span>
<span class="text-danger">password</span>=
<span class="text-danger">name</span>=<span class="text-success">qlbase_apps</span>
<span class="text-danger">port</span>=<span class="text-success">3306</span>

[smtp]
<span class="text-danger">host</span>&#61;<span class="text-success">&lt;smtp host&gt;</span>
<span class="text-danger">port</span>&#61;<span class="text-success">&lt;smtp port&gt;</span>
<span class="text-danger">from</span>&#61;<span class="text-success">&lt;smtp email&gt;</span>
<span class="text-danger">password</span>&#61;<span class="text-success">&lt;smtp password&gt;</span>

[env]
<span class="text-danger">home</span>=<span class="text-success">http://localhost:8080/QLBase</span></pre>
            <p>The database section defines the MySQL server, username, password, database name, and the server port. While the SMTP server defines the host address/name, server port, from (email address of origin), and password; this SMTP configuration will be used as email gateway for recovering forgotten passwords of users. And lastly, the environment section defines the root URL of the current QLBase runtime.</p>
        </li>
        <li>
            <p>On UNIX-based and UNIX-like operating systems (such as Linux and OSX), you are required to change the permissions of binary files inside the <span class="bg-secondary border-gray border rounded p-1 d-inline">bin</span> folder. Changing permissions can be done by opening the <span class="bg-secondary border-gray border rounded p-1 d-inline">bin</span> folder in the terminal and typing the following:</p>
            <pre class="bg-secondary border-gray border rounded p-2"><span class="text-primary">sudo</span> chmod -R 777 .</pre>
        </li>
        <li><p>Go back to the cloned folder of QLBase and look for the file named <span class="bg-secondary border-gray border rounded p-1 d-inline">db.sql</span>. Copy its contents and then paste and execute it to your MySQL server's terminal.</p></li>
        <li><p>Cheers! 🥂 You can now open and enjoy your installed QLBase decentralized server!</p></li>
    </ol>

    <hr/>
    <div class="row">
        <div class="col-6">
            <RouterLink to="/" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-right mb-1" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                    <path fill-rule="evenodd" d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                </svg>

                What is QLBase?
            </RouterLink>
        </div>

        <div class="col-6">
            <div align="right">
                <RouterLink to="/firmware" class="btn btn-primary">
                    The Firmware

                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-right mb-1" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708z"/>
                        <path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708z"/>
                    </svg>
                </RouterLink>
            </div>
        </div>
    </div>
</template>