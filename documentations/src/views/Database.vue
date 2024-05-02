<template>
    <h3 class="border-bottom">🗃️ Database System</h3>
    <p>QLBase offers a comprehensive database storage solution designed to meet the needs of modern applications. With its scalable and reliable architecture, QLBase provides users with robust data management capabilities, leveraging MySQL as the internal database engine.</p>

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
    <hr/>
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