<?php
    $appId = "";
    $apiKey = "";

    if(isset($_COOKIE["sess_id"]) && !empty($_COOKIE["sess_id"]) &&
        isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === "POST") {
        include_once("controller/apps.php");
        include_once("./controller/validator.php");

        $id = $_POST["app_id"];
        $key = $_POST["api_key"];

        if(Apps::validateId($id) || validateApiKey($key)) {
            $appId = $id;
            $apiKey = $key;
        }
    }
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8" />
    <meta name="description" content="QLBase" />
    <meta name="keywords" content="nthnn" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>API Sandbox</title>

    <link href="./favicon.ico" rel="shortcut icon" />
    <link href="./styles/bootstrap.min.css" rel="stylesheet" />
    <link href="./styles/global.css" rel="stylesheet" />

    <style>
        #receiver, #contents, #http-headers { resize: none; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-primary">
        <div class="container-fluid">
            <span class="navbar-brand text-white">QLBase API Sandbox</span>
        </div>
    </nav>

    <div class="mt-4 container">
        <div class="row">
            <div class="col-lg-6">
                <b>API Action:</b>
                <select id="action" class="form-control">
                </select>
                <br/>

                <b>Contents:</b>
                <div id="content" class="form-control p-0 m-0"></div>
                <br/>

                <b>HTTP Headers:</b>
                <div id="http-headers" class="form-control p-0 m-0" data-keys="{&quot;QLBase-API-Key&quot;: &quot;<?php echo $apiKey; ?>&quot;,&quot;QLBase-App-ID&quot;: &quot;<?php echo $appId; ?>&quot;}"></div>
                <br/>

                <div class="row">
                    <div class="col-md-3 col-sm-12">
                        <button class="btn btn-primary w-100" id="send">Send Request</button>
                    </div>

                    <div class="col-md-9 col-sm-12">
                        <div class="pt-lg-0 pt-2"></div>

                        <label for="subject" class="btn btn-primary disabled w-100" id="subject-label">Choose File</label>
                        <input type="file" id="subject" name="subject" class="d-none" disabled="true" />
                    </div>
                </div>
                <br/>

                <div class="mobile-only">
                    <br/><hr/>
                </div>
            </div>

            <div class="col-lg-6">
                <b>Response:</b>
                <div id="response" class="form-control p-0 m-0" style="min-height: 100px"></div>

                <div class="mobile-only">
                    <br/><br/>
                </div>
            </div>
        </div>
    </div>

    <script src="scripts/vendors/bootstrap.bundle.min.js"></script>
    <script src="scripts/vendors/jquery.min.js"></script>
    <script src="scripts/rotating-button.js"></script>
    <script src="scripts/sandbox.js" type="module"></script>
</body>